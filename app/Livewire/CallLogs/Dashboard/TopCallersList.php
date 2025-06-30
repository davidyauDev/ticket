<?php

namespace App\Livewire\CallLogs\Dashboard;

use App\Models\CallLog;
use Livewire\Component;

class TopCallersList extends Component
{
    public array $topCallers = [];
    public int $selectedMonth;

    public function mount(): void
    {
        $this->selectedMonth = 0;
        $this->loadTopCallers();
    }

    public function updatedSelectedMonth(): void
    {
        $this->loadTopCallers();
    }

    private function loadTopCallers(): void
    {
        $query = CallLog::select('user_id')
            ->selectRaw('COUNT(*) as total_calls')
            ->whereNotNull('user_id')
            ->whereYear('created_at', now()->year);
        if ($this->selectedMonth > 0) {
            $query->whereMonth('created_at', $this->selectedMonth);
        }

        $this->topCallers = $query->groupBy('user_id')
            ->orderByDesc('total_calls')
            ->with('user')
            ->take(5)
            ->get()
            ->map(function ($log) {
                return [
                    'name' => $log->user->name ?? 'Sin Nombre',
                    'total_calls' => $log->total_calls
                ];
            })
            ->toArray();
    }


    public function render()
    {
        return view('livewire.call-logs.dashboard.top-callers-list');
    }
}
