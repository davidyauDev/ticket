<?php

namespace App\Livewire\CallLogs\Dashboard;

use App\Models\CallLog;
use Livewire\Component;

class MostCalledTechniciansCard extends Component
{
    public array $topTechnicians = [];
    public int $selectedMonth;

    public function mount(): void
    {
        $this->selectedMonth = 0;
        $this->loadTopTechnicians();
    }

    public function updatedSelectedMonth() : void
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
                    'name' => $log->tecnico->name ?? 'Sin Nombre',
                    'total_calls' => $log->total_calls
                ];
            })
            ->toArray();
    }


    public function render()
    {
        return view('livewire.call-logs.dashboard.most-called-technicians-card');
    }
}
