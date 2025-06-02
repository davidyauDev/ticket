<?php

namespace App\Livewire\Ticket;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class TicketAsigModal extends Component
{
    public $showModal = false;
    public $ticket;

    #[On('asignarUsuario')]
    public function abrirModal($id)
    {
        $this->ticket = Ticket::find($id);
        $this->showModal = true;
    }

     public function asignarme(): void
    {
        if (!$this->ticket) return;

        $this->ticket->assigned_to = Auth::id();
        $this->ticket->save();

        $this->showModal = false;
        $this->dispatch('user-saved');
        session()->flash('message', 'Ticket asignado correctamente.');
    }

    public function render()
    {
        return view('livewire.ticket.ticket-asig-modal');
    }
}
