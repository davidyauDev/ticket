<div class="bg-white p-6 rounded-xl shadow border border-gray-100 dark:bg-white/[0.03] dark:border-gray-800">

    <!-- Encabezado y Filtro -->
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-base font-semibold text-gray-700 dark:text-white/90">Llamadas por Día</h2>

        <select wire:model.live="selectedMonth"
            class="border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            @for ($month = 1; $month <= 12; $month++) <option value="{{ $month }}">{{
                \Carbon\Carbon::create()->month($month)->translatedFormat('F') }}</option>
                @endfor
        </select>
    </div>

    <!-- Gráfico -->
    <div x-data="graficoLlamadas(@entangle('chartData'))" x-init="initChart()" wire:ignore>
        <div id="grafico-llamadas" class="w-full h-64"></div>
    </div>

</div>

<script>
    function graficoLlamadas(chartData) {
        return {
            chart: null,
            chartData,

            initChart() {
                const el = document.querySelector('#grafico-llamadas');

                this.chart = new ApexCharts(el, {
                    chart: {
                        type: 'bar',
                        height: 300,
                        stacked: true, // Requerido para multi-serie por día
                        toolbar: { show: false }
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 4,
                            columnWidth: '40%',
                        }
                    },
                    series: this.chartData.series,
                    xaxis: {
                        categories: this.chartData.categories,
                        labels: {
                            style: {
                                colors: '#007aff',
                                fontSize: '12px'
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: '#64748b',
                                fontSize: '12px'
                            }
                        }
                    },
                    colors: ['#3b82f6', '#60a5fa', '#bfdbfe'], // Soporte, Consulta, Reclamo
                    grid: {
                        borderColor: '#f1f5f9'
                    },
                    
                    noData: {
                        text: "No hay datos",
                        align: 'center',
                        verticalAlign: 'middle',
                        style: {
                            color: '#64748b',
                            fontSize: '14px'
                        }
                    }
                });

                this.chart.render();

                this.$watch('chartData', (newData) => {
                    this.chart.updateSeries(newData.series);
                    this.chart.updateOptions({
                        xaxis: { categories: newData.categories }
                    });
                });
            }
        }
    }
</script>