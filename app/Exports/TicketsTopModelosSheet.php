<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TicketsTopModelosSheet implements FromArray, WithTitle, WithStyles, WithColumnWidths
{
    protected $mes;

    public function __construct($mes = null)
    {
        $this->mes = $mes;
    }

    public function array(): array
    {
        // 🔹 Consultar tickets relacionados con modelos
        $query = DB::table('tickets')
            ->join('equipos', 'tickets.equipo_id', '=', 'equipos.id')
            ->join('modelos', 'equipos.modelo_id', '=', 'modelos.id')
            ->leftJoin('agencias', 'tickets.agencia_id', '=', 'agencias.id')
            ->leftJoin('clientes', 'agencias.cliente_id', '=', 'clientes.id')
            ->leftJoin('tipos_soporte', 'tickets.tipo_soporte_id', '=', 'tipos_soporte.id')
            ->select(
                'modelos.id as modelo_id',
                'modelos.descripcion as modelo_nombre',
                'tickets.id as ticket_id',
                'tickets.created_at',
                'agencias.nombre as agencia_nombre',
                'clientes.nombre as cliente_nombre',
                'tipos_soporte.nombre as tipo_soporte'
            )
            ->whereYear('tickets.created_at', now()->year);

        if ($this->mes) {
            $query->whereMonth('tickets.created_at', $this->mes);
        }

        $tickets = $query->orderByDesc('tickets.created_at')->get();

        // 🔹 Agrupar por modelo
        $grouped = [];
        foreach ($tickets as $t) {
            $modelo = $t->modelo_nombre ?? 'Sin modelo';

            if (!isset($grouped[$modelo])) {
                $grouped[$modelo] = [
                    'total' => 0,
                    'tickets' => [],
                ];
            }

            $grouped[$modelo]['total']++;
            $grouped[$modelo]['tickets'][] = [
                'Código' => 'TCK-' . str_pad($t->ticket_id, 7, '0', STR_PAD_LEFT),
                'Fecha' => Carbon::parse($t->created_at)->format('d/m/Y H:i'),
                'Cliente' => $t->cliente_nombre ?? 'Sin cliente',
                'Agencia' => $t->agencia_nombre ?? 'Sin agencia',
                'Tipo de Soporte' => $t->tipo_soporte ?? 'Sin tipo',
            ];
        }

        uasort($grouped, fn($a, $b) => $b['total'] <=> $a['total']);
        $topModelos = array_slice($grouped, 0, 5, true);

        $excelData = [];
        $nombreMes = $this->mes
            ? ucfirst(Carbon::create()->month($this->mes)->locale('es')->translatedFormat('F'))
            : 'Todos los meses';

        $excelData[] = [' Top Modelos'];
        $excelData[] = ['Mes', $nombreMes];
        $excelData[] = [];

        foreach ($topModelos as $modelo => $data) {
            $excelData[] = [
                "Modelo: {$modelo}",
                "Total tickets: {$data['total']}",
            ];
            $excelData[] = ['Código', 'Fecha', 'Cliente', 'Agencia', 'Tipo de Soporte'];

            foreach ($data['tickets'] as $ticket) {
                $excelData[] = [
                    $ticket['Código'],
                    $ticket['Fecha'],
                    $ticket['Cliente'],
                    $ticket['Agencia'],
                    $ticket['Tipo de Soporte'],
                ];
            }

            $excelData[] = []; 
        }

        return $excelData;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

        $highestRow = $sheet->getHighestRow();
        for ($i = 1; $i <= $highestRow; $i++) {
            $cellA = $sheet->getCell("A{$i}")->getValue();

            if (is_string($cellA) && str_contains($cellA, 'Modelo:')) {
                $sheet->getStyle("A{$i}:E{$i}")->getFont()->setBold(true)->setSize(12);
                $sheet->getStyle("A{$i}:E{$i}")->getFill()
                    ->setFillType('solid')
                    ->getStartColor()->setARGB('FFE2E8F0');
            }

            if ($cellA === 'Código') {
                $sheet->getStyle("A{$i}:E{$i}")->getFont()->setBold(true);
                $sheet->getStyle("A{$i}:E{$i}")->getFill()
                    ->setFillType('solid')
                    ->getStartColor()->setARGB('FFDDEBF7');
            }
        }

        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 18, // Código
            'B' => 20, // Fecha
            'C' => 25, // Cliente
            'D' => 25, // Agencia
            'E' => 35, // Tipo de soporte
        ];
    }

    public function title(): string
    {
        return 'Top Modelos';
    }
}
