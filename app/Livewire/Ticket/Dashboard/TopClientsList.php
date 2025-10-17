<?php

namespace App\Livewire\Ticket\Dashboard;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TopClientsList extends Component
{
    public array $topClients = [];
    public int $selectedMonth = 0;

    // 🔹 Datos preparados para el gráfico
    public array $chartData = [
        'labels' => [],
        'series' => []
    ];

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
            ->select('clientes.nombre')
            ->selectRaw('COUNT(tickets.id) as total_tickets')
            ->whereYear('tickets.created_at', now()->year);

        if ($this->selectedMonth > 0) {
            $query->whereMonth('tickets.created_at', $this->selectedMonth);
        }

        $this->topClients = $query->groupBy('clientes.nombre')
            ->orderByDesc('total_tickets')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                // Sanitizar datos
                return [
                    'name' => $item->nombre ?? 'Sin Nombre',
                    'total_tickets' => (int) $item->total_tickets
                ];
            })
            ->toArray();

        // 🔹 Preparar datos para gráfico
        $this->chartData = [
            'labels' => array_column($this->topClients, 'name'),
            'series' => array_column($this->topClients, 'total_tickets'),
        ];
    }

    public function render()
    {
        return view('livewire.ticket.dashboard.top-clients-list');
    }
}
