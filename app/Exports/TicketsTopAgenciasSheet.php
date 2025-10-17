<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TicketsTopAgenciasSheet implements FromArray, WithTitle, WithStyles, WithColumnWidths
{
    protected $mes;

    public function __construct($mes = null)
    {
        $this->mes = $mes;
    }

    public function array(): array
    {
        // 🔹 Base de tickets + relaciones de agencias y modelos
        $query = DB::table('tickets')
            ->join('agencias', 'tickets.agencia_id', '=', 'agencias.id')
            ->leftJoin('clientes', 'agencias.cliente_id', '=', 'clientes.id')
            ->leftJoin('equipos', 'tickets.equipo_id', '=', 'equipos.id')
            ->leftJoin('modelos', 'equipos.modelo_id', '=', 'modelos.id')
            ->leftJoin('tipos_soporte', 'tickets.tipo_soporte_id', '=', 'tipos_soporte.id')
            ->select(
                'agencias.id as agencia_id',
                'agencias.nombre as agencia_nombre',
                'clientes.nombre as cliente_nombre',
                'tickets.id as ticket_id',
                'tickets.created_at',
                'modelos.descripcion as modelo',
                'tipos_soporte.nombre as tipo_soporte'
            )
            ->whereYear('tickets.created_at', now()->year);

        if ($this->mes) {
            $query->whereMonth('tickets.created_at', $this->mes);
        }

        $tickets = $query->orderByDesc('tickets.created_at')->get();

        // 🔹 Agrupar por agencia
        $grouped = [];
        foreach ($tickets as $t) {
            $agencia = $t->agencia_nombre ?? 'Sin Agencia';

            if (!isset($grouped[$agencia])) {
                $grouped[$agencia] = [
                    'total' => 0,
                    'tickets' => [],
                    'cliente' => $t->cliente_nombre ?? 'Sin Cliente',
                ];
            }

            $grouped[$agencia]['total']++;
            $grouped[$agencia]['tickets'][] = [
                'Código' => 'TCK-' . str_pad($t->ticket_id, 7, '0', STR_PAD_LEFT),
                'Fecha' => Carbon::parse($t->created_at)->format('d/m/Y H:i'),
                'Modelo' => $t->modelo ?? 'Sin modelo',
                'Tipo de Soporte' => $t->tipo_soporte ?? 'Sin tipo',
            ];
        }

        // 🔹 Tomar top 5 agencias
        uasort($grouped, fn($a, $b) => $b['total'] <=> $a['total']);
        $topAgencias = array_slice($grouped, 0, 5, true);

        // 🔹 Construir datos Excel
        $excelData = [];
        $nombreMes = $this->mes
            ? ucfirst(Carbon::create()->month($this->mes)->locale('es')->translatedFormat('F'))
            : 'Todos los meses';

        $excelData[] = [' Top Agencias'];
        $excelData[] = ['Mes', $nombreMes];
        $excelData[] = [];

        foreach ($topAgencias as $agencia => $data) {
            $excelData[] = [
                "Agencia: {$agencia}",
                "Cliente: {$data['cliente']}",
                "Total tickets: {$data['total']}",
            ];
            $excelData[] = ['Código', 'Fecha', 'Modelo', 'Tipo de Soporte'];

            foreach ($data['tickets'] as $ticket) {
                $excelData[] = [
                    $ticket['Código'],
                    $ticket['Fecha'],
                    $ticket['Modelo'],
                    $ticket['Tipo de Soporte'],
                ];
            }

            $excelData[] = []; // espacio entre agencias
        }

        return $excelData;
    }

    public function styles(Worksheet $sheet)
    {
        // 🔹 Título principal
        $sheet->mergeCells('A1:D1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

        // 🔹 Estilos dinámicos
        $highestRow = $sheet->getHighestRow();
        for ($i = 1; $i <= $highestRow; $i++) {
            $cellA = $sheet->getCell("A{$i}")->getValue();

            // Nombre de agencia
            if (is_string($cellA) && str_contains($cellA, 'Agencia:')) {
                $sheet->getStyle("A{$i}:D{$i}")->getFont()->setBold(true)->setSize(12);
                $sheet->getStyle("A{$i}:D{$i}")->getFill()
                    ->setFillType('solid')
                    ->getStartColor()->setARGB('FFE2E8F0');
            }

            // Encabezados
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
            'A' => 18, // Código
            'B' => 20, // Fecha
            'C' => 25, // Modelo
            'D' => 35, // Tipo soporte
        ];
    }

    public function title(): string
    {
        return 'Top Agencias';
    }
}
