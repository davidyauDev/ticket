<?php

namespace App\Livewire;

use App\Models\Ticket;
use Livewire\Component;

class Tickets extends Component
{

    public $ticketCode = '';
    public $ticket = null;
    public $loading = false;

    public function handleSearch()
    {
        $this->loading = true;

        // Realiza la búsqueda de acuerdo con el código del ticket
        $this->ticket = Ticket::where('code', $this->ticketCode)->first();

        $this->loading = false;
    }

    public function handleClear()
    {
        $this->ticketCode = '';
        $this->ticket = null;
    }
    public function render()
    {
        return view('livewire.tickets');
    }
}
