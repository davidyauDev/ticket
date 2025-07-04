<?php

namespace App\Livewire;

use App\Mail\TicketNotificadoMail;
use App\Models\Area;
use App\Models\Estado;
use App\Models\Ticket;
use App\Models\TicketHistorial;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Livewire\WithFileUploads;

class DetalleTicket extends Component
{
    use WithFileUploads;
    public $searchComentario = '';
    public $archivo;
    public $ticket;
    public $areas = [];
    public $estados = [];
    public $estado_id;
    public $observacion = '';
    public $comentario = '';
    public $selectedArea = null;
    public string $archivoNombre = '';
    public $subareas = [];
    public $selectedSubarea = null;
    public bool $reasignarAOrigen = false;

    public function mount($ticket)
    {
        $this->ticket = Ticket::findOrFail($ticket);
        $this->areas = Area::whereNull('parent_id')->get()->toArray();
        $this->estados = Estado::all();
        $this->subareas = Area::where('parent_id', 1)->get()->toArray();
    }

    public function getFechaInicioProperty()
    {
        return $this->ticket->created_at;
    }

    public function getEstaPausadoProperty(): bool
    {
        return $this->ticket->estado_id === 6;
    }
    public function updatedSelectedArea($value)
    {
        $this->subareas = Area::where('parent_id', $value)->get()->toArray();
        $this->selectedSubarea = count($this->subareas) > 0 ? $this->subareas[0]['id'] : null;
    }

    public function getFechaCierreProperty()
    {
        $historialCierre = TicketHistorial::where('ticket_id', $this->ticket->id)
            ->whereHas('estado', fn($q) => $q->where('nombre', 'cerrado'))
            ->orderBy('created_at', 'desc')
            ->first();
        return $historialCierre?->created_at;
    }

    public function getTiempoTotalProperty()
    {
        $inicio = $this->fechaInicio;
        $fin = $this->fechaCierre;

        if (!$inicio || !$fin) {
            return null;
        }
        $duracionTotal = $inicio->diffInSeconds($fin);
        $pausas = TicketHistorial::where('ticket_id', $this->ticket->id)
            ->where('estado_id', 6)
            ->whereNotNull('started_at')
            ->whereNotNull('ended_at')
            ->get();

        $segundosEnPausa = $pausas->reduce(function ($carry, $pausa) {
            $startedAt = Carbon::parse($pausa->started_at);
            $endedAt = Carbon::parse($pausa->ended_at);
            return $carry + $startedAt->diffInSeconds($endedAt);
        }, 0);

        $tiempoEfectivo = $duracionTotal - $segundosEnPausa;
        return Carbon::now()->addSeconds($tiempoEfectivo)->diffForHumans(Carbon::now(), [
            'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE,
            'parts' => 3,
        ]);
    }

