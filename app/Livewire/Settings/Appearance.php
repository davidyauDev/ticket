<?php

namespace App\Livewire\Settings;

use Livewire\Component;

class Appearance extends Component
{
    public string $appearance = 'light'; 
    public function render()
    {
        return view('livewire.settings.appearance');
    }
}
