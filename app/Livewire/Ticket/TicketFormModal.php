<?php

namespace App\Livewire\Ticket;

use App\Models\Area;
use App\Models\Estado;
use App\Models\Observacion;
use App\Models\Ticket;
use App\Models\TicketHistorial;
use App\Models\TipoSoporte;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\TicketService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Features\SupportFileUploads\WithFileUploads;


class TicketFormModal extends Component
{
    use WithPagination;
    use  WithFileUploads;

    public $areas = [];
    public $estados = [];
    public $observaciones = [];
    public $selectedArea = null;
    public $selectedSubarea = null;
    public $subareas = [];
    public $codigoInput = 'OS00';
    public $ticketData = null;
    public $showModal = false;
    public $tipoTicket = 'ticket';
    public $estado_id = 1;
    public string $archivoNombre = '';
    public $observacionPersonalizada = '';
    public $observacion;
    public $comentario = '';
    public $notes = '';
    public $archivo;
    public $soporte = [];
    public bool $resueltoAlCrear = false;
    public bool $derivar = false;
    public $tipoSoporte = null;
    public $ticket;

    public $motivosDerivacion = [
        'Derivar a taller por caída',
        'Billete falso o adulterado',
        'Técnico no logró resolver en esta instancia',
        'Derivado por complejidad del caso',
        'Software',
        'Otros',
    ];

    public $motivo_derivacion = null;


    public function mount()
    {
        $this->areas = Area::whereNull('parent_id')->get()->toArray();
        $this->estados = Estado::where('nombre', 'Pendiente')->get();
        $this->observaciones = Observacion::select('id', 'descripcion')->get()->toArray();
        $this->soporte = TipoSoporte::select('id', 'nombre')->get()->toArray();
    }

    #[On('abrirModalCreacionTicket')]
    public function abrirModal()
    {
        $this->showModal = true;
    }

    public function updatedSelectedArea($areaId)
    {
        $this->subareas = Area::where('parent_id', $areaId)->get()->toArray();
        $this->selectedSubarea = null;
    }

    public function buscarTicket()
    {
        $this->validate([
            'codigoInput' => 'required|string'
        ]);
        try {
            $response = Http::get("http://54.197.148.155/numbers.php?search=" . urlencode($this->codigoInput));
            $data = $response->json();
            if (empty($data)) {
                $this->addError('ticketError', 'No se encontraron datos para el ticket ingresado.');
                return;
            }
            if (empty($data[0]['dni'])) {
                $this->addError('ticketError', 'Ticket no asignado a un usuario');
                return;
            }
            $this->ticketData = count($data) ? $data[0] : null;
        } catch (\Exception $e) {
            $this->addError('ErrorConsulta', 'Error al obtener datos del ticket');
        }
    }

    public function registrarTicket(TicketService $service)
    {
        $this->validate([
            'observacion' => 'nullable',
            'comentario' => 'required|string'
        ]);

        if ($this->tipoTicket !== 'consulta' && $this->ticketData == null) {
            $this->addError('ticketError', 'Busque primero el ticket');
            return;
        }

        try {
            $ticket = $service->registrar([
                'ticketData' => $this->ticketData,
                'tipo' => $this->tipoTicket,
                'estado_id' => $this->estado_id,
                'selectedArea' => $this->selectedArea,
                'observacion' => $this->observacion,
                'comentario' => $this->comentario,
                'notes' => $this->notes,
                'archivo' => $this->archivo,
                'resuelto' => $this->resueltoAlCrear,
                'tipo_soporte_id' => $this->tipoSoporte ?? null
            ]);
            if ($this->derivar) {
                Log::info($ticket->id);
                $this->asignarDerivacion($ticket->id);
            }

            $this->resetForm();
            $this->dispatch('user-saved');
        } catch (\Exception $e) {
            Log::error('Error al registrar ticket: ' . $e->getMessage());
            $this->dispatch('notifyError');
        }
    }

    /**
     * Lógica de derivación separada
     */
    public function asignarDerivacion($ticketID)
    {
        $ticket = Ticket::find($ticketID);
        if (!$ticket) {
            Log::error('Ticket no encontrado para derivación: ' . $ticketID);
            return;
        }
        $user = Auth::user();
        $areaNombre = $user?->area?->nombre;
        $AreaSelecionada = Area::where('nombre', $areaNombre)
            ->whereHas('parent', function ($query) {
                $query->where('nombre', 'Ingeniería')->whereNull('parent_id');
            })
            ->value('id');
        $prioridades = User::where('area_id', $AreaSelecionada)
            ->where('available', true)
            ->orderBy('priority')
            ->pluck('priority')
            ->unique();

        $usuarioAsignado = null;
        foreach ($prioridades as $prioridad) {
            $usuarioAsignado = User::where('area_id', $AreaSelecionada)
                ->where('available', true)
                ->where('priority', $prioridad)
                ->first();

            if ($usuarioAsignado) {
                break;
            }
        }

        if ($usuarioAsignado) {
            Log::info("Asignando ticket a usuario: " . $usuarioAsignado->id);
            $ticket->assigned_to = $usuarioAsignado->id;
        } else {
            Log::info("vacio");
            $ticket->assigned_to = null;
        }

        // Guardar motivo de derivación
        $ticket->motivo_derivacion = $this->motivo_derivacion;
        $historial = TicketHistorial::create([
            'ticket_id'    => $ticketID,
            'usuario_id'   => Auth::id(),
            'from_area_id' => Auth::user()->area_id,
            'to_area_id'   => $AreaSelecionada,
            'asignado_a'   => $usuarioAsignado->id,
            'estado_id'    => 2,
            'accion'       => 'Derivado',
            'comentario'   => 'Derivado',
            'started_at'   => now(),
            'ended_at'     => null,
            'is_current'   => false,
        ]);
        if ($this->archivo) {
            $ruta = $this->archivo->store('tickets', 'public');
            $historial->archivos()->create([
                'nombre_original' => $this->archivo->getClientOriginalName(),
                'ruta' => $ruta,
            ]);
        }
        if ($usuarioAsignado) {
            $ticket->assigned_to = $usuarioAsignado->id;
        } else {
            $ticket->assigned_to = null;
        }
        $ticket->save();

        Log::info('Ticket derivado', ['ticket_id' => $ticketID, 'asignado_a' => $usuarioAsignado?->id, 'motivo_derivacion' => $this->motivo_derivacion]);
    }

    public function resetForm()
    {
        $this->reset([
            'observacion',
            'comentario',
            'archivo',
            'archivoNombre',
            'tipoTicket',
            'estado_id',
            'selectedArea',
            'selectedSubarea',
            'ticketData',
            'codigoInput',
            'notes',
            'showModal',
            'resueltoAlCrear',
            'tipoSoporte'
        ]);
        $this->resetErrorBag();
    }

    public function updatedArchivo($value)
    {
        $this->archivoNombre = $value->getClientOriginalName();
    }

    public function render()
    {
        return view('livewire.ticket.ticket-form-modal');
    }
}
