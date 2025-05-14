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

class DetalleTicket extends Component
{
    public $ticket;
    public $areas = [];
    public $estados = [];
    public $estado_id;
    public $observacion = '';
    public $comentario = '';
    public $selectedArea = null;


    public function mount($ticket)
    {
        $this->ticket = Ticket::findOrFail($ticket);
        $this->areas = Area::all();
        $this->estados = Estado::all();
    }

    public function ActualizarTicket()
    {
        DB::beginTransaction();
        try {

            $assignedTo = null;
            if ($this->estado_id == 2) {
                if (!$this->selectedArea) {
                    throw new \Exception('Debe seleccionar un área si el estado es "Derivado".');
                }
                $areaId = $this->selectedArea;
            } else {
                $areaId = Auth::user()->area_id;
                $assignedTo = Auth::id();
            }
            TicketHistorial::where('ticket_id', $this->ticket->id)
                ->where('is_current', true)
                ->update(['is_current' => false]);
             $this->ticket->assigned_to = Auth::id();
             $this->ticket->save();
            // Crear historial
             $comentarioHistorial = 'Se actualizó el ticket.';
            $accionHistorial = 'Actualizado';
            if ($this->selectedArea == 5) { // Cerrado
                $comentarioHistorial = 'Ticket Cerrado.';
                $accionHistorial = 'Cerrado';
            } elseif ($this->selectedArea == 2) { // Derivado
                $comentarioHistorial = 'Derivado al área correspondiente.';
                $accionHistorial = 'Derivado';
            }
            TicketHistorial::create([
                'ticket_id'    => $this->ticket->id,
                'usuario_id'   => Auth::id(),
                'from_area_id' => $this->ticket->area_id,
                'to_area_id'   => $this->selectedArea,
                'asignado_a'   => null,
                'estado_id'    => $this->ticket->estado_id,
                'accion' => $accionHistorial,
                'comentario' => $comentarioHistorial,
                'is_current'   => true,
                'comentario'   => null
            ]);
            DB::commit();
            $this->dispatch('notifyActu', type: 'success', message: 'Ticket actualizado exitosamente');
             $this->reset(['observacion', 'comentario']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al asignar ticket: ' . $e->getMessage());
            $this->addError('asignacion', 'Ocurrió un error al asignar el ticket.');
        }
    }

    
    public function render()
    {

        $historiales = \App\Models\TicketHistorial::with(['usuario', 'estado', 'fromArea', 'toArea', 'asignadoA'])
        ->where('ticket_id', $this->ticket->id,)
        ->orderBy('created_at', 'asc')
        ->get();
        return view('livewire.detalle-ticket', [
        'ticket' => $this->ticket,
        'historiales' => $historiales, 
    ]);
    }
}
