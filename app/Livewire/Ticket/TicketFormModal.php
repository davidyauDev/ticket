<?php

namespace App\Livewire\Ticket;

use App\Jobs\ReassignTicketJob;
use App\Mail\TicketNotificadoMail;
use App\Models\Area;
use App\Models\Equipo;
use App\Models\Estado;
use App\Models\Observacion;
use App\Models\Ticket;
use App\Models\TicketHistorial;
use App\Models\TipoSoporte;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\TicketService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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
    public $codigoInput = 'OS0056418';
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
    public $responsables;
    public bool $resueltoAlCrear = false;
    public bool $derivar = false;
    public $tipoSoporte = null;
    public $ticket;
    public bool $ticketPendiente = false;
    public int  $ticketEnProceso;
    public $ticketEnProcesoOst;
    public $usuario_derivacion;

    public $motivosDerivacion = [
        'Derivar a taller por caída',
        'Billete falso o adulterado',
        'Técnico no logró resolver en esta instancia',
        'Derivado por complejidad del caso',
        'Soporte de Repuestos',
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
        $this->reset([
            'ticketPendiente',
            'ticketEnProceso',
            'ticketEnProcesoOst',
            'ticketData'
        ]);

        $this->validate([
            'codigoInput' => 'required|string'
        ]);
        try {
            $response = Http::get("http://172.19.0.14/api/numbers.php?search=" . urlencode($this->codigoInput));
            $data = $response->json();

            if (empty($data)) {
                $this->addError('ticketError', 'No se encontraron datos para el ticket ingresado.');
                return;
            }
            $this->responsables = DB::table('users as u')
                ->leftJoin('responsables_modelo as rm', function ($join) use ($data) {
                    $join->on('rm.id_user', '=', 'u.id')
                        ->where('rm.id_modelo', '=', $data[0]['id_modelo']);
                })
                ->select(
                    'u.id',
                    'u.name',
                    'u.lastname',
                    'rm.id_modelo',
                    'rm.prioridad',
                    'rm.fecha_asignacion'
                )
                ->where('u.area_id', 2)
                ->orderBy('rm.prioridad', 'asc')
                ->where('u.available', true)
                ->get();


            if ($this->responsables->isNotEmpty()) {
                $derivado = $this->responsables
                    ->filter(fn($r) => !is_null($r->prioridad))
                    ->sortBy('prioridad')
                    ->first();
                if ($derivado) {
                    $this->usuario_derivacion = $derivado->id;
                }
            }

            if (empty($data[0]['id_tecnico'])) {
                $this->addError('ticketError', 'Ticket no asignado a un usuario');
                return;
            }

            $idEquipo = $data[0]['id_equipo'] ?? null;
            if (!$idEquipo) {
                $this->addError('ticketError', 'El ticket no tiene equipo asignado.');
                return;
            }

            $equipo = Equipo::where('id_equipo', $idEquipo)->first();
            if ($equipo) {
                $ultimoTicket = Ticket::where('equipo_id', $equipo->id)
                    ->orderBy('created_at', 'desc')
                    ->first();

                if ($ultimoTicket && $ultimoTicket->estado_id != 5) {
                    $this->ticketPendiente = true;
                    $this->ticketEnProceso = $ultimoTicket->id;
                    $this->ticketEnProcesoOst = $ultimoTicket->osticket;
                    return;
                }
            }


            $this->ticketData = count($data) ? $data[0] : null;
        } catch (\Exception $e) {
            Log::info('Error al obtener datos del ticket: ' . $e->getMessage());
            $this->dispatch('Errorwsp');
            $this->addError('ErrorConsulta', 'Error al obtener datos del ticket');
        }
    }

    public function registrarTicket(TicketService $service)
    {
        $this->validate([
            'tipoSoporte' => 'nullable',
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
                'tipo_soporte_id' => $this->tipoSoporte ?? null,
                'motivo_derivacion' => $this->motivo_derivacion ?? null
            ]);
            if ($this->derivar) {
                try {
                    $this->asignarDerivacion($ticket->id);
                    dispatch(new ReassignTicketJob($ticket->id, $ticket->assigned_to))->delay(now()->addMinutes(15));
                } catch (\Exception $e) {
                    // Si falla la derivación (incluido WhatsApp), eliminar el ticket creado
                     $ticket->delete();
                    Log::error('Error en derivación: ' . $e->getMessage());
                    $this->addError('derivacionError', 'Error al enviar notificación WhatsApp. El proceso ha sido cancelado.');
                }
            }

            $this->resetForm();
            $this->dispatch('user-saved');
        } catch (\Exception $e) {
            Log::error('Error al registrar ticket: ' . $e->getMessage());
            $this->dispatch('notifyError');
        }
    }

    public function asignarDerivacion($ticketID)
    {
        $ticket = Ticket::find($ticketID);
        $user = Auth::user();
        $areaNombre = $user?->area?->nombre;

        $AreaSelecionada = Area::where('nombre', $areaNombre)
            ->whereHas('parent', function ($query) {
                $query->where('nombre', 'Ingeniería')->whereNull('parent_id');
            })
            ->value('id');

        if ($this->usuario_derivacion) {
            $ticket->assigned_to = $this->usuario_derivacion;
            $ticket->area_id = $AreaSelecionada;
            $ticket->estado_id = 2;

            $userAsginado = DB::table('users')
                ->where('id', $this->usuario_derivacion)
                ->select('email', 'phone')
                ->first();

            Mail::to($userAsginado->email)->queue(new TicketNotificadoMail($ticket));

            // Obtener la sesión activa de WhatsApp
            $activeSession = DB::table('whats_app_sessions')
                ->where('status', 'active')
                ->first();

            if (!$activeSession) {
                throw new \Exception('No hay sesión activa de WhatsApp disponible');
            }

            $response = Http::asForm()->post(env('WHATSAPP_API_URL'), [
                'sessionId' => $activeSession->session_id,
                'to'        => '51' . $userAsginado->phone,
                'message'   => "*Ticket asignado OST #{$ticket->osticket} - {$ticket->motivo_derivacion}*\n" .
                    "Agencia: {$ticket->agencia->nombre}\n" .
                    "Técnico: {$ticket->tecnico_nombres} {$ticket->tecnico_apellidos}\n" .
                    "*Por favor, revisa el sistema MESA DE AYUDA para más detalles.*\n" .
                    "Gracias.",
            ]);


            if ($response->successful()) {
                $data = $response->json();

                if ($data['status'] === true) {
                    Log::info("WhatsApp enviado correctamente: " . $data['message']);
                } else {
                    Log::warning("Error al enviar WhatsApp", $data);
                    throw new \Exception('Error al enviar WhatsApp: ' . ($data['message'] ?? 'Dispositivo no inicializado o error en el servicio'));
                }
            } else {
                Log::error("Error HTTP al enviar WhatsApp", [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                throw new \Exception('Error HTTP al enviar WhatsApp. Status: ' . $response->status());
            }
        }
        $ticket->motivo_derivacion = $this->motivo_derivacion;
        $ticket->save();

        $nextAssignee = User::find($this->usuario_derivacion);


        TicketHistorial::create([
            'ticket_id'    => $ticketID,
            'usuario_id'   => Auth::id(),
            'from_area_id' => Auth::user()->area_id,
            'to_area_id'   => $AreaSelecionada,
            'asignado_a'   => $this->usuario_derivacion,
            'estado_id'    => 2,
            'accion'       => "Ticket asignado {$nextAssignee->name}  según prioridad del modelo.",
            'comentario'   => "Ticket asignado automáticamente {$nextAssignee->name}  según prioridad del modelo.",
            'started_at'   => now(),
            'ended_at'     => null,
            'is_current'   => false,
        ]);
        $ticket->save();
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
