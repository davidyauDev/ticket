<?php

namespace App\Livewire\CallLogs\Dashboard;

use App\Models\CallLog;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class MostCalledTechniciansCard extends Component
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

        $query = CallLog::select('tecnico_id')
            ->selectRaw('COUNT(*) as total_calls')
            ->whereNotNull('tecnico_id')
            ->whereYear('created_at', now()->year);

        if ($this->selectedMonth > 0) {
            $query->whereMonth('created_at', $this->selectedMonth);
        }

        $this->topTechnicians = $query->groupBy('tecnico_id')
            ->orderByDesc('total_calls')
            ->with('user')
            ->take(5)
            ->get()
            ->map(function ($log) {
                return [
                    'name' => $log->tecnico->name.$log->tecnico->lastname ?? 'Sin Nombre',
                    'total_calls' => $log->total_calls
                ];
            })
            ->toArray();
    }

    /**
     * Muestra el modal.
     *
     * @return void
     */
    public function showModal2(): void
    {
        $this->loadTechnicianCalls();
        $this->showModal = true;
    }
    private function loadTechnicianCalls(): void
{
    $query = CallLog::select('tecnico_id', 'created_at', 'description','type')
        ->whereNotNull('tecnico_id')
        ->whereYear('created_at', now()->year);

    if ($this->selectedMonth > 0) {
        $query->whereMonth('created_at', $this->selectedMonth);
    }

    $calls = $query->with('tecnico')->orderByDesc('created_at')->get();

    $grouped = [];

    foreach ($calls as $call) {
        $technicianName = $call->tecnico->name.$call->tecnico->lastname ?? 'Sin Nombre';

        if (!isset($grouped[$technicianName])) {
            $grouped[$technicianName] = [
                'total' => 0,
                'calls' => []
            ];
        }

        $grouped[$technicianName]['total']++;
        $grouped[$technicianName]['calls'][] = [
            'date' => $call->created_at->format('d/m/Y H:i'),
            'comment' => $call->description ?? 'Sin comentario',
            'type' => $call->type ?? 'Sin tipo'
        ];
        Log::info($call);
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
        return view('livewire.call-logs.dashboard.most-called-technicians-card');
    }
}
