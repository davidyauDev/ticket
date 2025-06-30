<?php

namespace App\Livewire\CallLogs\Dashboard;

use App\Models\CallLog;
use Livewire\Component;

class CallTypesDonutChart extends Component
{
    public array $chartData = [];
    public int $selectedMonth;

    public function mount(): void
    {
        $this->selectedMonth = 0;
        $this->loadChartData();
    }

    public function updatedSelectedMonth(): void
    {
        $this->loadChartData();
    }

    private function loadChartData(): void
    {
        $query = CallLog::select('type')
            ->selectRaw('COUNT(*) as total_calls')
            ->whereYear('created_at', now()->year);

        if ($this->selectedMonth > 0) {
            $query->whereMonth('created_at', $this->selectedMonth);
        }

        $results = $query->groupBy('type')
            ->orderBy('type')
            ->get();

        $types = ['Soporte', 'Consulta', 'Reclamo'];

        $data = [
            'series' => [],
            'labels' => []
        ];

        foreach ($types as $type) {
            $count = $results->firstWhere('type', $type)?->total_calls ?? 0;
            $data['series'][] = $count;
            $data['labels'][] = $type;
        }

        $this->chartData = $data;
    }

    public function render()
    {
        return view('livewire.call-logs.dashboard.call-types-donut-chart');
    }
}
