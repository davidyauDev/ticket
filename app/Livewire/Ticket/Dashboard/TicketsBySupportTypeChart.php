<?php

namespace App\Livewire\Ticket\Dashboard;

use App\Models\Ticket;
use App\Models\TipoSoporte;
use Livewire\Component;

class TicketsBySupportTypeChart extends Component
{
    public array  $chartData = [];
    public int $selectedMonth = 0;

    public function mount(): void
    {
        $this->selectedMonth = now()->month;
        $this->loadChartData();
    }

    public function updatedSelectedMonth(): void
    {
        $this->loadChartData();
    }

    private function loadChartData(): void
    {
        $tiposSoporte = TipoSoporte::all();

        $categories = [];
        $series = [];

        foreach ($tiposSoporte as $tipo) {
            $categories[] = $tipo->nombre;

            $totalTickets = Ticket::where('tipo_soporte_id', $tipo->id)
                ->whereYear('created_at', now()->year)
                ->when($this->selectedMonth, function ($query) {
                    return $query->whereMonth('created_at', $this->selectedMonth);
                })
                ->count();

            $series[] = $totalTickets;
        }

        $this->chartData = [
            'series' => $series,
            'categories' => $categories
        ];
    }


    public function render()
    {
        return view('livewire.ticket.dashboard.tickets-by-support-type-chart');
    }
}
