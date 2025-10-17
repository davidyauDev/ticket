<?php

namespace App\Livewire\Ticket\Dashboard;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TopAgenciaslist extends Component
{
    public array $topAgencias = [];
    public array $chartData = []; // 🔹 Para el gráfico
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
            ->select('agencias.nombre')
            ->selectRaw('COUNT(tickets.id) as total_tickets')
            ->whereYear('tickets.created_at', now()->year);

        if ($this->selectedMonth > 0) {
            $query->whereMonth('tickets.created_at', $this->selectedMonth);
        }

        $this->topAgencias = $query
            ->groupBy('agencias.nombre')
            ->orderByDesc('total_tickets')
            ->limit(5)
            ->get()
            ->map(fn($item) => [
                'name' => $item->nombre ?? 'Sin Nombre',
                'total_tickets' => (int) $item->total_tickets
            ])
            ->toArray();

        // 🔹 Preparar datos para el gráfico
        $this->chartData = [
            'labels' => array_column($this->topAgencias, 'name'),
            'series' => array_column($this->topAgencias, 'total_tickets'),
        ];
    }

    public function render()
    {
        return view('livewire.ticket.dashboard.top-agenciaslist');
    }
}
