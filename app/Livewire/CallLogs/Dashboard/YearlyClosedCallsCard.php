<?php

namespace App\Livewire\CallLogs\Dashboard;

use App\Models\CallLog;
use Carbon\Carbon;
use Livewire\Component;

class YearlyClosedCallsCard extends Component
{
    public int $selectedYear;
    public int $currentYearCalls = 0;
    public int $previousYearCalls = 0;
    public float $percentageChange = 0;

    public function mount(): void
    {
        $this->selectedYear = now()->year;

        $this->loadCallsData();
    }

    public function updatedSelectedYear(): void
    {
        $this->loadCallsData();
    }

    private function loadCallsData(): void
    {
        $currentStart = Carbon::create($this->selectedYear, 1, 1)->startOfYear();
        $currentEnd = Carbon::create($this->selectedYear, 1, 1)->endOfYear();

        $previousStart = $currentStart->copy()->subYear()->startOfYear();
        $previousEnd = $currentStart->copy()->subYear()->endOfYear();

        $this->currentYearCalls = CallLog::whereBetween('created_at', [$currentStart, $currentEnd])->count();

        $this->previousYearCalls = CallLog::whereBetween('created_at', [$previousStart, $previousEnd])->count();

        if ($this->previousYearCalls > 0) {
            $this->percentageChange = (($this->currentYearCalls - $this->previousYearCalls) / $this->previousYearCalls) * 100;
        } else {
            $this->percentageChange = 0;
        }
    }

    public function render()
    {
        return view('livewire.call-logs.dashboard.yearly-closed-calls-card');
    }
}
