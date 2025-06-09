<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardTickets extends Component
{
    public $fechaInicio;
    public $fechaFin;
    public $datosGrafico = [];
    public $ticketsPorArea = [];

    // Nuevas métricas
    public $totalTickets = 0;
    public $cerrados = 0;
    public $tiempoPromedio = '00:00:00';
    public $porcentajeCerrados = 0;
    public $usuarios = [];
    public $usuarioSeleccionado;
    public $esAdmin = false;
    public $usuarioId;



    public function mount()
    {
        $user = Auth::user();
        $this->usuarioId = $user->id;
        $this->esAdmin = $user->role === 'admin';

        if ($this->esAdmin) {
            $this->usuarios = \App\Models\User::select('id', 'name')->get();
        } else {
            $this->usuarioSeleccionado = $this->usuarioId; 
        }

        $this->fechaInicio = now()->startOfMonth()->format('Y-m-d');
        $this->fechaFin = now()->format('Y-m-d');
        $this->usuarios = \App\Models\User::select('id', 'name')->get();
        $this->actualizarGrafico();
        $this->calcularMetricas();
        $this->cargarGraficoPorArea();
    }

    public function cargarGraficoPorArea()
    {
        $fechaInicio = $this->fechaInicio . ' 00:00:00';
        $fechaFin = $this->fechaFin . ' 23:59:59';

        $tickets = Ticket::select(
            DB::raw("CONCAT(padre.nombre, ' - ', areas.nombre) as nombre_completo"),
            DB::raw('COUNT(*) as cantidad')
        )
            ->join('areas', 'tickets.area_id', '=', 'areas.id')
            ->leftJoin('areas as padre', 'areas.parent_id', '=', 'padre.id')
            ->whereBetween('tickets.created_at', [$fechaInicio, $fechaFin]);

        if ($this->usuarioSeleccionado) {
            $tickets->where('tickets.assigned_to', $this->usuarioSeleccionado);
        }

        $this->ticketsPorArea = $tickets
            ->groupBy('nombre_completo')
            ->orderByDesc('cantidad')
            ->pluck('cantidad', 'nombre_completo')
            ->toArray();
    }


    public function updatedUsuarioSeleccionado()
    {
        $this->actualizarGrafico();
        $this->calcularMetricas();
        $this->cargarGraficoPorArea();
    }



    public function updatedFechaInicio()
    {
        $this->actualizarGrafico();
        $this->calcularMetricas();
    }

    public function updatedFechaFin()
    {
        $this->actualizarGrafico();
        $this->calcularMetricas();
    }

    public function actualizarGrafico()
    {
        $fechaInicio = $this->fechaInicio . ' 00:00:00';
        $fechaFin = $this->fechaFin . ' 23:59:59';

        $tickets = Ticket::whereBetween('created_at', [$fechaInicio, $fechaFin]);

        if ($this->usuarioSeleccionado) {
            $tickets->where('assigned_to', $this->usuarioSeleccionado);
        }

        $this->datosGrafico = [
            (clone $tickets)->where('estado_id', 1)->count(), // Pendientes
            (clone $tickets)->where('estado_id', 5)->count(), // Cerrados
            (clone $tickets)->where('estado_id', 3)->count(), // Derivados
            (clone $tickets)->where('estado_id', 6)->count(), // Derivados

        ];
    }

    public function calcularMetricas()
    {
        $fechaInicio = $this->fechaInicio . ' 00:00:00';
        $fechaFin = $this->fechaFin . ' 23:59:59';

        $tickets = Ticket::whereBetween('created_at', [$fechaInicio, $fechaFin]);

        if ($this->usuarioSeleccionado) {
            $tickets->where('assigned_to', $this->usuarioSeleccionado);
        }

        $tickets = $tickets->get();

        $this->totalTickets = $tickets->count();
        $this->cerrados = $tickets->where('estado_id', 5)->count();
        $promedioSegundos = $tickets->whereNotNull('tiempo_total_segundos')->avg('tiempo_total_segundos');
        $this->tiempoPromedio = $promedioSegundos ? gmdate('H:i:s', (int)$promedioSegundos) : '00:00:00';
        $this->porcentajeCerrados = $this->totalTickets > 0
            ? round(($this->cerrados / $this->totalTickets) * 100, 1)
            : 0;
    }

    public function render()
    {
        return view('livewire.dashboard-tickets');
    }
}
