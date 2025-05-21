<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class IndexTic extends Component
{
    public string $tab = 'mis';
    public string $usuario;
    public string $area;

    public function mount()
    {
        $this->usuario = Auth::user()->name ?? 'Usuario';
        $this->area = Auth::user()->area->nombre ?? 'Sin Área'; 
    }

    public function render()
    {
        return view('livewire.index-tic');
    }
}
