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

    public function mount($ticket)
    {
        $this->ticket = Ticket::findOrFail($ticket);
        $this->areas = Area::all();
        $this->estados = Estado::all();
    }

    public function getFechaInicioProperty()
    {
        return $this->ticket->created_at;
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
            $comentarioHistorial = 'Se actualizó el ticket.';
            $accionHistorial = 'Actualizado';

            if ($this->estado_id == 2) { // Estado "Derivado"
                if (!$this->selectedArea) {
                    throw new \Exception('Debe seleccionar un área si el estado es "Derivado".');
                }
                $this->ticket->area_id = $this->selectedArea;
                $this->ticket->assigned_to = null;

                $comentarioHistorial = 'Derivado al área correspondiente.';
                $accionHistorial = 'Derivado';
            } elseif ($this->estado_id == 5) { // Estado "Cerrado"
                $comentarioHistorial = 'Ticket Cerrado.';
                $accionHistorial = 'Cerrado';
            } else {
                $this->ticket->assigned_to = Auth::id();
                $this->ticket->area_id = Auth::user()->area_id;
                $this->estado_id = 1;
            }

            $this->ticket->estado_id = $this->estado_id;
            $this->ticket->save();

            TicketHistorial::where('ticket_id', $this->ticket->id)
                ->where('is_current', true)
                ->update(['is_current' => false]);

            $historial = TicketHistorial::create([
                'ticket_id'    => $this->ticket->id,
                'usuario_id'   => Auth::id(),
                'from_area_id' => Auth::user()->area_id,
                'to_area_id'   => $this->selectedArea,
                'asignado_a'   => $this->ticket->assigned_to,
                'estado_id'    => $this->estado_id,
                'accion'       => $accionHistorial,
                'comentario'   => $this->comentario,
                'is_current'   => true,
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
