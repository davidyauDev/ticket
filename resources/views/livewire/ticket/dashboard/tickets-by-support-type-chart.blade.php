<div class="bg-white p-6 rounded-xl shadow border border-gray-100 dark:bg-white/[0.03] dark:border-gray-800">

    <!-- Encabezado y Filtro -->
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-base font-semibold text-gray-700 dark:text-white/90">Tickets por Tipo de Soporte</h2>

        <select wire:model.live="selectedMonth"
            class="border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="0">Todos los Meses</option>
            @for ($month = 1; $month <= 12; $month++) <option value="{{ $month }}">
                {{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }}
                </option>
                @endfor
        </select>
    </div>
    <!-- Gráfico -->
    <div x-data="graficoSoporte(@entangle('chartData'))" x-init="initChart()" wire:ignore>
        <div id="grafico-soporte" class="w-full h-64"></div>
    </div>

</div>

<script>
    function graficoSoporte(chartData) {
        return {
            chart: null,
            chartData,

            initChart() {
                const el = document.querySelector('#grafico-soporte');

                this.chart = new ApexCharts(el, {
                    chart: {
                        type: 'bar',
                        height: this.chartData.categories.length * 60,
                        toolbar: { show: false }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: true,
                            borderRadius: 4,
                            barHeight: '50%',
                        }
                    },
                    series: [{
                        name: 'Total Tickets',
                        data: this.chartData.series
                    }],
                    xaxis: {
                        categories: this.chartData.categories,
                        labels: {
                            style: {
                                colors: '#007aff',
                                fontSize: '12px',
                                whiteSpace: 'normal'
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
                    colors: ['#3b82f6'], // Color corporativo
                    grid: {
                        borderColor: '#f1f5f9'
                    },
                    noData: {
                        text: "No hay datos disponibles",
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
                    this.chart.updateSeries([{ data: newData.series }]);
                    this.chart.updateOptions({
                        xaxis: { categories: newData.categories }
                    });
                });
            }
        }
    }
</script>