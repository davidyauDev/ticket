<?php

namespace App\Livewire\Tickets;

use Livewire\Component;

class Stats extends Component
{
    public int $resueltos = 0;
    public int $derivados = 0;
    public int $pendientes = 0;

    public function mount()
    {
        $this->resueltos = 0;
        $this->derivados = 0;
        $this->pendientes = 0;
    }

    public function render()
    {
        return view('livewire.tickets.stats');
    }
}
