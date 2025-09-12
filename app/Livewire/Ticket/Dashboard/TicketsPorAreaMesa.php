<?php

namespace App\Livewire\Ticket\Dashboard;

use App\Models\Area;
use Illuminate\Support\Facades\DB;
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
    // Obtenemos los usuarios con prioridad 1
    $usuarios = DB::table('responsables_modelo as rm')
        ->join('users as u', 'rm.id_user', '=', 'u.id')
        ->where('rm.prioridad', 1)
        ->select('u.id', 'u.name')
        ->distinct()
        ->get();

    $estadisticas = $usuarios->map(function ($usuario) {
        // Tickets asignados a este usuario
        $asignados = DB::table('tickets')
            ->where('assigned_to', $usuario->id);

        $asignadosResueltos = (clone $asignados)->where('estado_id', 5)->count();
        $asignadosNoResueltos = (clone $asignados)->where('estado_id', '!=', 5)->count();

        // Tickets no asignados (en general, no por usuario)
        $noAsignados = DB::table('tickets')
            ->whereNull('assigned_to')
            ->count();

        return [
            'usuario' => $usuario->name,
            'asignados_resueltos' => $asignadosResueltos,
            'asignados_no_resueltos' => $asignadosNoResueltos,
            'no_asignados' => $noAsignados,
        ];
    });

    $this->chartData = [
        'categories' => $estadisticas->pluck('usuario')->toArray(),
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
