<?php

namespace App\Livewire\Ticket\Dashboard;

use App\Models\Ticket;
use App\Models\TicketHistorial;
use Carbon\Carbon;
use Livewire\Component;

class TicketsPorAreaMesa extends Component
{
    public array $topTechnicians = [];
    public array $technicianCalls = [];
    public array $modelChartData = [];

    public int $selectedMonth;
    public bool $showModal = false;
    public ?int $selectedTechnicianId = null;

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

        $query = Ticket::select('assigned_to')
            ->selectRaw('COUNT(*) as total_tickets')
            ->where('estado_id', 5)
            ->whereNotNull('assigned_to')
            ->whereYear('created_at', now()->year);

        if ($this->selectedMonth > 0) {
            $query->whereMonth('created_at', $this->selectedMonth);
        }

        $this->topTechnicians = $query->groupBy('assigned_to')
            ->orderByDesc('total_tickets')
            ->with([
                'assignedUser' => function ($q) {
                    $q->select('id', 'firstname', 'lastname');
                }
            ])
            ->take(5)
            ->get()
            ->map(function ($ticket) {
                $user = $ticket->assignedUser;

                return [
                    'id' => $ticket->assigned_to, // ¡Añadimos el ID aquí para poder seleccionarlo!
                    'name' => $user
                        ? $user->firstname . ' ' . $user->lastname
                        : 'Sin Nombre Asignado',
                    'total_tickets' => $ticket->total_tickets
                ];
            })
            ->toArray();
    }
    public function showTechnicianDetails(int $technicianId): void
    {
        $this->selectedTechnicianId = $technicianId;
        $this->loadTechnicianDetails();
        $this->showModal = true;
    }

    private function loadTechnicianDetails(): void
    {
        // Si no hay técnico seleccionado, salimos
        if (is_null($this->selectedTechnicianId)) {
            return;
        }

        // 1. Cargar el listado de tickets (Modal Tab 1)
        $this->loadTechnicianCalls();

        // 2. Cargar los datos para el gráfico de modelos (Modal Tab 2)
        $this->loadModelChartData();
    }

    public function showModal2(): void
    {
        $this->loadTechnicianCalls();
        $this->showModal = true;
    }
  private function loadTechnicianCalls(): void
{
    $query = Ticket::query()
        ->whereNotNull('assigned_to')
        ->whereYear('created_at', now()->year);

    if ($this->selectedMonth > 0) {
        $query->whereMonth('created_at', $this->selectedMonth);
    }

    $calls = $query->with([
        'assignedUser:id,firstname,lastname',
        'equipo.modelo:id,descripcion'
    ])
        ->orderByDesc('created_at')
        ->get();

    $grouped = [];

    foreach ($calls as $ticket) {
        $user = $ticket->assignedUser;

        $userName = 'Sin Nombre Asignado';
        if ($user) {
            $userName = trim(($user->firstname ?? '') . ' ' . ($user->lastname ?? ''));
        }

        $technicianName = $userName ?: 'Sin Nombre Asignado';

        if (!isset($grouped[$technicianName])) {
            $grouped[$technicianName] = [
                'total' => 0,
                'calls' => []
            ];
        }

        $fechaInicio = $ticket->created_at;
        $historialCierre = TicketHistorial::where('ticket_id', $ticket->id)
            ->whereHas('estado', fn($q) => $q->where('nombre', 'cerrado'))
            ->orderByDesc('created_at')
            ->first();

        $fechaCierre = $historialCierre?->created_at;
        $tiempoEfectivo = null;

        if ($fechaInicio && $fechaCierre) {
            $duracionTotal = $fechaInicio->diffInSeconds($fechaCierre);

            $pausas = TicketHistorial::where('ticket_id', $ticket->id)
                ->where('estado_id', 6)
                ->whereNotNull('started_at')
                ->whereNotNull('ended_at')
                ->get();

            $segundosEnPausa = $pausas->reduce(function ($carry, $pausa) {
                $startedAt = Carbon::parse($pausa->started_at);
                $endedAt = Carbon::parse($pausa->ended_at);
                return $carry + $startedAt->diffInSeconds($endedAt);
            }, 0);

            $tiempoEfectivo = $duracionTotal - $segundosEnPausa;

            $tiempoEfectivo = Carbon::now()
                ->addSeconds($tiempoEfectivo)
                ->diffForHumans(Carbon::now(), [
                    'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE,
                    'parts' => 3,
                ]);
        }

        $modelo = $ticket->equipo?->modelo;

        $grouped[$technicianName]['total']++;
        $grouped[$technicianName]['calls'][] = [
            'id'            => $ticket->id,
            'date'          => $ticket->created_at->format('d/m/Y H:i'),
            'motivo'    => $ticket->motivo_derivacion ?? 'Sin comentario',
            'type'          => $ticket->tipo ?? 'Sin tipo',
            'modelo'        => $modelo,
            'tiempo_total'  => $tiempoEfectivo ?? 'En progreso',
        ];
    }

    // Ordenar de mayor a menor por total de tickets
    uasort($grouped, fn($a, $b) => $b['total'] <=> $a['total']);

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
        return view('livewire.ticket.dashboard.tickets-por-area-mesa');
    }
}