    public function ActualizarTicket()
    {
        DB::beginTransaction();
        try {
            if ($this->ticket->assigned_to !== Auth::id()) {
                abort(403, 'No tienes permiso para actualizar este ticket.');
            }
            $accionHistorial = 'Actualizado';
            $comentarioHistorial = $this->comentario; // por defecto
            $usuariosDestino = collect(); // Inicializado vacío por si no se usa
            if ($this->reasignarAOrigen) {
                $historialActual = TicketHistorial::where('ticket_id', $this->ticket->id)
                    ->where('accion', 'Derivado')
                    ->orderByDesc('created_at')
                    ->first();
                if ($historialActual && $historialActual->usuario_id) {
                    $this->ticket->assigned_to = $historialActual->usuario_id;
                    $this->estado_id = 1; // Pendiente
                    $accionHistorial = 'Reasignado';
                }
            } elseif ($this->estado_id == 2) { // Derivado
                if (!$this->selectedArea || !$this->selectedSubarea) {
                    throw new \Exception('Debe seleccionar un área y subárea al derivar el ticket.');
                }
                $this->ticket->area_id = $this->selectedSubarea;
                $this->ticket->assigned_to = null;
                $comentarioHistorial = $comentarioHistorial;
                $accionHistorial = 'Derivado';
                //$usuariosDestino = User::where('area_id', $this->selectedSubarea)->get();
                // Correos por defecto si no hay usuarios destino
                if ($usuariosDestino->isEmpty()) {
                    $usuariosDestino = collect([
                        (object)[ 'email' => 'isaac.ramos@cechriza.com' ],
                        (object)[ 'email' => 'jenyfer.rojas@cechriza.com' ]
                    ]);
                }
                Log::info('Usuarios destino: ', $usuariosDestino->pluck('email')->toArray());
            } elseif ($this->estado_id == 5) { // Cerrado
                $comentarioHistorial = $comentarioHistorial;
                $accionHistorial = 'Cerrado';
            } elseif ($this->estado_id == 6) { // Pausado
                $comentarioHistorial = $comentarioHistorial;
                $accionHistorial = 'Pausado';
                DB::commit();
                $this->pausarTicket();
                return;
            } else {
                $this->ticket->assigned_to = Auth::id();
                $this->ticket->area_id = Auth::user()->area_id;
                $this->estado_id = 1; // Pendiente
            }

            $this->ticket->estado_id = $this->estado_id;
            $this->ticket->save();
            TicketHistorial::where('ticket_id', $this->ticket->id)
                ->where('is_current', true)
                ->update([
                    'ended_at' => now(),
                    'is_current' => false,
                ]);
            $isCerrado = $this->estado_id == 5;
            $historial = TicketHistorial::create([
                'ticket_id'    => $this->ticket->id,
                'usuario_id'   => Auth::id(),
                'from_area_id' => Auth::user()->area_id,
                'to_area_id'   => $this->selectedSubarea,
                'asignado_a'   => $this->ticket->assigned_to,
                'estado_id'    => $this->estado_id,
                'accion'       => $accionHistorial,
                'comentario'   => $comentarioHistorial,
                'started_at'   => now(),
                'ended_at'     => $isCerrado ? now() : null,
                'is_current'   => !$isCerrado,
            ]);

            if ($this->archivo) {
                $ruta = $this->archivo->store('tickets', 'public');
                $historial->archivos()->create([
                    'nombre_original' => $this->archivo->getClientOriginalName(),
                    'ruta' => $ruta,
                ]);
            }
            DB::commit();
            if ($accionHistorial === 'Derivado') {
                Log::info($accionHistorial);
                foreach ($usuariosDestino as $usuario) {
                    try {
                        Mail::to($usuario->email)->send(new TicketNotificadoMail($this->ticket));
                    } catch (\Exception $e) {
                        Log::error("Error al enviar correo a {$usuario->email}: " . $e->getMessage());
                    }
                }
            }
            $this->dispatch('notifyActu', type: 'success', message: 'Ticket actualizado exitosamente');
            $this->reset(['observacion', 'comentario', 'archivo', 'archivoNombre', 'selectedArea', 'selectedSubarea']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al asignar ticket: ' . $e->getMessage());
            $this->addError('asignacion', 'Ocurrió un error al asignar el ticket.');
        }
    }

    public function pausarTicket()
    {
        TicketHistorial::where('ticket_id', $this->ticket->id)
            ->where('is_current', true)
            ->update([
                'ended_at' => now(),
                'is_current' => false,
            ]);
        $this->ticket->update(['estado_id' => 6]);
        $this->ticket->historiales()->create([
            'usuario_id' => Auth::id(),
            'estado_id' => 6,
            'accion' => 'Pausado',
            'started_at'   => now(),
            'comentario' => $this->comentario,
        ]);
        $this->dispatch('notifyActu');
    }

    public function reanudarTicket()
    {
        DB::beginTransaction();
        try {
            $historialAnterior = TicketHistorial::where('ticket_id', $this->ticket->id)
                ->where('is_current', true)
                ->first();

            if ($historialAnterior) {
                $historialAnterior->update([
                    'ended_at' => now(),
                    'is_current' => false,
                ]);
            }
            $duracion = null;
            $this->ticket->update([
                'estado_id' => 1, // Pendiente
                'assigned_to' => Auth::id(),
                'area_id' => Auth::user()->area_id,
            ]);

            $this->ticket->historiales()->create([
                'usuario_id' => Auth::id(),
                'estado_id' => 1, // Pendiente
                'accion' => 'Ticket Reanudado',
                'comentario' => $duracion
                    ? "Ticket reanudado después de {$duracion} en pausa."
                    : "Ticket reanudado.",
                'started_at' => now(),
                'is_current' => true,
            ]);
            DB::commit();
            $this->reset(['observacion', 'comentario', 'archivo', 'archivoNombre', 'selectedArea', 'selectedSubarea']);
            $this->dispatch('notifyActu', type: 'success', message: 'Ticket reanudado correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al reanudar ticket: ' . $e->getMessage());
            $this->addError('reanudar', 'Ocurrió un error al reanudar el ticket.');
        }
    }

    public function updatedArchivo($value)
    {
        $this->archivoNombre = $value->getClientOriginalName();
    }


    public function getPuedeActualizarProperty(): bool
    {
        return $this->ticket->assigned_to === Auth::id();
    }

    public function render()
    {
        $historiales = TicketHistorial::with([
            'usuario',
            'estado',
            'fromArea',
            'toArea.parent',
            'asignadoA',
            'archivos'
        ])
            ->where('ticket_id', $this->ticket->id)
            ->orderBy('created_at', 'desc')
              ->when($this->searchComentario, function ($query) {
                $query->where('comentario', 'like', '%' . $this->searchComentario . '%');
            })
            ->get();
        return view('livewire.detalle-ticket', [
            'ticket' => $this->ticket,
            'historiales' => $historiales,
        ]);
    }
}
