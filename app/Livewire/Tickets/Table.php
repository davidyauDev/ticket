<?php

namespace App\Livewire\Tickets;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Attributes\Url;

class Table extends Component
{

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

    public function registrarTicket()
    {

        Log::info($this->ticketData);
        try {
            Ticket::create([
                'external_ticket_id' => $this->ticketData['ticket_id'],
                'number' => $this->ticketData['number'],
                'user_id' => Auth::id(),
                'status_id' => $this->status_id,
                'dept_id' => $this->dept_id,
                'sla_id' => $this->sla_id,
                'topic_id' => $this->topic_id,
                'source' => $this->source,
                'est_duedate' => $this->ticketData['est_duedate'] ?? null,
                'subject' => $this->ticketData['subject'],
                'priority' => $this->priority,
                'tkt_fhsolicitud' => $this->ticketData['tkt_fhsolicitud'] ?? now(),
                'falla_reportada' => $this->ticketData['falla_reportada'] ?? $this->notes,
                'id_equipo' => $this->ticketData['id_equipo'] ?? null,
                'activo' => $this->ticketData['activo'] ?? null,
                'tkt_billeteadulterado' => $this->codigoInput
            ]);

            $this->reset(['codigoInput', 'ticketData', 'notes', 'showModal']);
            $this->dispatch('notify', type: 'success', message: 'Ticket registrado exitosamente');

        } catch (\Exception $e) {
            Log::info($e->getMessage());
           // $this->dispatch('notify', type: 'error', message: 'Error al registrar el ticket: '.$e->getMessage());
        }
    }



    public function render()
    {
        return view('livewire.tickets.table');
    }
}
