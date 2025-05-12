<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;

class IndexTic extends Component
{
    public string $tab = 'mis';

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
