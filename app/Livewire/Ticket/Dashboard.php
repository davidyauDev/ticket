<?php

namespace App\Livewire\Ticket;

use Livewire\Component;

class Dashboard extends Component
{
    public string $activeTab = 'resumen';

    protected $queryString = ['activeTab'];
    public function render()
    {
        return view('livewire.ticket.dashboard');
    }
}
