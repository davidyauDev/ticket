<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;

class IndexTic extends Component
{
    public string $tab = 'mis';
    public int $assigned = 12;
    public int $resolved = 5;
    public int $unassigned = 3;

    public function delete(string $value)
    {
        Log::info($value);
        $this->tab = $value;
    }

    public function render()
    {   
        Log::info('Render method called');
        return view('livewire.index-tic');
    }
}
