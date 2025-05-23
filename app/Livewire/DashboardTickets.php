<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ticket;

class DashboardTickets extends Component
{
    public $fechaInicio;
    public $fechaFin;
    public $datosGrafico = [];

    public function mount()
    {
        $this->fechaInicio = now()->startOfMonth()->format('Y-m-d');
        $this->fechaFin = now()->format('Y-m-d');
        $this->actualizarGrafico();
    }

    public function updatedFechaInicio()
    {
        $this->actualizarGrafico();
    }

    public function updatedFechaFin()
    {
        $this->actualizarGrafico();
    }

    public function actualizarGrafico()
    {
        $tickets = Ticket::whereBetween('created_at', [$this->fechaInicio, $this->fechaFin]);
        $this->datosGrafico = [
            (clone $tickets)->where('estado_id', 1)->count(), 
            (clone $tickets)->where('estado_id', 5)->count(), 
            (clone $tickets)->where('estado_id', 2)->count(), 
        ];
    }

    public function render()
    {
        return view('livewire.dashboard-tickets');
    }
}
