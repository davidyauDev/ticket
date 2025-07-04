<?php

namespace App\Livewire\Ticket;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class TicketList extends Component
{
    use WithPagination;
    public string $search = '';
    public string $tipo = 'todos';
    public string $filterType = ''; // Filtro por tipo
    public ?string $startDate = null; // Fecha de inicio
    public ?string $endDate = null; // Fecha de fin
    protected $listeners = ['user-saved' => '$refresh'];


    public function asignarUsuario($id)
    {
        $this->dispatch('asignarUsuario', id: $id);
    }

    public function render()
    {
        $user = Auth::user();

        $tickets = Ticket::query();

        if ($user->role === 'admin') {
            // Admin puede ver todos los tickets con filtros globales
            $tickets->when($this->search, fn($q) => $q->where(function ($q2) {
                $q2->where('codigo', 'like', "%{$this->search}%")
                    ->orWhere('id', $this->search);
            }))
                ->when($this->filterType, fn($q) => $q->where('tipo', $this->filterType))
                ->when($this->startDate && $this->endDate, fn($q) => $q->whereBetween('created_at', [$this->startDate, $this->endDate]));
        } else {
            // Usuarios normales: filtrados por tipo y área
            $tickets->when($this->tipo === 'mis', function ($q) use ($user) {
                $q->where('area_id', $user->area_id)
                    ->where(function ($q2) use ($user) {
                        $q2->where('assigned_to', $user->id)
                            ->orWhereNull('assigned_to');
                    });
            })
                ->when($this->tipo === 'pendientes', fn($q) => $q->where('area_id', $user->area_id)->whereNull('assigned_to'))
                ->when($this->tipo === 'todos', fn($q) => $q->where('area_id', $user->area_id))
                ->when($this->search, fn($q) => $q->where(function ($q2) {
                    $q2->where('codigo', 'like', "%{$this->search}%")
                        ->orWhere('id', $this->search);
                }))
                ->when($this->filterType, fn($q) => $q->where('tipo', $this->filterType))
                ->when($this->startDate && $this->endDate, fn($q) => $q->whereBetween('created_at', [$this->startDate, $this->endDate]));
        }

        $tickets = $tickets->latest()->paginate(8);

        return view('livewire.ticket.ticket-list', compact('tickets'));
    }
}
