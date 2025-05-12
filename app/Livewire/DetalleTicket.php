<?php

namespace App\Livewire;

use App\Models\Ticket;
use Livewire\Component;

class DetalleTicket extends Component
{
    public $ticket;

    public function mount($ticket)
    {
        $this->ticket = Ticket::findOrFail($ticket);
    }

    public function render()
    {
        return view('livewire.detalle-ticket', ['ticket' => $this->ticket]);
    }
}
