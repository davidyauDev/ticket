<?php

namespace App\Livewire\Ticket\Dashboard;

use App\Models\Ticket;
use App\Models\TicketHistorial;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ClosedTicketsChart extends Component
{

    public array $chartData = [];
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
        $closedTickets = Ticket::where('estado_id', 5)
            ->when($this->selectedMonth != 0, function ($query) {
                $query->whereMonth('created_at', $this->selectedMonth);
            })
            ->pluck('id');

        $derivedTickets = TicketHistorial::whereIn('ticket_id', $closedTickets)
            ->where('estado_id', 2)
            ->when($this->selectedMonth != 0, function ($query) {
                $query->whereMonth('created_at', $this->selectedMonth);
            })
            ->pluck('ticket_id')
            ->unique();

        $stopTickets = TicketHistorial::whereIn('ticket_id', $closedTickets)
            ->where('estado_id', 6)
            ->when($this->selectedMonth != 0, function ($query) {
                $query->whereMonth('created_at', $this->selectedMonth);
            })
            ->pluck('ticket_id')
            ->unique();

        // Tickets que fueron derivados pero NO stop
        $onlyDerivedTickets = $derivedTickets->diff($stopTickets);

        // Tickets que fueron stop pero NO derivados
        $onlyStopTickets = $stopTickets->diff($derivedTickets);

        // Tickets que fueron AMBOS (derivados Y stop)
        $bothStatesTickets = $derivedTickets->intersect($stopTickets);

        // Tickets que NO fueron ni derivados ni stop
        $nonDerivedTickets = $closedTickets
            ->diff($derivedTickets)
            ->diff($stopTickets);

        $this->chartData = [
            'series' => [
                count($onlyDerivedTickets),    // Solo derivados
                count($onlyStopTickets),       // Solo stop
                count($bothStatesTickets),     // Derivados Y stop
                count($nonDerivedTickets)      // Ni derivados ni stop
            ],
            'labels' => ['Solo Derivados', 'Solo Stop', 'Derivados y Stop', 'No Derivados']
        ];
    }
    public function render()
    {
        return view('livewire.ticket.dashboard.closed-tickets-chart');
    }
}
