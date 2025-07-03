<?php

namespace App\Livewire\Ticket\Dashboard;

use App\Models\Area;
use Livewire\Component;

class TicketsPorAreaMesa extends Component
{
    public array $chartData = [];


    public function mount()
    {
        $this->loadChartData();
    }


    public function loadChartData(): void
    {
        $mesa = Area::with(['children.tickets' => function ($query) {
            $query->select('id', 'area_id', 'assigned_to', 'estado_id');
        }])->find(1); // ID del área Mesa

        $estadisticas = $mesa->children->map(function ($subArea) {
            $asignados = $subArea->tickets->whereNotNull('assigned_to');
            $noAsignados = $subArea->tickets->whereNull('assigned_to');

            return [
                'area' => $subArea->nombre,
                'asignados_resueltos' => $asignados->where('estado_id', 5)->count(),
                'asignados_no_resueltos' => $asignados->where('estado_id', '!=', 5)->count(),
                'no_asignados' => $noAsignados->count(),
            ];
        });

        $this->chartData = [
            'categories' => $estadisticas->pluck('area')->toArray(),
            'series' => [
                [
                    'name' => 'Asignados y Resueltos',
                    'data' => $estadisticas->pluck('asignados_resueltos')->toArray(),
                ],
                [
                    'name' => 'Asignados No Resueltos',
                    'data' => $estadisticas->pluck('asignados_no_resueltos')->toArray(),
                ],
                [
                    'name' => 'No Asignados',
                    'data' => $estadisticas->pluck('no_asignados')->toArray(),
                ],
            ],
        ];
    }    

    public function render()
    {
        return view('livewire.ticket.dashboard.tickets-por-area-mesa');
    }
}
