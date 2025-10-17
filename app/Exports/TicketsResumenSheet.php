<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TicketsResumenSheet implements FromArray, WithTitle, WithStyles
{
    protected $mes;

    public function __construct($mes = null)
    {
        $this->mes = $mes;
    }

    public function array(): array
    {
        return [
            [' Resumen de Tickets', ''],
            ['Mes', $this->mes ?? 'Todos los meses'],
            [],
            ['Categoría', 'Total'],
            ['Soporte Técnico', 48],
            ['Mantenimiento', 22],
            ['Instalaciones', 15],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Título grande
        $sheet->mergeCells('A1:B1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

        // Encabezados
        $sheet->getStyle('A4:B4')->getFont()->setBold(true);
        $sheet->getStyle('A4:B4')->getFill()->setFillType('solid')->getStartColor()->setARGB('FFE2E8F0');

        // Bordes
        $sheet->getStyle('A4:B7')->getBorders()->getAllBorders()->setBorderStyle('thin');

        return [];
    }

    public function title(): string
    {
        return 'Resumen General';
    }
}
