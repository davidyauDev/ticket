<?php

namespace App\Livewire;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Areaticket extends Component
{
    public $slug;
    public function mount($slug)
    {
        Log::info($slug);
        $this->slug = $slug;
    }

    public function render()
    {
        $tickets = Ticket::whereHas('area', function ($query) {
            $query->where('slug', $this->slug);
        })->paginate(10);
        return view('livewire.areaticket', compact('tickets'));
    }
}
