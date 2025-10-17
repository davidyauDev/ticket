<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TicketsTecnicosSheet implements FromArray, WithTitle, WithStyles, WithColumnWidths
{
    protected $mes;

    public function __construct($mes = null)
    {
        $this->mes = $mes;
    }

    public function array(): array
    {
        $query = DB::table('tickets')
            ->join('tecnicos', 'tickets.staff_id', '=', 'tecnicos.staff_id')
            ->leftJoin('equipos', 'tickets.equipo_id', '=', 'equipos.id')
            ->leftJoin('modelos', 'equipos.modelo_id', '=', 'modelos.id')
            ->leftJoin('tipos_soporte', 'tickets.tipo_soporte_id', '=', 'tipos_soporte.id')
            ->select(
                'tickets.id',
                'tickets.created_at',
                'tecnicos.name',
                'tecnicos.lastname',
                'modelos.descripcion as modelo',
                'tipos_soporte.nombre as tipo_soporte',
                'tickets.motivo_derivacion',
                'tickets.comentario'
            )
            ->whereNotNull('tickets.staff_id')
            ->whereYear('tickets.created_at', now()->year);

        if ($this->mes) {
    $query->whereMonth('tickets.created_at', $this->mes);
}


        $calls = $query->orderByDesc('tickets.created_at')->get();

        $grouped = [];
        foreach ($calls as $call) {
            $technician = trim(($call->name ?? '') . ' ' . ($call->lastname ?? '')) ?: 'Sin nombre';
            if (!isset($grouped[$technician])) {
                $grouped[$technician] = [];
            }
            $grouped[$technician][] = [
                'Código' => 'TCK-' . str_pad($call->id, 7, '0', STR_PAD_LEFT),
                'Fecha' => Carbon::parse($call->created_at)->format('d/m/Y H:i'),
                'Modelo' => $call->modelo ?? 'Sin modelo',
                'Soporte / Derivación' => $call->tipo_soporte ?? $call->motivo_derivacion ?? $call->comentario ?? '',
            ];
        }

        $excelData = [];
        $excelData[] = ['Tickets por Técnico'];
        $excelData[] = ['Mes', $this->mes ?: 'Todos los meses'];
        $excelData[] = []; 

        foreach ($grouped as $technician => $tickets) {
            $excelData[] = ["Técnico: {$technician}", "Total llamadas: " . count($tickets)];
            $excelData[] = ['Código', 'Fecha', 'Modelo', 'Tipo de Soporte / Derivación'];

            foreach ($tickets as $ticket) {
                $excelData[] = [
                    $ticket['Código'],
                    $ticket['Fecha'],
                    $ticket['Modelo'],
                    $ticket['Soporte / Derivación']
                ];
            }

            $excelData[] = []; 
        }

        return $excelData;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:D1');

        $highestRow = $sheet->getHighestRow();
        for ($i = 1; $i <= $highestRow; $i++) {
            $cellA = $sheet->getCell("A{$i}")->getValue();
            if (str_contains($cellA, 'Técnico:')) {
                $sheet->getStyle("A{$i}:D{$i}")->getFont()->setBold(true)->setSize(12);
                $sheet->getStyle("A{$i}:D{$i}")->getFill()
                    ->setFillType('solid')
                    ->getStartColor()->setARGB('FFE2E8F0');
            }
            if ($cellA === 'Código') {
                $sheet->getStyle("A{$i}:D{$i}")->getFont()->setBold(true);
                $sheet->getStyle("A{$i}:D{$i}")->getFill()
                    ->setFillType('solid')
                    ->getStartColor()->setARGB('FFDDEBF7');
            }
        }

        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 18,
            'B' => 20,
            'C' => 20,
            'D' => 60,
        ];
    }

    public function title(): string
    {
        return 'Por Técnico';
    }
}
