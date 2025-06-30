<?php

namespace App\Livewire\CallLogs\Dashboard;

use App\Models\CallLog;
use Carbon\Carbon;
use Livewire\Component;

class CallsPerDayBarChart extends Component
{
    public array $chartData = [];
    public int $selectedMonth;


    public function mount(): void
    {
        $this->selectedMonth = now()->month;
        $this->loadChartData();
    }

    public function updatedSelectedMonth(): void
    {
        $this->loadChartData();
    }

    private function loadChartData(): void
{
    $daysInMonth = Carbon::create(now()->year, $this->selectedMonth)->daysInMonth;
    $types = ['Soporte', 'Consulta', 'Reclamo'];

    $data = [];
    foreach ($types as $type) {
        $data[$type] = array_fill(1, $daysInMonth, 0);
    }

    $calls = CallLog::selectRaw('DAY(created_at) as day, type, COUNT(*) as total_calls')
        ->whereYear('created_at', now()->year)
        ->whereMonth('created_at', $this->selectedMonth)
        ->groupBy('day', 'type')
        ->orderBy('day')
        ->get();

    foreach ($calls as $call) {
        $data[$call->type][$call->day] = $call->total_calls;
    }

    $this->chartData = [
        'series' => [
            ['name' => 'Soporte', 'data' => array_values($data['Soporte'])],
            ['name' => 'Consulta', 'data' => array_values($data['Consulta'])],
            ['name' => 'Reclamo', 'data' => array_values($data['Reclamo'])]
        ],
        'categories' => range(1, $daysInMonth)
    ];
}


    public function render()
    {
        return view('livewire.call-logs.dashboard.calls-per-day-bar-chart');
    }
}
