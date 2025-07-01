<?php

namespace App\Livewire\Ticket\Dashboard;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TopTecnicoslist extends Component
{
    public array $topTecnicos = [];
    public int $selectedMonth = 0;

    public function mount(): void
    {
        $this->loadTopTecnicos();
    }
    public function updatedSelectedMonth(): void
    {
        $this->loadTopTecnicos();
    }

    private function loadTopTecnicos(): void
    {
        
    }


    public function render()
    {
        return view('livewire.ticket.dashboard.top-tecnicoslist');
    }
}
