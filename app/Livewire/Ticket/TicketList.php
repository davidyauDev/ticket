<?php

namespace App\Livewire\Ticket;

use App\Models\Ticket;
use App\Models\TicketHistorial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TicketsExport;

class TicketList extends Component
{
    use WithPagination;
    public int $perPage = 8;
    public string $search = '';
    public string $tipo = 'todos';
    public string $filterType = ''; // Filtro por tipo o estado
    public ?string $startDate = null; // Fecha de inicio
    public ?string $endDate = null; // Fecha de fin
    protected $listeners = ['user-saved' => '$refresh', 'anularTicketConComentario'];


    public function asignarUsuario($id)
    {
        $this->dispatch('asignarUsuario', id: $id);
    }

    // Método para resetear la paginación cuando cambie el filtro
    public function updatedFilterType()
    {
        $this->resetPage();
    }

    // Método para resetear la paginación cuando cambie la búsqueda
    public function updatedSearch()
    {
        $this->resetPage();
    }

    // Método para resetear la paginación cuando cambien las fechas
    public function updatedStartDate()
    {
        $this->resetPage();
    }

    public function updatedEndDate()
    {
        $this->resetPage();
    }

    public function exportExcel()
    {
        $user = Auth::user();
        
        // Construir la misma consulta que se usa en render() pero sin paginación
        $tickets = Ticket::query();

        if ($user->role === 'admin' || $user->area_id === 1 || $user->area_id === 2) {
            // Admin puede ver todos los tickets con filtros globales
            $tickets->when($this->search, fn($q) => $q->where(function ($q2) {
                $q2->where('codigo', 'like', "%{$this->search}%")
                    ->orWhere('id', $this->search)
                    ->orWhere('osticket', 'like', "%{$this->search}%");
            }))
                ->when($this->filterType === 'solved', fn($q) => $q->where('estado_id', 5))
                ->when($this->filterType === 'pending', fn($q) => $q->where('estado_id', 1))
                ->when($this->filterType === 'paused', fn($q) => $q->where('estado_id', 6))
                ->when($this->filterType === 'anuled', fn($q) => $q->where('estado_id', 4))
                ->when(!in_array($this->filterType, ['solved', 'pending', 'paused', 'anuled']) && $this->filterType, fn($q) => $q->where('tipo', $this->filterType))
                ->when($this->startDate && $this->endDate, fn($q) => $q->whereBetween('created_at', [$this->startDate, $this->endDate]));
        } else {
            // Usuarios normales: filtrados por tipo y área
            $tickets->when($this->tipo === 'mis', function ($q) use ($user) {
                $q->where('assigned_to', $user->id);
            })
                ->when($this->tipo === 'pendientes', fn($q) => $q->where('area_id', $user->area_id)->whereNull('assigned_to'))
                ->when($this->tipo === 'todos', fn($q) => $q->where('area_id', $user->area_id))
                ->when($this->search, fn($q) => $q->where(function ($q2) {
                    $q2->where('codigo', 'like', "%{$this->search}%")
                        ->orWhere('id', $this->search)
                        ->orWhere('osticket', 'like', "%{$this->search}%");
                }))
                ->when($this->filterType === 'solved', fn($q) => $q->where('estado_id', 5))
                ->when($this->filterType === 'pending', fn($q) => $q->where('estado_id', 1))
                ->when($this->filterType === 'paused', fn($q) => $q->where('estado_id', 6))
                ->when(!in_array($this->filterType, ['solved', 'pending', 'paused']) && $this->filterType, fn($q) => $q->where('tipo', $this->filterType))
                ->when($this->startDate && $this->endDate, fn($q) => $q->whereBetween('created_at', [$this->startDate, $this->endDate]));
        }

        // Obtener todos los tickets sin paginación
        $allTickets = $tickets->latest()->get();

        // Generar nombre del archivo con fecha y filtros aplicados
        $fileName = 'tickets_' . now()->format('Y-m-d_H-i-s');
        if ($this->filterType) {
            $fileName .= '_' . $this->filterType;
        }
        $fileName .= '.xlsx';

        return Excel::download(new TicketsExport($allTickets), $fileName);
    }

