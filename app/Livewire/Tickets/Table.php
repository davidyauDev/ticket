<?php

namespace App\Livewire\Tickets;

use App\Models\Ticket;
use App\Models\Area; // Importar el modelo de áreas
use Illuminate\Support\Facades\Auth;
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
    public $selectedArea = null; // Propiedad para el área seleccionada
    public $estados = ''; // Inicializa la variable
    public $areas = []; // Lista de áreas disponibles

    public function buscarTicket()
    {
        $this->validate([
            'codigoInput' => 'required|string'
        ]);
        try {
            $response = Http::get("http://54.197.148.155/numbers.php?search=".urlencode($this->codigoInput));
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
        $this->areas = [
            ['id' => 1, 'name' => 'Soporte Técnico'],
            ['id' => 2, 'name' => 'Atención al Cliente'],
            ['id' => 3, 'name' => 'Desarrollo'],
        ];
    }

    public function registrarTicket()
    {
        try {
            if (!$this->ticketData) {
                throw new \Exception('No hay datos del ticket para registrar.');
            }
            Ticket::create([
                'external_ticket_id' => $this->ticketData['ticket_id'],
                'number' => $this->ticketData['number'],
                'user_id' => Auth::id(),
                'status_id' => $this->status_id ?? 1,
                'dept_id' => $this->dept_id ?? 1,
                'sla_id' => $this->sla_id?? 1,
                'topic_id' => $this->topic_id ?? 1,
                'est_duedate' => $this->ticketData['est_duedate'] ?? null,
                'subject' => $this->ticketData['subject'],
                'priority' => $this->priority ?? 'normal',
                'tkt_fhsolicitud' => $this->ticketData['tkt_fhsolicitud'] ?? now(),
                'falla_reportada' => $this->ticketData['falla_reportada'] ?? $this->notes,
                'id_equipo' => $this->ticketData['id_equipo'] ?? null,
                'activo' => $this->ticketData['activo'] ?? null,
                'tkt_billeteadulterado' => $this->codigoInput,
                'created_by' => 1,
            ]);       
            $this->reset(['codigoInput', 'ticketData', 'notes', 'showModal']);
            $this->dispatch('notify', type: 'success', message: 'Ticket registrado exitosamente');
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            $this->addError('ticketError', 'Error al registrar el ticket: ' . $e->getMessage());
        }
    }

    public function mostrarArea()
    {
        return $this->mostrarArea;
    }

    public function render()
    {
        $tickets = Ticket::paginate(10);
        $areas = Area::all(); 
        return view('livewire.tickets.table', compact('tickets', 'areas'));
    }
}
