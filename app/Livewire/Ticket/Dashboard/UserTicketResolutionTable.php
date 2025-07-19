<?php

namespace App\Livewire\Ticket\Dashboard;
use Livewire\Component;
use App\Models\Area;
use App\Models\TicketHistorial;

class UserTicketResolutionTable extends Component
{
    public $users;
    public $fecha_inicio;
    public $fecha_fin;

    public function mount()
    {
        $this->fecha_inicio = null;
        $this->fecha_fin = null;
        $this->filtrar();
    }

    public function updatedFechaInicio()
    {
        $this->filtrar();
    }

    public function updatedFechaFin()
    {
        $this->filtrar();
    }

    public function filtrar()
    {
        $subareas = Area::where('parent_id', 5)->with('users')->get();
        $users = [];
        foreach ($subareas as $subarea) {
            foreach ($subarea->users as $user) {
                $user->subarea = $subarea;
                $queryAsignados = TicketHistorial::where('asignado_a', $user->id);
                $queryResueltos = TicketHistorial::where('asignado_a', $user->id)->where('estado_id', 5);
                if ($this->fecha_inicio) {
                    $queryAsignados = $queryAsignados->whereDate('created_at', '>=', $this->fecha_inicio);
                    $queryResueltos = $queryResueltos->whereDate('created_at', '>=', $this->fecha_inicio);
                }
                if ($this->fecha_fin) {
                    $queryAsignados = $queryAsignados->whereDate('created_at', '<=', $this->fecha_fin);
                    $queryResueltos = $queryResueltos->whereDate('created_at', '<=', $this->fecha_fin);
                }
                $user->asignados_count = $queryAsignados->count();
                $user->resueltos_count = $queryResueltos->count();
                $ultimoResuelto = $queryResueltos->orderByDesc('updated_at')->first();
                $user->ultima_fecha_resuelto = $ultimoResuelto ? $ultimoResuelto->updated_at : null;
                $user->no_resueltos_count = $user->asignados_count - $user->resueltos_count;
                $users[] = $user;
            }
        }
        $this->users = $users;
    }

    public function render()
    {
        return view('livewire.ticket.dashboard.user-ticket-resolution-table', [
            'users' => $this->users,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
        ]);
    }
}
