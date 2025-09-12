<?php

namespace App\Livewire\Ticket\Dashboard;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
    // Obtenemos los usuarios con prioridad 1 y su modelo asignado
    $usuarios = DB::table('responsables_modelo as rm')
        ->join('users as u', 'rm.id_user', '=', 'u.id')
        ->where('rm.prioridad', 1)
        ->select('u.id', 'u.name', 'rm.id_modelo')
        ->distinct()
        ->get();

    $estadisticas = $usuarios->map(function ($usuario) {
        // Tickets relacionados al modelo del usuario con prioridad 1
        $tickets = DB::table('tickets')
            ->where('id_modelo', $usuario->id_modelo);

        // ⚠️ Si tu tabla tickets NO tiene estado_id, quita estos filtros
        $asignadosResueltos = (clone $tickets)->where('estado_id', 5)->count();
        $asignadosNoResueltos = (clone $tickets)->when(
            DB::getSchemaBuilder()->hasColumn('tickets', 'estado_id'),
            fn($q) => $q->where('estado_id', '!=', 5),
            fn($q) => $q // si no existe estado_id, cuenta todos
        )->count();

        // Tickets sin asignación (del mismo modelo)
        $noAsignados = DB::table('tickets')
            ->where('id_modelo', $usuario->id_modelo)
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
                'name' => 'Resueltos',
                'data' => $estadisticas->pluck('asignados_resueltos')->toArray(),
            ],
            [
                'name' => 'No Resueltos',
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