    public function anularTicket($id)
    {
        $ticket = Ticket::find($id);

        if ($ticket) {
            $ticket->estado_id = 4; 
            $ticket->save();

            session()->flash('message', 'El ticket ha sido anulado correctamente.');
            $this->emit('user-saved'); 
        } else {
            session()->flash('error', 'No se encontró el ticket.');
        }
    }
    public function confirmarAnulacion($id)
    {
        $this->dispatch('mostrarSwalAnulacion', id: $id);
    }

    public function anularTicketConComentario(...$args)
    {
        $id = $args[0] ?? null;
        $comentario = $args[1] ?? null;
        if (!$id) {
            session()->flash('error', 'No se pudo identificar el ticket.');
            return;
        }

        $ticket = Ticket::find($id);

        if ($ticket) {
            $ticket->assigned_to = Auth::id();
            $ticket->area_id = Auth::user()->area_id;
            $ticket->estado_id = 4;
            $ticket->comentario = $comentario;
            $ticket->save();


             TicketHistorial::create([
                'ticket_id'    => $ticket->id,
                'usuario_id'   => Auth::id(),
                'from_area_id' => Auth::user()->area_id,
                'to_area_id'   => $this->selectedSubarea ?? null,
                'asignado_a'   => $ticket->assigned_to,
                'estado_id'    => $ticket->estado_id,
                'accion'       => TicketHistorial::ACCION_ANULADO,
                'comentario'   => $comentario,
                'started_at'   => now(),
                'ended_at'     => null,
                'is_current'   => true,
            ]);

            session()->flash('message', 'El ticket fue anulado correctamente con comentario.');
            $this->dispatch('user-saved');
        } else {
            session()->flash('error', 'No se encontró el ticket.');
        }
    }

    public function render()
    {
        $user = Auth::user();

        $tickets = Ticket::query();

        if ($user->role === 'admin' || $user->area_id === 1 || $user->area_id === 2) {
            // Admin puede ver todos los tickets con filtros globales
            $tickets->when($this->search, fn($q) => $q->where(function ($q2) {
                $q2->where('codigo', 'like', "%{$this->search}%")
                    ->orWhere('id', $this->search)
                    ->orWhere('osticket', 'like', "%{$this->search}%");
            }))
                ->when($this->filterType === 'solved', fn($q) => $q->where('estado_id', 5))
                ->when($this->filterType === 'pending', fn($q) => $q->where('estado_id', 1))
                ->when($this->filterType === 'paused', fn($q) => $q->where('estado_id', 6))
                ->when($this->filterType === 'anuled', fn($q) => $q->where('estado_id', 4))

                ->when(!in_array($this->filterType, ['solved', 'pending', 'paused', 'anuled']) && $this->filterType, fn($q) => $q->where('tipo', $this->filterType))
                ->when($this->startDate && $this->endDate, fn($q) => $q->whereBetween('created_at', [$this->startDate, $this->endDate]));
        } else {

            // Usuarios normales: filtrados por tipo y área
            $tickets->when($this->tipo === 'mis', function ($q) use ($user) {
                $q->where('assigned_to', $user->id);
            })
                ->when($this->tipo === 'pendientes', fn($q) => $q->where('area_id', $user->area_id)->whereNull('assigned_to'))
                ->when($this->tipo === 'todos', fn($q) => $q->where('area_id', $user->area_id))
                ->when($this->search, fn($q) => $q->where(function ($q2) {
                    $q2->where('codigo', 'like', "%{$this->search}%")
                        ->orWhere('id', $this->search)
                        ->orWhere('osticket', 'like', "%{$this->search}%");
                }))
                ->when($this->filterType === 'solved', fn($q) => $q->where('estado_id', 5))
                ->when($this->filterType === 'pending', fn($q) => $q->where('estado_id', 1))
                ->when($this->filterType === 'paused', fn($q) => $q->where('estado_id', 6))
                ->when(!in_array($this->filterType, ['solved', 'pending', 'paused']) && $this->filterType, fn($q) => $q->where('tipo', $this->filterType))
                ->when($this->startDate && $this->endDate, fn($q) => $q->whereBetween('created_at', [$this->startDate, $this->endDate]));
        }

        $tickets = $tickets->latest()->paginate($this->perPage);

        return view('livewire.ticket.ticket-list', compact('tickets'));
    }
}
