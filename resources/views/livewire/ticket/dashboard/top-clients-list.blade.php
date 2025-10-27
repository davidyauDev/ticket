<!-- CONTENEDOR -->
<div
    class="rounded-3xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900/80 p-6 shadow-lg hover:shadow-xl transition-all duration-300">

    <!-- ENCABEZADO -->
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
            <span class="inline-block w-1.5 h-6 bg-gradient-to-b from-blue-500 to-cyan-400 rounded-full"></span>
            Clientes con mas tickets
        </h3>

        <!-- Selector de Mes -->
        <div
            class="relative flex items-center rounded-xl border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/60 hover:border-blue-500 transition-all">
            <select wire:model.live="selectedMonth"
                class="appearance-none bg-transparent px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 cursor-pointer focus:outline-none">
                <option value="0">Todos los meses</option>
                @for ($month = 1; $month <= 12; $month++)
                    <option value="{{ $month }}">
                        {{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>
            <svg class="absolute right-2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor"
                stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6" />
            </svg>
        </div>
    </div>

    <!-- SEPARADOR -->
    <div class="border-t border-gray-200 dark:border-gray-700 mb-4"></div>

    <!-- GRÁFICO -->
    <div x-data="graficoTopClientes(@entangle('chartData'))" x-init="initChart()" wire:ignore>
        <div id="grafico-top-clientes" class="w-full h-[320px]"></div>
    </div>

    <!-- FOOTER -->
    <div class="flex justify-end mt-4">
        <p class="text-xs text-gray-500 dark:text-gray-400 italic">
            Actualizado al {{ now()->format('d/m/Y H:i') }}
        </p>
    </div>
</div>

<script>
    function graficoTopClientes(chartData) {
        return {
            chart: null,
            chartData,
            initChart() {
                const el = document.querySelector('#grafico-top-clientes');
                this.chart = new ApexCharts(el, {
                    chart: {
                        type: 'donut',
                        height: 320,
                        fontFamily: 'Inter, sans-serif',
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 900
                        },
                        toolbar: {
                            show: false
                        },
                    },
                    series: this.chartData.series,
                    labels: this.chartData.labels,
                    colors: [
                        '#3B82F6', // Blue
                        '#6366F1', // Indigo
                        '#0EA5E9', // Sky
                        '#10B981', // Emerald
                        '#F59E0B' // Amber
                    ],
                    legend: {
                        show: true,
                        position: 'bottom',
                        horizontalAlign: 'center',
                        fontSize: '13px',
                        markers: {
                            width: 12,
                            height: 12,
                            radius: 12
                        },
                        itemMargin: {
                            horizontal: 12,
                            vertical: 4
                        },
                        labels: {
                            colors: document.documentElement.classList.contains('dark') ? '#E5E7EB' : '#4B5563',
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        style: {
                            fontSize: '12px',
                            fontWeight: 600,
                            colors: ['#ffffff']
                        },
                        formatter: function(val, opts) {
                            const label = opts.w.globals.labels[opts.seriesIndex];
                            const value = opts.w.globals.series[opts.seriesIndex];
                            return value + '\n(' + Math.round(val) + '%)';
                        },
                        dropShadow: {
                            enabled: true,
                            color: '#000000',
                            blur: 1,
                            opacity: 0.5
                        }
                    },
                    tooltip: {
                        enabled: true,
                        fillSeriesColor: false,
                        style: {
                            fontSize: '14px',
                            fontWeight: 500
                        },
                        y: {
                            formatter: (value, {
                                seriesIndex,
                                w
                            }) => {
                                const label = w.globals.labels[seriesIndex];
                                const total = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                const percent = ((value / total) * 100).toFixed(1);
                                return `${label}: ${value} tickets (${percent}%)`;
                            }
                        },
                        theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light'
                    },
                    plotOptions: {
                        pie: {
                            expandOnClick: true,
                            donut: {
                                size: '75%',
                                labels: {
                                    show: true,
                                    name: {
                                        show: true,
                                        fontSize: '14px',
                                        fontWeight: 500,
                                        color: document.documentElement.classList.contains('dark') ? '#D1D5DB' :
                                            '#6B7280',
                                        offsetY: -10
                                    },
                                    value: {
                                        show: true,
                                        fontSize: '24px',
                                        fontWeight: 700,
                                        color: document.documentElement.classList.contains('dark') ? '#F9FAFB' :
                                            '#1F2937',
                                        offsetY: 10,
                                        formatter: (val) => val + ' tickets'
                                    },
                                    total: {
                                        show: false
                                    }
                                }
                            }
                        }
                    },
                    stroke: {
                        colors: [document.documentElement.classList.contains('dark') ? '#111827' : '#FFFFFF'],
                        width: 3
                    }
                });

                this.chart.render();

                this.$watch('chartData', (newData) => {
                    this.chart.updateOptions({
                        labels: newData.labels,
                        series: newData.series
                    });
                });
            }
        }
    }
</script>
