<?php

namespace App\Livewire\CallLogs\Dashboard;

use App\Models\CallLog;
use Carbon\Carbon;
use Livewire\Component;

class MonthlyActiveCallsCard extends Component
{
    public int $selectedMonth;
    public int $selectedYear;

    public  int $currentMonthCalls = 0;
    public  int $previousMonthCalls = 0;
    public  float $percentageChange = 0.0;


    public function mount(): void
    {
        $this->selectedMonth = now()->month;
        $this->selectedYear = now()->year;

        $this->loadCallsData();
    }

      private function loadCallsData(): void
    {
        $currentStart = Carbon::create($this->selectedYear, $this->selectedMonth, 1)->startOfMonth();
        $currentEnd = Carbon::create($this->selectedYear, $this->selectedMonth, 1)->endOfMonth();

        $previousStart = $currentStart->copy()->subMonth()->startOfMonth();
        $previousEnd = $currentStart->copy()->subMonth()->endOfMonth();

        $this->currentMonthCalls = CallLog::whereBetween('created_at', [$currentStart, $currentEnd])->count();

        $this->previousMonthCalls = CallLog::whereBetween('created_at', [$previousStart, $previousEnd])->count();

        if ($this->previousMonthCalls > 0) {
            $this->percentageChange = (($this->currentMonthCalls - $this->previousMonthCalls) / $this->previousMonthCalls) * 100;
        } else {
            $this->percentageChange = 0;
        }
    }


    public function render()
    {
        return view('livewire.call-logs.dashboard.monthly-active-calls-card');
    }
}
