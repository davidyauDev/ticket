<?php

namespace App\Livewire\Ticket\Dashboard;

use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TopClientsList extends Component
{
    public array $topClients = [];
    public int $selectedMonth = 0;

    public function mount(): void
    {
        $this->loadTopClients();
    }

    public function updatedSelectedMonth(): void
    {
        $this->loadTopClients();
    }

    private function loadTopClients(): void
    {
        $query = DB::table('tickets')
        ->join('agencias', 'tickets.agencia_id', '=', 'agencias.id')
        ->join('clientes', 'agencias.cliente_id', '=', 'clientes.id')
        ->select('clientes.id as client_id', 'clientes.nombre')
        ->selectRaw('COUNT(tickets.id) as total_tickets')
        ->whereYear('tickets.created_at', now()->year);

    if ($this->selectedMonth > 0) {
        $query->whereMonth('tickets.created_at', $this->selectedMonth);
    }

    $this->topClients = $query->groupBy('clientes.id', 'clientes.nombre')
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
        return view('livewire.ticket.dashboard.top-clients-list');
    }
}
