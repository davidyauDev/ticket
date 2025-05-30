<?php

namespace App\Livewire\Ticket;

use App\Models\Agencia;
use App\Models\Area;
use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\Equipo;
use App\Models\Estado;
use App\Models\Observacion;
use App\Models\Ticket;
use App\Models\TicketHistorial;
use App\Services\TicketService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class TicketFormModal extends Component
{
    public $areas = [];
    public $estados = [];
    public $observaciones = [];
    public $selectedArea = null;
    public $selectedSubarea = null;
    public $subareas = [];
    public $codigoInput = '';
    public $ticketData = null;
    public $showModal = false;
    public $tipoTicket = 'consulta';
    public $estado_id = 1;
    public string $archivoNombre = '';
    public $observacionPersonalizada = '';
    public $observacion;
    public $comentario = '';
    public $notes = '';
    public $archivo;
    public bool $resueltoAlCrear = false;

    public function mount()
    {
        $this->areas = Area::whereNull('parent_id')->get()->toArray();
        $this->estados = Estado::where('nombre', 'Pendiente')->get();
        $this->observaciones = Observacion::select('id', 'descripcion')->get()->toArray();
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
            'observacion' => 'required',
            'comentario' => 'required|string'
        ]);

        if ($this->tipoTicket !== 'consulta' && $this->ticketData == null) {
            $this->addError('ticketError', 'Busque primero el ticket');
            return;
        }

        try {
            $service->registrar([
                'ticketData' => $this->ticketData,
                'tipo' => $this->tipoTicket,
                'estado_id' => $this->estado_id,
                'selectedArea' => $this->selectedArea,
                'observacion' => $this->observacion,
                'comentario' => $this->comentario,
                'notes' => $this->notes,
                'archivo' => $this->archivo,
                'resuelto' => $this->resueltoAlCrear,
            ]);

            $this->resetForm();
            $this->dispatch('user-saved');
        } catch (\Exception $e) {
            $this->dispatch('notifyError');
        }
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
            'resueltoAlCrear'
        ]);
        $this->resetErrorBag();
    }


    public function render()
    {
        return view('livewire.ticket.ticket-form-modal');
    }
}
