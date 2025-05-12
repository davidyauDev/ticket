<?php

namespace App\Livewire\Tickets;

use App\Models\Agencia;
use App\Models\Ticket;
use App\Models\Area; // Importar el modelo de áreas
use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\Equipo;
use App\Models\Estado;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;
use Livewire\Component;
use Livewire\Attributes\Url;

class Table extends Component
{
    use WithPagination;
    #[Url]
    public $search = '';
    #[Url]
    public $estado = 'Todos';
    #[Url]
    public $usuario = '';
    public $showModal = false;
    public $codigoInput = '';
    public $ticketData = null;
    public $notes = '';
    public $sla_id;
    public $topic_id;
    public $mostrarArea = true;
    public $selectedArea = null;
    public $estados = '';
    public $areas = [];
    public $tipoTicket = 'ticket';
    public $observacion = '';
    public $comentario = '';
    public $estado_id;
    public $tipo = 'todos';

    public function buscarTicket()
    {
        $this->validate([
            'codigoInput' => 'required|string'
        ]);
        try {
            $response = Http::get("http://54.197.148.155/numbers.php?search=" . urlencode($this->codigoInput));
            $data = $response->json();
            $this->ticketData = count($data) ? $data[0] : null;
        } catch (\Exception $e) {
            $this->addError('ticketError', 'Error al obtener datos del ticket');
        }
    }
    public function derivar()
    {
        $this->mostrarArea = true;
    }
    public function mount()
    {
        $this->areas = Area::all();
        $this->estados = Estado::all();

    }
    public function registrarTicket()
    {
        DB::beginTransaction();
        try {
            if (!$this->ticketData) {
                throw new \Exception('No hay datos del ticket para registrar.');
            }
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
            $assignedTo = Auth::id();
            if ($this->estado_id == 2) { // Suponiendo que 2 es el ID del estado "Derivado"
                if (!$this->selectedArea) {
                    throw new \Exception('Debe seleccionar un área si el estado es "Derivado".');
                }
                $areaId = $this->selectedArea;
            } else {
                $areaId = null;
                $assignedTo = Auth::id(); // Asignar al usuario actual si no es derivado
            }

            $ticket = Ticket::create([
                'codigo' => $this->ticketData['ticket_id'],
                'asunto' => $this->ticketData['subject'],
                'falla_reportada' => $this->ticketData['falla_reportada'] ?? $this->notes,
                'equipo_id' => $equipo->id,
                'agencia_id' => $agencia->id,
                'cliente_id' => $cliente->id,
                'empresa_id' => $empresa->id,
                'tecnico_dni' => $this->ticketData['dni'],
                'tecnico_nombres' => $this->ticketData['nombres'],
                'tecnico_apellidos' => $this->ticketData['apellidos'],
                'comentario' => $this->comentario,
                'tipo' => $this->tipoTicket,
                'estado_id' => $this->estado_id,
                'observacion' => $this->observacion,
                'area_id' => $areaId,
                'assigned_to' => $assignedTo,
                'created_by' => Auth::id(),
            ]);
            DB::commit();
            $this->reset(['codigoInput', 'ticketData', 'notes', 'showModal']);
            $this->dispatch('notify', type: 'success', message: 'Ticket registrado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al registrar el ticket: ' . $e->getMessage());
            $this->addError('ticketError', 'Error al registrar el ticket: ' . $e->getMessage());
        }
    }

    public function mostrarArea()
    {
        return $this->mostrarArea;
    }

    public function render()
    {
        if ($this->tipo === 'mis') {
            $tickets = Ticket::where('created_by', Auth::id())->paginate(10);
        } else {
            $tickets = Ticket::paginate(10);
        }

        return view('livewire.tickets.table', compact('tickets'));
    }
}
