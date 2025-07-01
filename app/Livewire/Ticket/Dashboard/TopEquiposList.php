<?php

namespace App\Livewire\Ticket\Dashboard;

use App\Models\Ticket;
use Livewire\Component;

class TopEquiposList extends Component
{
    public array $topEquipos = [];
    public int $selectedMonth;

    public function mount(): void
    {
        $this->selectedMonth = 0;
        $this->loadTopEquipos();
    }
    public function updatedSelectedMonth(): void
    {
        $this->loadTopEquipos();
    }

    private function loadTopEquipos(): void
    {
        $query = Ticket::select('equipo_id')
            ->selectRaw('COUNT(*) as total_tickets')
            ->whereNotNull('equipo_id')
            ->whereYear('created_at', now()->year);
        if ($this->selectedMonth > 0) {
            $query->whereMonth('created_at', $this->selectedMonth);
        }

        $this->topEquipos = $query->groupBy('equipo_id')
            ->orderByDesc('total_tickets')
            ->with('equipo')
            ->take(5)
            ->get()
            ->map(function ($ticket) {
                return [
                    'name' => $ticket->equipo->serie ?? 'Sin Nombre',
                    'total_tickets' => $ticket->total_tickets
                ];
            })
            ->toArray();
    }


    public function render()
    {
        return view('livewire.ticket.dashboard.top-equipos-list');
    }
}
