<?php

namespace App\Livewire;

use App\Models\Area;
use App\Models\Estado;
use App\Models\Ticket;
use App\Models\TicketHistorial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithFileUploads;

class DetalleTicket extends Component
{
    use WithFileUploads;
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


    public function mount($ticket)
    {
        $this->ticket = Ticket::findOrFail($ticket);
        $this->areas = Area::whereNull('parent_id')->get()->toArray();
        $this->estados = Estado::all();
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
        $this->selectedSubarea = null;
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

        return $inicio->diffForHumans($fin, [
            'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE,
            'parts' => 3,
        ]);
    }

    public function pausarTicket()
    {
        $this->ticket->update(['estado_id' => 6]); // 3 = Pausado (STOP)

        $this->ticket->historiales()->create([
            'usuario_id' => Auth::id(),
            'estado_id' => 6,
            'accion' => 'Ticket pausado',
        ]);
        $this->dispatch('notifyActu');
    }

    public function reanudarTicket()
    {
        DB::beginTransaction();

        try {
            // 1. Cierra el historial actual (que es el de "Pausado")
            $historialAnterior = TicketHistorial::where('ticket_id', $this->ticket->id)
                ->where('is_current', true)
                ->first();

            if ($historialAnterior) {
                $historialAnterior->update([
                    'ended_at' => now(),
                    'is_current' => false,
                ]);
            }

            // 2. Calcula duración de pausa (opcional, para el comentario)
            $duracion = null;
            if ($historialAnterior && $historialAnterior->estado_id == 6) {
                $duracion = $historialAnterior->started_at->diffForHumans(now(), [
                    'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE,
                    'parts' => 2,
                ]);
            }
            // 3. Cambia estado del ticket a "Pendiente" (o "En proceso", según lógica)
            $this->ticket->update([
                'estado_id' => 1, // Pendiente
                'assigned_to' => Auth::id(),
                'area_id' => Auth::user()->area_id,
            ]);

            // 4. Crea el nuevo historial de reanudación
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
            // 5. Notificación frontend
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

    public function ActualizarTicket()
    {
        DB::beginTransaction();
        try {
            if ($this->ticket->assigned_to !== Auth::id()) {
                abort(403, 'No tienes permiso para actualizar este ticket.');
            }

            $accionHistorial = 'Actualizado';
            $comentarioHistorial = $this->comentario; // por defecto

            if ($this->estado_id == 2) { // Derivado
                if (!$this->selectedArea) {
                    throw new \Exception('Debe seleccionar un área si el estado es "Derivado".');
                }
                $this->ticket->area_id = $this->selectedArea;
                $this->ticket->assigned_to = null;
                $comentarioHistorial = 'Derivado al área correspondiente.';
                $accionHistorial = 'Derivado';
            } elseif ($this->estado_id == 5) { // Cerrado
                $comentarioHistorial = 'Ticket Cerrado.';
                $accionHistorial = 'Cerrado';
            } elseif ($this->estado_id == 6) { // Pausado
                $comentarioHistorial = 'Ticket Pausado.';
                $accionHistorial = 'Pausado';
                DB::commit(); // cerrar posibles cambios previos si los hubo
                $this->pausarTicket();
                return;
                // No se cambia el área ni el técnico asignado
            } else {
                $this->ticket->assigned_to = Auth::id();
                $this->ticket->area_id = Auth::user()->area_id;
                $this->estado_id = 1; // Pendiente
            }
            $this->ticket->estado_id = $this->estado_id;
            $this->ticket->save();
            // Cerrar historial anterior
            TicketHistorial::where('ticket_id', $this->ticket->id)
                ->where('is_current', true)
                ->update([
                    'ended_at' => now(),
                    'is_current' => false,
                ]);

            // Identificar si es cerrado para setear ended_at al instante
            $isCerrado = $this->estado_id == 5;

            $historial = TicketHistorial::create([
                'ticket_id'    => $this->ticket->id,
                'usuario_id'   => Auth::id(),
                'from_area_id' => Auth::user()->area_id,
                'to_area_id'   => $this->selectedArea,
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

            $this->dispatch('notifyActu', type: 'success', message: 'Ticket actualizado exitosamente');
            $this->reset(['observacion', 'comentario']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al asignar ticket: ' . $e->getMessage());
            $this->addError('asignacion', 'Ocurrió un error al asignar el ticket.');
        }
    }


    public function getPuedeActualizarProperty(): bool
    {
        return $this->ticket->assigned_to === Auth::id();
    }

    public function render()
    {
        $historiales = TicketHistorial::with(['usuario', 'estado', 'fromArea', 'toArea', 'asignadoA', 'archivos'])
            ->where('ticket_id', $this->ticket->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('livewire.detalle-ticket', [
            'ticket' => $this->ticket,
            'historiales' => $historiales,
        ]);
    }
}
