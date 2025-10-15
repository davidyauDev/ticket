<?php

namespace App\Livewire\Ticket\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TicketsPorDiaChart extends Component
{
   

    public $chartData = [
    'categories' => ['01/10','02/10','03/10','04/10','05/10'],
    'series' => [5, 8, 6, 10, 7],
];


    public int $selectedMonth = 0;

    public function mount(): void
    {
        $this->loadChartData();
    }

    public function updatedSelectedMonth(): void
    {
        $this->loadChartData();
    }

    private function loadChartData(): void
    {
        $query = DB::table('tickets')
            ->selectRaw('DATE(created_at) as fecha, COUNT(id) as total')
            ->whereYear('created_at', now()->year);

        if ($this->selectedMonth > 0) {
            $query->whereMonth('created_at', $this->selectedMonth);
        }

        $data = $query
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        $this->chartData = [
            'categories' => $data->pluck('fecha')->map(fn($f) => date('d/m', strtotime($f)))->toArray(),
            'series' => $data->pluck('total')->toArray(),
        ];
        Log::info('Chart Data Loaded: ', $this->chartData);
    }

    public function render()
    {
        return view('livewire.ticket.dashboard.tickets-por-dia-chart');
    }
}
