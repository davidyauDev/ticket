<?php

namespace App\Exports;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TicketsListExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $search;
    protected $filterType;
    protected $startDate;
    protected $endDate;
    protected $tipo;

    public function __construct($search = null, $filterType = null, $startDate = null, $endDate = null, $tipo = null)
    {
        $this->search = $search;
        $this->filterType = $filterType;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->tipo = $tipo;
    }

    public function collection()
    {
        $user = Auth::user();

        // Construir la misma consulta que se usa en render() pero sin paginación
        $tickets = Ticket::query();

        if ($user->role === 'admin' || $user->area_id === 1 || $user->area_id === 2) {
            // Admin puede ver todos los tickets con filtros globales
            $tickets->when($this->search, fn($q) => $q->where(function ($q2) {
                $q2->where('codigo', 'like', "%{$this->search}%")
                    ->orWhere('id', $this->search)
                    ->orWhere('osticket', 'like', "%{$this->search}%");
            }))
                ->when($this->filterType === 'solved', fn($q) => $q->where('estado_id', 5))
                ->when($this->filterType === 'pending', fn($q) => $q->where('estado_id', 1))
                ->when($this->filterType === 'paused', fn($q) => $q->where('estado_id', 6))
                ->when($this->filterType === 'anuled', fn($q) => $q->where('estado_id', 4))
                ->when(!in_array($this->filterType, ['solved', 'pending', 'paused', 'anuled']) && $this->filterType, fn($q) => $q->where('tipo', $this->filterType))
                ->when($this->startDate && $this->endDate, fn($q) => $q->whereBetween('created_at', [$this->startDate, $this->endDate]));
        } else {
            // Usuarios normales: filtrados por tipo y área
            $tickets->when($this->tipo === 'mis', function ($q) use ($user) {
                $q->where('assigned_to', $user->id);
            })
                ->when($this->tipo === 'pendientes', fn($q) => $q->where('area_id', $user->area_id)->whereNull('assigned_to'))
                ->when($this->tipo === 'todos', fn($q) => $q->where('area_id', $user->area_id))
                ->when($this->search, fn($q) => $q->where(function ($q2) {
                    $q2->where('codigo', 'like', "%{$this->search}%")
                        ->orWhere('id', $this->search)
                        ->orWhere('osticket', 'like', "%{$this->search}%");
                }))
                ->when($this->filterType === 'solved', fn($q) => $q->where('estado_id', 5))
                ->when($this->filterType === 'pending', fn($q) => $q->where('estado_id', 1))
                ->when($this->filterType === 'paused', fn($q) => $q->where('estado_id', 6))
                ->when(!in_array($this->filterType, ['solved', 'pending', 'paused']) && $this->filterType, fn($q) => $q->where('tipo', $this->filterType))
                ->when($this->startDate && $this->endDate, fn($q) => $q->whereBetween('created_at', [$this->startDate, $this->endDate]));
        }

        // Cargar relaciones necesarias
        $tickets->with([
            'equipo.modelo',
            'agencia',
            'assignedUser',
            'createdBy',
            'estado'
        ]);

        // Obtener todos los tickets sin paginación
        return $tickets->latest()->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Código',
            'Código OSTicket',
            'Técnico',
            'Equipo',
            'Serie',
            'Modelo',
            'Agencia',
            'Asignado a',
            'Creado por',
            'Estado',
            'Fecha de Creación',
            'Falla Reportada',
            'Tipo',
            'Comentarios'
        ];
    }

    public function map($ticket): array
    {
        return [
            $ticket->id,
            $ticket->codigo_formateado ?? $ticket->codigo,
            $ticket->osticket ?? 'N/A',
            $ticket->tecnico_nombres ? $ticket->tecnico_nombres . ' ' . $ticket->tecnico_apellidos : 'No asignado',
            $ticket->equipo ? ($ticket->equipo->serie . ' - ' . ($ticket->equipo->modelo->descripcion ?? 'Sin modelo')) : 'Sin equipo',
            $ticket->equipo->serie ?? 'N/A',
            $ticket->equipo->modelo->descripcion ?? 'N/A',
            $ticket->agencia->nombre ?? 'No especificada',
            $ticket->assignedUser->name ?? 'Sin asignar',
            $ticket->createdBy->name ?? 'N/A',
            ucfirst($ticket->estado->nombre ?? 'Sin estado'),
            $ticket->created_at ? $ticket->created_at->format('d/m/Y H:i') : 'Sin fecha',
            $ticket->falla_reportada ?? 'Sin información',
            $ticket->tipo ?? 'N/A',
            $ticket->comentario ?? 'Sin comentarios'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Estilo para la fila de encabezados
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '3B82F6']
                ]
            ],
        ];
    }

    public function title(): string
    {
        return 'Lista de Tickets';
    }

    /**
     * Método estático para facilitar la exportación desde el componente Livewire
     */
    public static function exportExcel($search = null, $filterType = null, $startDate = null, $endDate = null, $tipo = null)
    {
        // Generar nombre del archivo con fecha y filtros aplicados
        $fileName = 'tickets_' . now()->format('Y-m-d_H-i-s');
        if ($filterType) {
            $fileName .= '_' . $filterType;
        }
        $fileName .= '.xlsx';

        return \Maatwebsite\Excel\Facades\Excel::download(
            new self($search, $filterType, $startDate, $endDate, $tipo),
            $fileName
        );
    }
}
