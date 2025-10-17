<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;


class ReporteTicketsPDFExport
{
    protected $mes;

    public function __construct($mes = null)
    {
        $this->mes = $mes;
    }

    public function generar()
    {
        $nombreMes = $this->mes
            ? ucfirst(Carbon::create()->month($this->mes)->locale('es')->translatedFormat('F'))
            : 'Todos los meses';

        // 🔹 TOP CLIENTES
        $topClientes = DB::table('tickets')
            ->join('agencias', 'tickets.agencia_id', '=', 'agencias.id')
            ->join('clientes', 'agencias.cliente_id', '=', 'clientes.id')
            ->select('clientes.nombre as nombre')
            ->selectRaw('COUNT(tickets.id) as total')
            ->when($this->mes, fn($q) => $q->whereMonth('tickets.created_at', $this->mes))
            ->whereYear('tickets.created_at', now()->year)
            ->groupBy('clientes.nombre')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // 🔹 TOP AGENCIAS
        $topAgencias = DB::table('tickets')
            ->join('agencias', 'tickets.agencia_id', '=', 'agencias.id')
            ->select('agencias.nombre as nombre')
            ->selectRaw('COUNT(tickets.id) as total')
            ->when($this->mes, fn($q) => $q->whereMonth('tickets.created_at', $this->mes))
            ->whereYear('tickets.created_at', now()->year)
            ->groupBy('agencias.nombre')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // 🔹 TOP MODELOS
        $topModelos = DB::table('tickets')
            ->join('equipos', 'tickets.equipo_id', '=', 'equipos.id')
            ->join('modelos', 'equipos.modelo_id', '=', 'modelos.id')
            ->select('modelos.descripcion as nombre')
            ->selectRaw('COUNT(tickets.id) as total')
            ->when($this->mes, fn($q) => $q->whereMonth('tickets.created_at', $this->mes))
            ->whereYear('tickets.created_at', now()->year)
            ->groupBy('modelos.descripcion')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // 🔹 TOP EQUIPOS
        $topEquipos = DB::table('tickets')
            ->join('equipos', 'tickets.equipo_id', '=', 'equipos.id')
            ->select('equipos.serie as nombre')
            ->selectRaw('COUNT(tickets.id) as total')
            ->when($this->mes, fn($q) => $q->whereMonth('tickets.created_at', $this->mes))
            ->whereYear('tickets.created_at', now()->year)
            ->groupBy('equipos.serie')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // 🔹 Generar gráficos (base64)
        $chartClientes = $this->generarGraficoBase64('Top Clientes', $topClientes);
        $chartAgencias = $this->generarGraficoBase64('Top Agencias', $topAgencias);
        $chartModelos = $this->generarGraficoBase64('Top Modelos', $topModelos);
        $chartEquipos = $this->generarGraficoBase64('Top Equipos', $topEquipos);

        // 🔹 Renderizar PDF con vista
        $pdf = PDF::loadView('exports.reporte-tickets-pdf', [
            'mes' => $nombreMes,
            'topClientes' => $topClientes,
            'topAgencias' => $topAgencias,
            'topModelos' => $topModelos,
            'topEquipos' => $topEquipos,
            'chartClientes' => $chartClientes,
            'chartAgencias' => $chartAgencias,
            'chartModelos' => $chartModelos,
            'chartEquipos' => $chartEquipos,
        ])->setPaper('a4', 'portrait');

        return $pdf->download("reporte_tickets_{$nombreMes}.pdf");
    }

    /**
     * Genera un gráfico de barras en Base64 con QuickChart
     */
    private function generarGraficoBase64(string $titulo, $data)
    {
        if ($data->isEmpty()) return null;

        $labels = $data->pluck('nombre')->map(fn($n) => mb_substr($n, 0, 20))->toArray();
        $values = $data->pluck('total')->toArray();

        $chartConfig = [
            'type' => 'bar',
            'data' => [
                'labels' => $labels,
                'datasets' => [[
                    'label' => $titulo,
                    'data' => $values,
                    'backgroundColor' => ['#2563EB', '#3B82F6', '#60A5FA', '#93C5FD', '#BFDBFE'],
                ]]
            ],
            'options' => [
                'plugins' => ['legend' => ['display' => false]],
                'scales' => [
                    'x' => ['ticks' => ['color' => '#111827', 'font' => ['size' => 10]]],
                    'y' => ['ticks' => ['color' => '#111827', 'font' => ['size' => 10]]],
                ]
            ]
        ];

        $response = Http::get('https://quickchart.io/chart', [
            'c' => json_encode($chartConfig),
            'format' => 'png',
            'width' => 600,
            'height' => 300,
            'backgroundColor' => 'white'
        ]);

        if ($response->successful()) {
            $base64 = 'data:image/png;base64,' . base64_encode($response->body());
            return $base64;
        }

        return null;
    }
}
