<?php

namespace App\Livewire\Ticket\Dashboard;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TopListModelos extends Component
{
    public array $topModelos = [];
    public array $allModelos = [];
    public int $selectedMonth = 0;
    public bool $showModal = false;

    public function mount(): void
    {
        $this->loadTopModelos();
    }

    public function updatedSelectedMonth(): void
    {
        $this->loadTopModelos();
    }

    public function showAllModelos(): void
    {
        $this->loadAllModelos();
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    private function loadTopModelos(): void
    {
        $query = DB::table('tickets')
            ->join('equipos', 'tickets.equipo_id', '=', 'equipos.id')
            ->join('modelos', 'equipos.modelo_id', '=', 'modelos.id')
            ->select('modelos.id as modelo_id', 'modelos.descripcion as nombre')
            ->selectRaw('COUNT(tickets.id) as total_tickets')
            ->whereYear('tickets.created_at', now()->year);

        if ($this->selectedMonth > 0) {
            $query->whereMonth('tickets.created_at', $this->selectedMonth);
        }

        $this->topModelos = $query
            ->groupBy('modelos.id', 'modelos.descripcion')
            ->orderByDesc('total_tickets')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->nombre ?? 'Sin nombre',
                    'total_tickets' => (int) $item->total_tickets,
                ];
            })
            ->toArray();
    }

    private function loadAllModelos(): void
    {
        $query = DB::table('tickets')
            ->join('equipos', 'tickets.equipo_id', '=', 'equipos.id')
            ->join('modelos', 'equipos.modelo_id', '=', 'modelos.id')
            ->select('modelos.id as modelo_id', 'modelos.descripcion as nombre')
            ->selectRaw('COUNT(tickets.id) as total_tickets')
            ->whereYear('tickets.created_at', now()->year);

        if ($this->selectedMonth > 0) {
            $query->whereMonth('tickets.created_at', $this->selectedMonth);
        }

        $this->allModelos = $query
            ->groupBy('modelos.id', 'modelos.descripcion')
            ->orderByDesc('total_tickets')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->nombre ?? 'Sin nombre',
                    'total_tickets' => (int) $item->total_tickets,
                ];
            })
            ->toArray();
    }


    public function render()
    {
        return view('livewire.ticket.dashboard.top-list-modelos');
    }
}
