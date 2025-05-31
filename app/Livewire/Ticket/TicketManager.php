<?php

namespace App\Livewire\Ticket;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TicketManager extends Component
{

    public string $tab = 'mis';

    public string $usuario;
    public string $area;
    public $total = 0;
    public $pendientes =0;
    public $resueltos = 0;
    public $enProceso = 0;
    public $derivados = 0;

    public function mount(): void
    {
        $user = Auth::user();
        $this->usuario = $user->name;
        $this->area = $user->area->nombre ?? 'Sin área';
    }

    public function openCreateModal()
    {
        $this->dispatch('abrirModalCreacionTicket');
    }


    public function switchTab(string $tab): void
    {
        if (in_array($tab, ['mis', 'todos'])) {
            $this->tab = $tab;
        }
    }

    public function render()
    {
        return view('livewire.ticket.ticket-manager');
    }
}
