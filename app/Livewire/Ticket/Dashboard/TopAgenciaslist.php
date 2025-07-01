<?php

namespace App\Livewire\Ticket\Dashboard;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TopAgenciaslist extends Component
{
    public array $topAgencias = [];
    public int $selectedMonth = 0;

    public function mount(): void
    {
        $this->loadTopAgencias();
    }

    public function updatedSelectedMonth(): void
    {
        $this->loadTopAgencias();
    }

    private function loadTopAgencias(): void
    {
        $query = DB::table('tickets')
            ->join('agencias', 'tickets.agencia_id', '=', 'agencias.id')
            ->select('agencias.id as agencia_id', 'agencias.nombre')
            ->selectRaw('COUNT(tickets.id) as total_tickets')
            ->whereYear('tickets.created_at', now()->year);

        if ($this->selectedMonth > 0) {
            $query->whereMonth('tickets.created_at', $this->selectedMonth);
        }

        $this->topAgencias = $query->groupBy('agencias.id', 'agencias.nombre')
            ->orderByDesc('total_tickets')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->nombre ?? 'Sin Nombre',
                    'total_tickets' => (int) $item->total_tickets
                ];
            })
            ->toArray();
    }

    public function render()
    {
        return view('livewire.ticket.dashboard.top-agenciaslist');
    }
}
