<?php

namespace App\Livewire;

use App\Models\Ticket;
use Livewire\Component;
use Livewire\WithPagination;

class Areaticket extends Component
{
    use WithPagination;
    public $estado_id = 1;
    public $fecha_inicio;
    public $fecha_fin;
    public $total_abiertos;
    public $total_en_proceso;
    public $total_cerrados;
    public $slug;

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->contarTicketsPorEstado();
    }

    public function updatedSlug()
    {
        $this->resetPage();
        $this->contarTicketsPorEstado();
    }


    public function contarTicketsPorEstado()
    {
        $query = Ticket::query()
            ->whereHas('area', fn($q) => $q->where('slug', $this->slug));

        if ($this->fecha_inicio) {
            $query->whereDate('created_at', '>=', $this->fecha_inicio);
        }

        if ($this->fecha_fin) {
            $query->whereDate('created_at', '<=', $this->fecha_fin);
        }

        $this->total_abiertos = (clone $query)->where('estado_id', 1)->count();
        $this->total_en_proceso = (clone $query)->where('estado_id', 2)->count();
        $this->total_cerrados = (clone $query)->where('estado_id', 4)->count();
    }


    public function setEstado($id)
    {
        $this->estado_id = $id;
        $this->resetPage();
    }

    public function updated($property)
    {
        if (in_array($property, ['fecha_inicio', 'fecha_fin'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $tickets = Ticket::query()->whereHas('area', function ($query) {
            $query->where('slug', $this->slug);
        })
            ->where('estado_id', $this->estado_id)
            ->when($this->fecha_inicio, function ($query) {
                $query->whereDate('created_at', '>=', $this->fecha_inicio);
            })
            ->when($this->fecha_fin, function ($query) {
                $query->whereDate('created_at', '<=', $this->fecha_fin);
            })
            ->paginate(10);
        return view('livewire.areaticket', compact('tickets'));
    }
}
