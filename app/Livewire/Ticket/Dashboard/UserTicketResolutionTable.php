<?php

namespace App\Livewire\Ticket\Dashboard;

use Livewire\Component;
use App\Models\Area;
use App\Models\Ticket;
use App\Models\TicketHistorial;

class UserTicketResolutionTable extends Component
{
    public array $users = [];
    public ?string $fecha_inicio = null;
    public ?string $fecha_fin = null;

    public bool $showModal = false;
    public ?int $selectedUserId = null;
    public array $unresolvedTickets = [];

    public function mount(): void
    {
        $this->loadUsers();
    }

    public function updatedFechaInicio(): void
    {
        $this->loadUsers();
    }

    public function updatedFechaFin(): void
    {
        $this->loadUsers();
    }

    public function loadUsers(): void
    {
        $this->users = [];

        $subareas = Area::where('parent_id', 5)->with('users')->get();

        foreach ($subareas as $subarea) {
            foreach ($subarea->users as $user) {
                $asignados = $this->queryHistorial($user->id);
                $resueltos = clone $asignados;
                $resueltos->where('estado_id', 5);

                $userData = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'initials' => $user->initials(),
                    'subarea' => $subarea->nombre,
                    'asignados_count' => $asignados->count(),
                    'resueltos_count' => $resueltos->count(),
                    'ultima_fecha_resuelto' => optional($resueltos->orderByDesc('updated_at')->first())->updated_at?->format('Y-m-d H:i'),
                ];

                $userData['no_resueltos_count'] = $userData['asignados_count'] - $userData['resueltos_count'];

                $this->users[] = $userData;
            }
        }
    }

    protected function queryHistorial(int $userId)
    {
        $query = TicketHistorial::where('asignado_a', $userId)
            ->where('estado_id', 2);

        if ($this->fecha_inicio) {
            $query->whereDate('created_at', '>=', $this->fecha_inicio);
        }

        if ($this->fecha_fin) {
            $query->whereDate('created_at', '<=', $this->fecha_fin);
        }

        return $query;
    }

    public function showUnresolvedTickets(int $userId): void
    {
        $this->selectedUserId = $userId;

        $asignados = Ticket::whereHas('historiales', function ($query) use ($userId) {
            $query->where('asignado_a', $userId);
        })->with([
            'historiales' => function ($q) use ($userId) {
                $q->where('asignado_a', $userId)->orderByDesc('created_at');
            },
            'estado'
        ])->get();

        $this->unresolvedTickets = $asignados->map(function ($ticket) use ($userId) {
            $resueltoPor = TicketHistorial::where('ticket_id', $ticket->id)
                ->where('estado_id', 5) // Estado resuelto
                ->latest('created_at')
                ->first();

            return [
                'id' => $ticket->id,
                'codigo' => $ticket->codigo ?? '—',
                'cliente' => $ticket->cliente->nombre ?? '—',
                'fecha_asignacion' => optional($ticket->historiales->first())->created_at?->format('Y-m-d H:i'),
                'estado' => $ticket->estado->nombre ?? '—',
                'resuelto_por' => $resueltoPor?->asignado_a === $userId ? 'Sí' : ($resueltoPor ? 'Otro' : '—'),
            ];
        })->toArray();

        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->reset('showModal', 'selectedUserId', 'unresolvedTickets');
    }

    public function render()
    {
        return view('livewire.ticket.dashboard.user-ticket-resolution-table');
    }
}
