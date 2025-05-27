<?php

namespace App\Livewire\Tickets;

use App\Models\Agencia;
use App\Models\Ticket;
use App\Models\Area;
use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\Equipo;
use App\Models\Estado;
use App\Models\Observacion;
use App\Models\TicketHistorial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Table extends Component
{
    use WithPagination;
    use  WithFileUploads;
    #[Url]
    public $search = '';
    #[Url]
    public $estado = 'Todos';
    #[Url]
    public string $archivoNombre = '';

    public $observaciones = []; // Lista desde la BD
    public $observacionPersonalizada = '';

    public $usuario = '';
    public $showModal = false;
    public bool $showAnularModal = false;
    public bool $showAsigna = false;
    public ?int $ticketId = null;
    public $codigoInput = '';
    public $ticketData = null;
    public $notes = '';
    public $sla_id;
    public $topic_id;
    public $mostrarArea = true;
    public $selectedArea = null;
    public $estados = '';
    public $areas = [];
    public $tipoTicket = 'consulta';
    public $comentario = '';
    public $motivoAnulacion = '';
    public $estado_id = 1;
    public $tipo = 'todos';
    public ?int $registroId = null;
    public $archivo;
    public $subareas = [];
    public $selectedSubarea = null;
    public $observacion;
    public bool $resueltoAlCrear = false;

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

    public function updatedSelectedArea($value)
    {
        $this->subareas = Area::where('parent_id', $value)->get()->toArray();
        $this->selectedSubarea = null; 
    }

    public function derivar()
    {
        $this->mostrarArea = true;
    }

    public function asignar()
    {
        DB::beginTransaction();
        try {
            $ticket = Ticket::findOrFail($this->registroId);
            TicketHistorial::where('ticket_id', $ticket->id)
                ->where('is_current', true)
                ->update(['is_current' => false,'ended_at' => now()]);
            $ticket->assigned_to = Auth::id();
            $ticket->save();
            TicketHistorial::create([
                'ticket_id'    => $this->registroId,
                'usuario_id'   => Auth::id(),
                'from_area_id' => Auth::user()->area_id,
                'asignado_a'   => Auth::id(),
                'estado_id'    => $ticket->estado_id,
                'accion'       => 'El usuario se asignó el ticket',
                'is_current'   => true,
                'started_at'   => now(),
                'comentario'   => null
            ]);
            DB::commit();
            return redirect()->route('tickets.show', $ticket->id);
            $this->dispatch('notify1', type: 'success', message: 'Ticket Asginado con exito');
            $this->showAsigna = false;
            $this->registroId = null;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al asignar ticket: ' . $e->getMessage());
            $this->addError('asignacion', 'Ocurrió un error al asignar el ticket.');
        }
    }

    public function mount()
    {
        $this->areas = Area::whereNull('parent_id')->get()->toArray();
        $this->estados = Estado::where('nombre', 'Pendiente')->get();
        $this->observaciones = Observacion::select('id', 'descripcion')->get()->toArray();
    }

    public function registrarTicket()
    {
        $this->validate([
            'observacion' => 'required',
            'comentario' => 'required|string'
        ]);

        if ($this->tipoTicket !== 'consulta' && $this->ticketData == null) {
            $this->addError('ticketError', 'Busque primero el ticket');
            return;
        }
        DB::beginTransaction();
        try {
            $empresa = null;
            $cliente = null;
            $equipo = null;
            $agencia = null;
            if ($this->tipoTicket !== 'consulta') {
                $empresa = Empresa::firstOrNew([
                    'id' => $this->ticketData['id_empresa'],
                ], [
                    'nombre' => $this->ticketData['empresa'] ?? 'Empresa Desconocida',
                ]);

                if (!$empresa->exists) {
                    $empresa->save();
                }

                $cliente = Cliente::firstOrNew([
                    'id' => $this->ticketData['id_cliente'],
                ], [
                    'nombre' => $this->ticketData['cliente'] ?? 'Cliente Desconocido',
                    'empresa_id' => $empresa->id,
                ]);
                if (!$cliente->exists) {
                    $cliente->save();
                }

                $equipo = Equipo::firstOrNew([
                    'serie' => $this->ticketData['serie'],
                ], [
                    'modelo' => $this->ticketData['modelo'] ?? 'Modelo Desconocido',
                ]);
                if (!$equipo->exists) {
                    $equipo->save();
                }

                $agencia = Agencia::firstOrNew([
                    'id' => $this->ticketData['id_agencia'],
                ], [
                    'nombre' => $this->ticketData['agencia'] ?? 'Agencia Desconocida',
                    'cliente_id' => $this->ticketData['id_cliente'],
                ]);
                if (!$agencia->exists) {
                    $agencia->save();
                }
            }

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
            $ticketData = [
                'codigo' => $this->ticketData['ticket_id'] ?? null,
                'asunto' => $this->ticketData['subject'] ?? null,
                'falla_reportada' => $this->ticketData['falla_reportada'] ?? $this->notes,
                'tecnico_dni' => $this->ticketData['dni'] ?? null,
                'tecnico_nombres' => $this->ticketData['nombres'] ?? null,
                'tecnico_apellidos' => $this->ticketData['apellidos'] ?? null,
                'comentario' => $this->comentario,
                'tipo' => $this->tipoTicket,
                'estado_id' => $this->estado_id,
                'observacion_id' => $this->tipoTicket === 'ticket' ? $this->observacion : null,
                'observacion_consulta' => $this->tipoTicket === 'consulta' ? $this->observacion : null,
                'area_id' => $areaId,
                'assigned_to' => $assignedTo,
                'created_by' => Auth::id(),
            ];

            if ($this->tipoTicket !== 'consulta') {
                $ticketData['equipo_id'] = $equipo->id ?? null;
                $ticketData['agencia_id'] = $agencia->id ?? null;
                $ticketData['cliente_id'] = $cliente->id ?? null;
                $ticketData['empresa_id'] = $empresa->id ?? null;
            }

            $ticket = Ticket::create($ticketData);
            $comentarioHistorial = $this->comentario;
            $accionHistorial = match ($ticket->estado_id) {
                5 => 'Creado y Cerrado',
                2 => 'Creado y Derivado',
                default => 'Creado',
            };
            TicketHistorial::create([
                'ticket_id' => $ticket->id,
                'usuario_id' => Auth::id(),
                'from_area_id' => null,
                'to_area_id' => $ticket->area_id,
                'asignado_a' => $assignedTo,
                'estado_id' => $ticket->estado_id,
                'started_at' => now(),
                'accion' => $accionHistorial,
                'comentario' => $comentarioHistorial,
                'is_current' => true,
            ]);
            if ($this->archivo) {
                $ruta = $this->archivo->store('tickets', 'public');
                $ticket->archivos()->create([
                    'nombre_original' => $this->archivo->getClientOriginalName(),
                    'ruta' => $ruta,
                ]);
                $historial = $ticket->historiales()->latest()->first(); // Asumiendo relación `historial()`
                $historial->archivos()->create([
                    'nombre_original' => $this->archivo->getClientOriginalName(),
                    'ruta' => $ruta,
                ]);
            }
            if ($this->resueltoAlCrear) {
            $estadoCerrado = Estado::where('nombre', 'Cerrado')->first();

            $ticket->update([
                'estado_id' => $estadoCerrado->id,
            ]);

             TicketHistorial::create([
                 'ticket_id' => $ticket->id,
                 'usuario_id' => Auth::id(), 
                 'estado_id' => $estadoCerrado->id,
                 'started_at' => now(),
                 'ended_at' => now(),
                 'is_current' => true,
                 'accion' => 'Ticket cerrado al momento de su creación',
                 'comentario' => 'Ticket cerrado al momento de su creación',
             ]);
        }
            DB::commit();
            $this->reset(['codigoInput', 'ticketData', 'notes', 'showModal', 'comentario', 'observacion', 'archivo', 'archivoNombre']);
            $this->dispatch('notify', type: 'success', message: 'Ticket registrado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->reset(['codigoInput', 'ticketData', 'notes', 'showModal', 'comentario', 'observacion']);
            Log::error('Error al registrar el ticket: ' . $e->getMessage());
            $this->dispatch('notifyError', type: 'error', message: 'Error al registrar el ticket');
        }
    }
   
    public function updatedArchivo($value)
    {
        $this->archivoNombre = $value->getClientOriginalName();
    }

    public function confirmarAnulacion($id)
    {
        $this->registroId = $id;
        $this->showAnularModal = true;
    }

    public function confirmarAsignac($id)
    {
        $this->registroId = $id;
        $this->showAsigna = true;
    }

    public function anularRegistro()
    {
        $this->validate([
            'motivoAnulacion' => 'required|string'
        ]);

        $ticket = Ticket::find($this->registroId);
        if ($ticket) {
            $ticket->estado_id = 4;
            $ticket->save();
        }
        TicketHistorial::create([
            'ticket_id'    => $this->registroId,
            'usuario_id'   => Auth::id(),
            'from_area_id' => 1,
            'asignado_a'   => Auth::id(),
            'estado_id'    => $ticket->estado_id,
            'accion'       => 'Se anuló el ticket',
            'is_current'   => true,
            'comentario'   => $this->motivoAnulacion
        ]);

        $this->showAnularModal = false;
        $this->registroId = null;
        $this->dispatch('anular', type: 'success', message: 'Error');
    }

    public function mostrarArea()
    {
        return $this->mostrarArea;
    }
    public function render()
    {
        $user = Auth::user();
        $query = Ticket::query()
            ->when($this->tipo === 'mis', function ($q) {
                $q->where('assigned_to', Auth::id());
            })
            ->when($this->tipo === 'pendientes', function ($q) use ($user) {
                $q->where('area_id', $user->area_id)
                    ->whereNull('assigned_to');
            })
            ->when($this->tipo !== 'mis' && $this->tipo !== 'pendientes', function ($q) use ($user) {
                $q->where('area_id', $user->area_id);
            })
            ->when(!empty($this->search), function ($q) {
                $q->where(function ($subQuery) {
                    $subQuery->where('codigo', 'like', '%' . $this->search . '%')
                        ->orWhere('id', $this->search);
                });
            })
            ->orderByDesc('created_at');
        $tickets = $query->paginate(10);
        return view('livewire.tickets.table', compact('tickets'));
    }
}
