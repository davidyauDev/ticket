<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TicketsAreasSheet implements FromArray, WithTitle, WithStyles
{
    protected $mes;

    public function __construct($mes = null)
    {
        $this->mes = $mes;
    }

    public function array(): array
    {
        return [
            [' Tickets por Área', ''],
            ['Mes', $this->mes ?? 'Todos los meses'],
            [],
            ['Área', 'Total'],
            ['Mesa de Ayuda', 25],
            ['Sistemas', 20],
            ['Infraestructura', 10],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:B1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A4:B4')->getFont()->setBold(true);
        $sheet->getStyle('A4:B4')->getFill()->setFillType('solid')->getStartColor()->setARGB('FFE9D8FD');
        $sheet->getStyle('A4:B7')->getBorders()->getAllBorders()->setBorderStyle('thin');

        return [];
    }

    public function title(): string
    {
        return 'Por Área';
    }
}
