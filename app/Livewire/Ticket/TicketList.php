<?php

namespace App\Livewire\Ticket;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class TicketList extends Component
{
    use WithPagination;
    public string $search = '';
    public string $tipo = 'todos';
    protected $listeners = ['user-saved' => '$refresh'];
    public function render()
    {
        $user = Auth::user();
        $tickets = Ticket::query()
            ->when($this->tipo === 'mis', function ($q) use ($user) {
                $q->where(function ($q2) use ($user) {
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
            ->latest()
            ->paginate(8);

        return view('livewire.ticket.ticket-list', compact('tickets'));
    }
}
