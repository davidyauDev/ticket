<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TicketsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $tickets;

    public function __construct($tickets)
    {
        $this->tickets = $tickets;
    }

    public function collection()
    {
        return $this->tickets;
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
            $ticket->equipo ? ($ticket->equipo->serie . ' - ' . ($ticket->equipo->modelo ?? 'Sin modelo')) : 'Sin equipo',
            $ticket->equipo->serie ?? 'N/A',
            $ticket->equipo->modelo ?? 'N/A',
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
}
