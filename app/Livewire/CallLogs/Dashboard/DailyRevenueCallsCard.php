<?php

namespace App\Livewire\CallLogs\Dashboard;

use App\Models\CallLog;
use Carbon\Carbon;
use Livewire\Component;

class DailyRevenueCallsCard extends Component
{
    public float $todayCalls = 0.0;
    public float $yesterdayCalls  = 0.0;
    public float $percentageChange = 0.0;

    public function mount(): void
    {
        $this->loadCallsData();
    }

    private function loadCallsData(): void
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        $this->todayCalls = CallLog::whereDate('created_at', $today)->count();
        $this->yesterdayCalls = CallLog::whereDate('created_at', $yesterday)->count();

        if ($this->yesterdayCalls > 0) {
            $this->percentageChange = (($this->todayCalls - $this->yesterdayCalls) / $this->yesterdayCalls) * 100;
        } else {
            $this->percentageChange = 0;
        }
    }

    public function render()
    {
        return view('livewire.call-logs.dashboard.daily-revenue-calls-card');
    }
}
