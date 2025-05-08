<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Rule;
use Livewire\Attributes\On;

class CreateTicket extends Component
{
    public $showModal = false;
    public $searchQuery = '';
    public $apiResults = [];
    public $selectedItem = null;

    #[Rule('required|min:10')]
    public $comment = '';

    // Buscar en la API
    public function search()
    {
        if(strlen($this->searchQuery) > 2) {
            try {
                $response = Http::get('http://54.197.148.155/numbers.php', [
                    'search' => $this->searchQuery
                ]);
                $this->apiResults = $response->successful()
                    ? $response->json()
                    : [];
            } catch (\Exception $e) {
                $this->apiResults = [];
            }
        }
    }

    // Abrir modal
    #[On('open-create-ticket-modal')]
    public function openModal()
    {
        $this->showModal = true;
    }

    // Cerrar modal
    public function closeModal()
    {
        $this->resetExcept('showModal');
        $this->showModal = false;
    }

    // Seleccionar ticket
    public function selectItem($item)
    {
        $this->selectedItem = $item;
    }

    // Resto de métodos permanecen igual...
    // (openModal, closeModal, save, etc.)

    public function render()
    {
        return view('livewire.create-ticket');
    }
}
