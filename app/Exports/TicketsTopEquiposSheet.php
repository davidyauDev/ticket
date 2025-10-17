<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TicketsTopEquiposSheet implements FromArray, WithTitle, WithStyles, WithColumnWidths
{
    protected $mes;

    public function __construct($mes = null)
    {
        $this->mes = $mes;
    }

    public function array(): array
    {
        // 🔹 Base de tickets + relaciones de equipo, modelo, cliente, agencia
        $query = DB::table('tickets')
            ->join('equipos', 'tickets.equipo_id', '=', 'equipos.id')
            ->leftJoin('modelos', 'equipos.modelo_id', '=', 'modelos.id')
            ->leftJoin('agencias', 'tickets.agencia_id', '=', 'agencias.id')
            ->leftJoin('clientes', 'agencias.cliente_id', '=', 'clientes.id')
            ->leftJoin('tipos_soporte', 'tickets.tipo_soporte_id', '=', 'tipos_soporte.id')
            ->select(
                'equipos.id as equipo_id',
                'equipos.serie as equipo_serie',
                'modelos.descripcion as modelo',
                'clientes.nombre as cliente',
                'agencias.nombre as agencia',
                'tickets.id as ticket_id',
                'tickets.created_at',
                'tipos_soporte.nombre as tipo_soporte'
            )
            ->whereNotNull('tickets.equipo_id')
            ->whereYear('tickets.created_at', now()->year);

        if ($this->mes) {
            $query->whereMonth('tickets.created_at', $this->mes);
        }

        $tickets = $query->orderByDesc('tickets.created_at')->get();

        // 🔹 Agrupar por equipo
        $grouped = [];
        foreach ($tickets as $t) {
            $equipo = $t->equipo_serie ?? 'Sin serie';

            if (!isset($grouped[$equipo])) {
                $grouped[$equipo] = [
                    'total' => 0,
                    'modelo' => $t->modelo ?? 'Sin modelo',
                    'tickets' => [],
                ];
            }

            $grouped[$equipo]['total']++;
            $grouped[$equipo]['tickets'][] = [
                'Código' => 'TCK-' . str_pad($t->ticket_id, 7, '0', STR_PAD_LEFT),
                'Fecha' => Carbon::parse($t->created_at)->format('d/m/Y H:i'),
                'Cliente' => $t->cliente ?? 'Sin cliente',
                'Agencia' => $t->agencia ?? 'Sin agencia',
                'Tipo de Soporte' => $t->tipo_soporte ?? 'Sin tipo',
            ];
        }

        // 🔹 Tomar top 5 equipos
        uasort($grouped, fn($a, $b) => $b['total'] <=> $a['total']);
        $topEquipos = array_slice($grouped, 0, 5, true);

        // 🔹 Construir estructura Excel
        $excelData = [];
        $nombreMes = $this->mes
            ? ucfirst(Carbon::create()->month($this->mes)->locale('es')->translatedFormat('F'))
            : 'Todos los meses';

        $excelData[] = [' Top Equipos'];
        $excelData[] = ['Mes', $nombreMes];
        $excelData[] = [];

        foreach ($topEquipos as $serie => $data) {
            $excelData[] = [
                "Equipo: {$serie}",
                "Modelo: {$data['modelo']}",
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

            $excelData[] = []; // espacio entre equipos
        }

        return $excelData;
    }

    public function styles(Worksheet $sheet)
    {
        // 🔹 Título principal
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

        // 🔹 Estilos dinámicos
        $highestRow = $sheet->getHighestRow();
        for ($i = 1; $i <= $highestRow; $i++) {
            $cellA = $sheet->getCell("A{$i}")->getValue();

            // Encabezado de cada equipo
            if (is_string($cellA) && str_contains($cellA, 'Equipo:')) {
                $sheet->getStyle("A{$i}:E{$i}")->getFont()->setBold(true)->setSize(12);
                $sheet->getStyle("A{$i}:E{$i}")->getFill()
                    ->setFillType('solid')
                    ->getStartColor()->setARGB('FFE2E8F0');
            }

            // Encabezados de tabla
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
        return 'Top Equipos';
    }
}
