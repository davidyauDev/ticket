<?php

namespace App\Livewire\Ticket\Dashboard;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Ticket;

class MetricasCards extends Component
{
    // Métricas principales
    public $totalTickets = 0;
    public $ticketsCerrados = 0;
    public $ticketsPendientes = 0;

    // Propiedades para modales
    public $showModalCerrados = false;
    public $showModalPendientes = false;
    public $searchCerrados = '';
    public $searchPendientes = '';

    public function mount()
    {
        $this->cargarMetricas();
    }

    public function cargarMetricas()
    {
        // Obtener todos los tickets del año actual
        $añoActual = Carbon::now()->year;

        $this->totalTickets = Ticket::whereYear('created_at', $añoActual)->count();

        $this->ticketsCerrados = Ticket::whereYear('created_at', $añoActual)
            ->where('estado_id', 5) // Estado cerrado
            ->count();

        $this->ticketsPendientes = $this->totalTickets - $this->ticketsCerrados;
    }

    public function mostrarTicketsCerrados()
    {
        $this->reset(['showModalCerrados', 'searchCerrados']);
        $this->showModalCerrados = true;
    }

    public function mostrarTicketsPendientes()
    {
        $this->reset(['showModalPendientes', 'searchPendientes']);
        $this->showModalPendientes = true;
    }

    public function getTicketsCerradosDetalleProperty()
    {
        $añoActual = Carbon::now()->year;
        
        $tickets = Ticket::with(['user', 'area', 'estado', 'cliente'])
            ->whereYear('created_at', $añoActual)
            ->where('estado_id', 5)
            ->orderBy('created_at', 'desc')
            ->get();

        if (empty($this->searchCerrados)) {
            return $tickets;
        }

        return $tickets->filter(function ($ticket) {
            return stripos($ticket->id, $this->searchCerrados) !== false ||
                   stripos($ticket->cliente->nombre ?? '', $this->searchCerrados) !== false ||
                   stripos($ticket->area->nombre ?? '', $this->searchCerrados) !== false ||
                   stripos($ticket->user->name ?? '', $this->searchCerrados) !== false ||
                   stripos($ticket->falla_reportada ?? '', $this->searchCerrados) !== false;
        });
    }

    public function getTicketsPendientesDetalleProperty()
    {
        $añoActual = Carbon::now()->year;
        
        $tickets = Ticket::with(['user', 'area', 'estado', 'cliente'])
            ->whereYear('created_at', $añoActual)
            ->where('estado_id', '!=', 5)
            ->orderBy('created_at', 'desc')
            ->get();

        if (empty($this->searchPendientes)) {
            return $tickets;
        }

        return $tickets->filter(function ($ticket) {
            return stripos($ticket->id, $this->searchPendientes) !== false ||
                   stripos($ticket->cliente->nombre ?? '', $this->searchPendientes) !== false ||
                   stripos($ticket->area->nombre ?? '', $this->searchPendientes) !== false ||
                   stripos($ticket->user->name ?? '', $this->searchPendientes) !== false ||
                   stripos($ticket->falla_reportada ?? '', $this->searchPendientes) !== false;
        });
    }

    public function cerrarModalCerrados()
    {
        $this->showModalCerrados = false;
        $this->searchCerrados = '';
    }

    public function cerrarModalPendientes()
    {
        $this->showModalPendientes = false;
        $this->searchPendientes = '';
    }

    public function render()
    {
        return view('livewire.ticket.dashboard.metricas-cards');
    }
}
