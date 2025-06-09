<?php

namespace App\Livewire\Charts;

use Livewire\Component;
use App\Models\Ticket;
use Livewire\Attributes\Computed;
use ArielMejiaDev\LarapexCharts\Facades\LarapexChart;
use Illuminate\Support\Facades\Log;

class TicketsPorEstado extends Component
{
    public string $fechaInicio;
    public string $fechaFin;
    public int $chartKey = 0;

    public function updatedFechaInicio()
    {
        $this->chartKey++;
    }

    public function updatedFechaFin()
    {
        $this->chartKey++;
    }

    #[Computed]
    public function chart(): array
    {
        if (!$this->fechaInicio || !$this->fechaFin) {
            return [
                'chart' => null,
                'data' => [0, 0, 0],
            ];
        }

        $tickets = Ticket::whereBetween('created_at', [$this->fechaInicio, $this->fechaFin]);

        $data = [
            (clone $tickets)->where('estado_id', 1)->count(),
            (clone $tickets)->where('estado_id', 5)->count(),
            (clone $tickets)->where('estado_id', 2)->count(),
        ];

        Log::info('Fechas: ' . $this->fechaInicio . ' - ' . $this->fechaFin);

        $chart = LarapexChart::barChart()
            ->setTitle('Tickets por Estado')
            ->addData('Cantidad', $data)
            ->setXAxis(['Pendientes', 'Cerrados', 'Derivados']);

        return [
            'chart' => $chart,
            'data' => $data,
        ];
    }

    public function render()
    {
        $result = $this->chart();

        return view('livewire.charts.tickets-por-estado', [
            'chart' => $result['chart'],
            'data' => $result['data'],
        ]);
    }
}
