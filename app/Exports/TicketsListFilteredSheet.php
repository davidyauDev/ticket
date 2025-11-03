<?php

namespace App\Exports;

use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TicketsListFilteredSheet implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $mes;

    public function __construct($mes = null)
    {
        $this->mes = $mes;
    }

    public function collection()
    {
        $query = Ticket::query();

        // Filtrar por mes si se especifica
        if ($this->mes) {
            $query->whereMonth('created_at', $this->mes)
                ->whereYear('created_at', now()->year);
        }

        // Cargar relaciones necesarias
        $query->with([
            'equipo.modelo',
            'agencia',
            'assignedUser',
            'createdBy',
            'estado'
        ]);

        return $query->latest()->get();
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
            'Tiempo de Solución',
            'Fecha de Creación',
            'Falla Reportada',
            'Tipo',
            'Comentarios'
        ];
    }

    public function map($ticket): array
    {
        // Calcular tiempo de solución si el ticket está cerrado
        $tiempoSolucion = 'PENDIENTE';
        if ($ticket->estado_id == 5 && $ticket->updated_at) { // Estado cerrado = 5
            $fechaCreacion = \Carbon\Carbon::parse($ticket->created_at);
            $fechaCierre = \Carbon\Carbon::parse($ticket->updated_at);

            $diferencia = $fechaCreacion->diff($fechaCierre);

            if ($diferencia->days > 0) {
                $tiempoSolucion = $diferencia->days . ' día(s), ' . $diferencia->h . ' hora(s), ' . $diferencia->i . ' min(s)';
            } elseif ($diferencia->h > 0) {
                $tiempoSolucion = $diferencia->h . ' hora(s), ' . $diferencia->i . ' min(s)';
            } else {
                $tiempoSolucion = $diferencia->i . ' minuto(s)';
            }
        }

        return [
            $ticket->id,
            $ticket->codigo_formateado ?? $ticket->codigo,
            $ticket->osticket ?? 'N/A',
            $ticket->tecnico_nombres ? $ticket->tecnico_nombres . ' ' . $ticket->tecnico_apellidos : 'No asignado',
            $ticket->equipo ? ($ticket->equipo->serie . ' - ' . ($ticket->equipo->modelo->descripcion ?? 'Sin modelo')) : 'Sin equipo',
            $ticket->equipo->serie ?? 'N/A',
            $ticket->equipo->modelo ?? 'N/A',
            $ticket->agencia->nombre ?? 'No especificada',
            $ticket->assignedUser->name ?? 'Sin asignar',
            $ticket->createdBy->name ?? 'N/A',
            ucfirst($ticket->estado->nombre ?? 'Sin estado'),
            $tiempoSolucion,
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
        if ($this->mes) {
            $nombreMes = \Carbon\Carbon::create()->month($this->mes)->translatedFormat('F');
            return "Lista de Tickets - {$nombreMes}";
        }

        return 'Lista Completa de Tickets';
    }
}
