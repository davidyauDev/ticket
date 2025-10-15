<?php

namespace App\Livewire\Ticket\Dashboard;

use App\Models\Ticket;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ListaTecnicos extends Component
{
    public array $topTechnicians = [];
    public array $technicianCalls = [];

    public int $selectedMonth;
    public bool $showModal = false;

    public int $totalCalls = 0;


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
        ->leftJoin('equipos', 'tickets.equipo_id', '=', 'equipos.id')
        ->leftJoin('modelos', 'equipos.modelo_id', '=', 'modelos.id')
        ->leftJoin('tipos_soporte', 'tickets.tipo_soporte_id', '=', 'tipos_soporte.id')
        ->select(
            'tickets.id',
            'tickets.comentario',
            'tickets.created_at as ticket_created_at',
            'tecnicos.name',
            'tecnicos.lastname',
            'tickets.motivo_derivacion',
            'modelos.descripcion as modelo',
            'tipos_soporte.nombre as tipo_soporte'
        )
        ->whereNotNull('tickets.staff_id')
        ->whereYear('tickets.created_at', now()->year);

    if ($this->selectedMonth > 0) {
        $query->whereMonth('tickets.created_at', $this->selectedMonth);
    }

    $calls = $query->orderByDesc('tickets.created_at')->get();

    // 🔹 Calcular total general
    $this->totalCalls = $calls->count();

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
            'id' => $call->id,
            'date' => Carbon::parse($call->ticket_created_at)->format('d/m/Y H:i'),
            'comentario' => $call->tipo_soporte ?? $call->motivo_derivacion ?? $call->comentario,
            'modelo' => $call->modelo ?? 'Sin modelo',
        ];
    }

    uasort($grouped, fn($a, $b) => $b['total'] <=> $a['total']);

    $this->technicianCalls = $grouped;
}





public function generatePDF()
{
    // Cargar llamadas detalladas
    $this->loadTechnicianCalls();

    // Datos generales
    $technicians = $this->topTechnicians;
    $callsByTech = $this->technicianCalls;

    // Preparar gráfico (barras)
    $labels = collect($technicians)->pluck('name')->toArray();
    $values = collect($technicians)->pluck('total_tickets')->toArray();

    $chartUrl = 'https://quickchart.io/chart?c=' . urlencode(json_encode([
        'type' => 'bar',
        'data' => [
            'labels' => $labels,
            'datasets' => [[
                'label' => 'Total de llamadas por técnico',
                'data' => $values,
                'backgroundColor' => '#3B82F6'
            ]]
        ],
        'options' => [
            'plugins' => [
                'legend' => ['display' => false],
                'title' => [
                    'display' => true,
                    'text' => 'Técnicos más llamados ' . now()->year
                ]
            ],
            'scales' => ['y' => ['beginAtZero' => true]]
        ]
    ]));

    // Renderizar vista PDF
    $pdf = Pdf::loadView('pdf.reporte-tecnicos', [
        'technicians' => $technicians,
        'callsByTech' => $callsByTech,
        'chartUrl' => $chartUrl,
        'month' => $this->selectedMonth > 0
            ? Carbon::create()->month($this->selectedMonth)->translatedFormat('F')
            : 'Todos los meses',
    ])->setPaper('a4', 'portrait');

    return response()->streamDownload(
        fn() => print($pdf->output()),
        'reporte_tecnicos_' . now()->format('Y_m_d_His') . '.pdf'
    );
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
