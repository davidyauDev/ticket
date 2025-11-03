<?php

namespace App\Livewire;

use App\Jobs\ReassignTicketJob;
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
use Illuminate\Support\Facades\Http;

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
    public $selectedArea = 5;
    public string $archivoNombre = '';
    public $subareas = [];
    public $selectedSubarea = null;
    public bool $reasignarAOrigen = false;
    public $responsables;
    public $usuario_derivacion;
    public $userAsignado;

    public function mount($ticket)
    {
        $this->ticket = Ticket::query()
            ->join('equipos', 'tickets.equipo_id', '=', 'equipos.id')
            ->join('modelos', 'equipos.modelo_id', '=', 'modelos.id')
            ->select('tickets.*', 'equipos.modelo_id', 'modelos.descripcion as modelo_descripcion')
            ->where('tickets.id', $ticket)
            ->firstOrFail();

        $this->estados = Estado::all();

        $this->responsables = DB::table('users as u')
    ->leftJoin('responsables_modelo as rm', function ($join) {
        $join->on('rm.id_user', '=', 'u.id')
             ->where('rm.id_modelo', '=', $this->ticket->modelo_id);
    })
    ->select(
        'u.id',
        'u.name',
        'u.lastname',
        'rm.prioridad'
    )
    ->where('u.area_id', 2)
    ->where('u.available', true)
    ->orderBy('rm.prioridad', 'asc')
    ->get();


        if ($this->responsables->isNotEmpty()) {
            $this->usuario_derivacion = $this->responsables->first()->id;
        }
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
            if ($this->estado_id == Estado::DERIVADO) {
                $this->ticket->area_id = $this->selectedSubarea;
                $comentarioHistorial = $this->comentario;
                $accionHistorial = TicketHistorial::ACCION_DERIVADO;
                $this->userAsignado = User::find($this->usuario_derivacion);
                if ($this->usuario_derivacion) {
                    $this->ticket->assigned_to = $this->usuario_derivacion;
                }
            } elseif ($this->estado_id == Estado::CERRADO) {
                $comentarioHistorial = $this->comentario;
                $accionHistorial = TicketHistorial::ACCION_CERRADO;
            } elseif ($this->estado_id == Estado::PAUSADO) {
                $comentarioHistorial = $this->comentario;
                $accionHistorial = TicketHistorial::ACCION_PAUSADO;
                DB::commit();
                $this->pausarTicket();
                return;
            } else {
                $this->ticket->assigned_to = Auth::id();
                $this->ticket->area_id = Auth::user()->area_id;
                $this->estado_id = Estado::PENDIENTE;
                $comentarioHistorial = $this->comentario;
                $accionHistorial = TicketHistorial::ACCION_ACTUALIZADO;
            }

            $this->ticket->estado_id = $this->estado_id;
            $this->ticket->save();

            TicketHistorial::where('ticket_id', $this->ticket->id)
                ->where('is_current', true)
                ->update([
                    'ended_at' => now(),
                    'is_current' => false,
                ]);

            $isCerrado = $this->estado_id == Estado::CERRADO;
            $historial = TicketHistorial::create([
                'ticket_id'    => $this->ticket->id,
                'usuario_id'   => Auth::id(),
                'from_area_id' => Auth::user()->area_id,
                'to_area_id'   => $this->selectedSubarea ?? null,
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
                $this->notifyDerivacion();
                dispatch(new ReassignTicketJob($this->ticket->id, $this->ticket->assigned_to))->delay(now()->addMinutes(15));
            }
            $this->dispatch('notifyActu', type: 'success', message: 'Ticket actualizado exitosamente');
            $this->reset(['observacion', 'comentario', 'archivo', 'archivoNombre', 'selectedArea', 'selectedSubarea']);
        } catch (\Exception $e) {

            DB::rollBack();
            Log::error('Error al asignar ticket: ' . $e->getMessage());
            $this->addError('asignacion', 'Ocurrió un error al asignar el ticket.');
        }
    }

    private function notifyDerivacion()
    {
        try {
            // Mail::to($this->userAsignado->email)->queue(new TicketNotificadoMail($this->ticket));
            Log::info("Enviando notificación de derivación a {$this->userAsignado->phone}");
            Log::info("Enviando notificación de derivación a {$this->userAsignado->email}");

            // Obtener la sesión activa de WhatsApp
            // $activeSession = DB::table('whats_app_sessions')
            //     ->where('status', 'active')
            //     ->first();

            // if (!$activeSession) {
            //     Log::error("No hay sesión activa de WhatsApp disponible para notificar derivación");
            //     throw new \Exception('No hay sesión activa de WhatsApp disponible');
            // }

            // $response = Http::asForm()->post(env('WHATSAPP_API_URL'), [
            //     'sessionId' => $activeSession->session_id,
            //     'to'        => '51' . $this->userAsignado->phone,
            //     'message'   => "*Ticket asignado OST #{$this->ticket->osticket} - {$this->ticket->motivo_derivacion}*\n" .
            //         "Agencia: {$this->ticket->agencia->nombre}\n" .
            //         "Técnico: {$this->ticket->tecnico_nombres} {$this->ticket->tecnico_apellidos}\n\n" .
            //         "*Por favor, revisa el sistema MESA DE AYUDA para más detalles.*\n" .
            //         "Gracias.",
            // ]);


            // if ($response->successful()) {
            //     $data = $response->json();
            //     $data['success'] && $data['status']
            //         ? Log::info("WhatsApp enviado: " . $data['message'])
            //         : Log::warning("Fallo parcial en envío WhatsApp", $data);
            // } else {
            //     Log::error("Error HTTP al enviar WhatsApp", [
            //         'status' => $response->status(),
            //         'body'   => $response->body(),
            //     ]);
            // }
        } catch (\Exception $e) {
            Log::error("Error al enviar notificación de derivación: " . $e->getMessage());
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
        return $this->ticket->assigned_to == Auth::id();
    }


    public function asignarme()
    {
        if ($this->ticket->estado_id !== 2) {
            $this->dispatch('notifyActu', type: 'error', message: 'No puedes asignarte este ticket.');
            return;
        }

        $this->ticket->assigned_to = Auth::id();
        $this->ticket->estado_id = 1; // Cambia a pendiente
        $this->ticket->save();

        // Cierra historial anterior
        TicketHistorial::where('ticket_id', $this->ticket->id)
            ->where('is_current', true)
            ->update([
                'ended_at' => now(),
                'is_current' => false,
            ]);

        // Crea nuevo historial
        $this->ticket->historiales()->create([
            'usuario_id' => Auth::id(),
            'estado_id' => 1,
            'accion' => 'Asignado manualmente',
            'comentario' => 'El ticket fue asignado manualmente por el usuario.',
            'started_at' => now(),
            'is_current' => true,
        ]);

        $this->dispatch('notifyActu', type: 'success', message: 'Te has asignado el ticket correctamente.');
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
    ->when($this->searchComentario, function ($query) {
        $query->where('comentario', 'like', '%' . $this->searchComentario . '%');
    })
    ->orderBy('created_at', 'desc')
    ->orderBy('id', 'desc') // <-- segundo criterio
    ->get();

        return view('livewire.detalle-ticket', [
            'ticket' => $this->ticket,
            'historiales' => $historiales,
        ]);
    }
}
