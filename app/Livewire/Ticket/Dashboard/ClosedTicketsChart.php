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

    $nonDerivedTickets = $closedTickets
        ->diff($derivedTickets)
        ->diff($stopTickets);

    $this->chartData = [
        'series' => [
            count($derivedTickets),       
            count($stopTickets),          
            count($nonDerivedTickets)     
        ],
        'labels' => ['Derivados', 'Stop', 'No Derivados']
    ];
}
    public function render()
    {
        return view('livewire.ticket.dashboard.closed-tickets-chart');
    }
}
