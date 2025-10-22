<?php

namespace App\Livewire\Ticket\Dashboard;

use Livewire\Component;
use App\Models\Area;
use App\Models\Ticket;
use App\Models\TicketHistorial;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;

class UserTicketResolutionTable extends Component
{
    use WithPagination;
    public ?string $fecha_inicio = null;
    public ?string $fecha_fin = null;
    public string $search = '';
    public ?string $selectedUserName = null;

    public bool $showModal = false;
    public ?int $selectedUserId = null;

    public function mount(): void
    {
        // Ya no necesitamos cargar usuarios aquí
    }

    public function updatedFechaInicio(): void
    {
        $this->resetPage('usersPage');
    }

    public function updatedFechaFin(): void
    {
        $this->resetPage('usersPage');
    }
    public function updatedSearch(): void
    {
        $this->resetPage('usersPage');
    }

    public function getUsersProperty()
    {
        $usuarios = User::query()
            ->when(
                $this->search,
                fn($q) =>
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
            )
            ->where('area_id', 2)
            ->paginate(8, ['*'], 'usersPage');

        return $usuarios->through(function ($usuario) {
            $subquery = DB::table('ticket_historial')
                ->select('ticket_id', DB::raw('MAX(created_at) as ultima_fecha'))
                ->where('asignado_a', $usuario->id)
                ->groupBy('ticket_id');

            $asignadosCount = DB::table('ticket_historial as th')
                ->joinSub($subquery, 'ultimos_tickets', function ($join) {
                    $join->on('th.ticket_id', '=', 'ultimos_tickets.ticket_id')
                        ->on('th.created_at', '=', 'ultimos_tickets.ultima_fecha');
                })
                ->where('th.asignado_a', $usuario->id)
                ->count();

            $resueltosCount = TicketHistorial::where('estado_id', 5)
                ->where(function ($query) use ($usuario) {
                    $query->where('asignado_a', $usuario->id)
                        ->orWhere('usuario_id', $usuario->id);
                })
                ->where(function ($query) {
                    $query->where('estado_id', 5)
                        ->orWhere('accion', 'Ticket cerrado al momento de su creación');
                })
                ->count();

            $ultimaFechaResuelto = optional(
                TicketHistorial::where('estado_id', 5)
                    ->where(function ($query) use ($usuario) {
                        $query->where('asignado_a', $usuario->id)
                            ->orWhere('usuario_id', $usuario->id);
                    })
                    ->orderByDesc('updated_at')
                    ->first()
            )->updated_at?->format('Y-m-d H:i');

            return [
                'id' => $usuario->id,
                'name' => $usuario->name,
                'email' => $usuario->email,
                'initials' => $usuario->initials(),
                'asignados_count' => $asignadosCount,
                'resueltos_count' => $resueltosCount,
                'ultima_fecha_resuelto' => $ultimaFechaResuelto,
            ];
        });
    }

    public function loadUsers(): void
    {
        // Método mantenido para compatibilidad, pero ahora los datos se cargan en la propiedad computed
        $this->resetPage('usersPage');
    }

    protected function queryHistorial(int $userId)
    {
        $query = TicketHistorial::where('asignado_a', $userId)
            ->where('estado_id', 5);

        if ($this->fecha_inicio) {
            $query->whereDate('created_at', '>=', $this->fecha_inicio);
        }

        if ($this->fecha_fin) {
            $query->whereDate('created_at', '<=', $this->fecha_fin);
        }

        return $query;
    }

    public function getUnresolvedTicketsProperty()
    {
        if (!$this->selectedUserId) {
            return Ticket::where('id', null)->paginate(5, ['*'], 'ticketsPage');
        }

        $paginator = Ticket::whereHas('historiales', function ($query) {
            $query->where('asignado_a', $this->selectedUserId);
        })
            ->with([
                'historiales' => fn($q) => $q->where('asignado_a', $this->selectedUserId)->orderByDesc('created_at'),
                'estado',
                'equipo',
                'equipo.modelo',
            ])
            ->paginate(5, ['*'], 'ticketsPage');

        return $paginator->through(function ($ticket) {
            $resueltoPor = TicketHistorial::where('ticket_id', $ticket->id)
                ->where('estado_id', 5) // Estado resuelto
                ->latest('created_at')
                ->first();

            $resueltoTexto = 'Pendiente por Resolver';
            if ($resueltoPor) {
                $usuarioQueResolvio = $resueltoPor->asignado_a ?? $resueltoPor->usuario_id;
                if ($usuarioQueResolvio === $this->selectedUserId) {
                    $resueltoTexto = 'Sí';
                } else {
                    $usuario = User::find($usuarioQueResolvio);
                    $resueltoTexto = $usuario ? $usuario->name : 'Usuario desconocido';
                }
            }

            return [
                'id' => $ticket->id,
                'codigo' => $ticket->codigo ?? '—',
                'modelo' => $ticket->equipo->modelo,
                'fecha_asignacion' => optional($ticket->historiales->first())->created_at?->format('Y-m-d H:i'),
                'estado' => $ticket->estado ? $ticket->estado->nombre : '—',
                'resuelto_por' => $resueltoTexto,
            ];
        });
    }

    public function openModal(int $userId): void
    {
        $this->selectedUserId = $userId;
        $usuario = User::find($userId);
        $this->selectedUserName = $usuario?->name ?? 'Ingeniero';
        $this->resetPage('ticketsPage'); // Resetear la página del modal
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->reset(['showModal', 'selectedUserId', 'selectedUserName']);
        $this->resetPage('ticketsPage');
    }

    public function render()
    {
        return view('livewire.ticket.dashboard.user-ticket-resolution-table');
    }
}
