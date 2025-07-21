<div class="rounded-2xl border border-gray-200 bg-white  dark:border-gray-800 dark:bg-white/[0.03] md:p-6">

   <!-- Título y Filtro en la misma fila -->
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Tickets Cerrados</h3>

        <!-- Selector de Mes -->
        <select wire:model.live="selectedMonth"
            class="border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="0">Todos los Meses</option>
            @for ($month = 1; $month <= 12; $month++) <option value="{{ $month }}">{{
                \Carbon\Carbon::create()->month($month)->translatedFormat('F') }}</option>
                @endfor
        </select>
    </div>

    <!-- Gráfico Donut -->
    <div x-data="graficoDonut(@entangle('chartData'))" x-init="initChart()" class="my-6" wire:ignore>
        <div id="grafico-donut" class="w-full h-64"></div>
    </div>

</div>

<script>
    function graficoDonut(chartData) {
        return {
            chart: null,
            chartData,
            initChart() {
                const el = document.querySelector('#grafico-donut');
                this.chart = new ApexCharts(el, {
                    chart: {
                        type: 'donut',
                        height: 300
                    },
                    series: this.chartData.series,
                    labels: this.chartData.labels,
                    colors: ['#3b82f6', '#60a5fa', '#bfdbfe'], // Azul oscuro, azul medio, azul claro
                    legend: {
                        show: true,
                        position: 'bottom',
                        labels: {
                            colors: '#64748b',
                            useSeriesColors: false
                        }
                    },
                    dataLabels: {
                        enabled: true
                    },
                    stroke: {
                        width: 0
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                labels: {
                                    show: true,
                                    name: { show: true },
                                    value: { show: true },
                                    total: { show: true }
                                }
                            }
                        }
                    }
                });
                this.chart.render();

                this.$watch('chartData', (newData) => {
                    this.chart.updateSeries(newData.series);
                    this.chart.updateOptions({
                        labels: newData.labels
                    });
                });
            }
        }
    }
</script>
