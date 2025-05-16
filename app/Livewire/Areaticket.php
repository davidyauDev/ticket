<?php

namespace App\Livewire;

use App\Models\Ticket;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class Areaticket extends Component
{
    use WithPagination;
    public $estado = 'Abierto'; 
    public $slug;

    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function updatingEstado()
    {
        $this->resetPage(); 
    }

    public function render()
    {
        $tickets = Ticket::whereHas('area', function ($query) {
            $query->where('slug', $this->slug);
        })->paginate(10);
        return view('livewire.areaticket', compact('tickets'));
    }
}
