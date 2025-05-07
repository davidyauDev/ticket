<?php

namespace App\Livewire\Tickets;

use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Index extends Component
{

    public string $tab = 'mis'; // 'mis' o 'todos'

    public function setTab(string $value)
    {
        Log::info($value);
        $this->tab = $value;
    }
    public function render()
    {
        return view('livewire.tickets.index');
    }
}
