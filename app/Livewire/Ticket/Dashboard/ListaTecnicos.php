<?php

namespace App\Livewire\Ticket\Dashboard;

use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ListaTecnicos extends Component
{
    public array $topTechnicians = [];
    public array $technicianCalls = [];

    public int $selectedMonth;
    public bool $showModal = false;

    public function mount(): void
    {
        $this->selectedMonth = 0;
        $this->loadTopTechnicians();
    }

    public function updatedSelectedMonth(): void
    {
        $this->loadTopTechnicians();
    }

   private function loadTopTechnicians(): void
{
    $query = Ticket::select('staff_id')
        ->selectRaw('COUNT(*) as total_tickets')
        ->whereNotNull('staff_id')
        ->whereYear('created_at', now()->year);

    if ($this->selectedMonth > 0) {
        $query->whereMonth('created_at', $this->selectedMonth);
    }

    $this->topTechnicians = $query->groupBy('staff_id')
        ->orderByDesc('total_tickets')
        ->with('tecnico')
        ->take(5)
        ->get()
        ->map(function ($ticket) {
            return [
                'name' => $ticket->tecnico 
                    ? $ticket->tecnico->firstname . ' ' . $ticket->tecnico->lastname
                    : 'Sin Nombre',
                'total_tickets' => $ticket->total_tickets
            ];
        })
        ->toArray();
}

 public function showModal2(): void
    {
        $this->loadTechnicianCalls();
        $this->showModal = true;
    }
     private function loadTechnicianCalls(): void
{
    $query = DB::table('tickets')
        ->join('tecnicos', 'tickets.staff_id', '=', 'tecnicos.staff_id')
        ->select(
            'tickets.id',
            'tickets.comentario',
            'tickets.created_at as ticket_created_at',
            'tecnicos.name',
            'tecnicos.lastname'
        )
        ->whereNotNull('tickets.staff_id')
        ->whereYear('tickets.created_at', now()->year);

    if ($this->selectedMonth > 0) {
        $query->whereMonth('tickets.created_at', $this->selectedMonth);
    }

    $calls = $query->orderByDesc('tickets.created_at')->get();

    $grouped = [];

    foreach ($calls as $call) {
        $technicianName = trim(($call->name ?? '') . ' ' . ($call->lastname ?? '')) ?: 'Sin Nombre';

        if (!isset($grouped[$technicianName])) {
            $grouped[$technicianName] = [
                'total' => 0,
                'calls' => []
            ];
        }

        $grouped[$technicianName]['total']++;
        $grouped[$technicianName]['calls'][] = [
            'date' => Carbon::parse($call->ticket_created_at)->format('d/m/Y H:i'),
            'comentario' => $call->comentario ?? 'Sin comentario',
            'type' => $call->type ?? 'Sin tipo',
            'id' => $call->id,
        ];
    }

    $this->technicianCalls = $grouped;
}



    /**
     * Cierra el modal.
     *
     * @return void
     */
    public function closeModal(): void
    {
        $this->showModal = false;
    }


    public function render()
    {
        return view('livewire.ticket.dashboard.lista-tecnicos');
    }
}
