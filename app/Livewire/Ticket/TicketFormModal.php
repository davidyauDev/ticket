<?php

namespace App\Livewire\Ticket;

use App\Mail\TicketNotificadoMail;
use App\Models\Area;
use App\Models\Equipo;
use App\Models\Estado;
use App\Models\Observacion;
use App\Models\Ticket;
use App\Models\TicketHistorial;
use App\Models\TipoSoporte;
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
                    'rm.id_modelo',
                    'rm.prioridad',
                    'rm.fecha_asignacion'
                )
                ->where('u.area_id', 2)
                ->orderBy('rm.prioridad', 'asc')
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

            $equipo = Equipo::where('id_equipo', $data[0]['id_equipo'])->first();
            if ($equipo) {
                $ultimoTicket = Ticket::where('equipo_id', $equipo->id)
                    ->orderBy('created_at', 'desc')
                    ->first();
                if ($ultimoTicket->estado_id != 5) {
                    $this->ticketPendiente = true;
                    $this->ticketEnProceso = $ultimoTicket->id;
                    $this->ticketEnProcesoOst = $ultimoTicket->osticket;
                    return;
                }
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
                'tipo_soporte_id' => $this->tipoSoporte ?? null,
                'motivo_derivacion' => $this->motivo_derivacion ?? null
            ]);
            if ($this->derivar) {
                $this->asignarDerivacion($ticket->id);
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

            Log::info($userAsginado->email);
            Log::info($userAsginado->phone);

            //Mail::to($userAsginado->email)->queue(new TicketNotificadoMail($ticket));
            $response = Http::asForm()->post('http://172.19.0.17/whatsapp/api/send', [
                'sessionId' => 'mi-sesion-14',
                'to'        => '51' . $userAsginado->phone,
                'message'   => '(Mensaje de Prueba ignorar)Se te asignó un ticket OST #' . $ticket->osticket . ' - ' . $ticket->titulo . '. Por favor, revisa el sistema MESA DE AYUDA para más detalles. Gracias.',
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if ($data['success'] && $data['status']) {
                    Log::info("WhatsApp enviado: " . $data['message']);
                } else {
                    Log::warning("Fallo parcial en envío WhatsApp", $data);
                }
            } else {
                Log::error("Error HTTP al enviar WhatsApp", [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
            }
        }
        $ticket->motivo_derivacion = $this->motivo_derivacion;
        $ticket->save();
        TicketHistorial::create([
            'ticket_id'    => $ticketID,
            'usuario_id'   => Auth::id(),
            'from_area_id' => Auth::user()->area_id,
            'to_area_id'   => $AreaSelecionada,
            'asignado_a'   => $this->usuario_derivacion,
            'estado_id'    => 2,
            'accion'       => 'Derivado',
            'comentario'   => 'Derivado',
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
