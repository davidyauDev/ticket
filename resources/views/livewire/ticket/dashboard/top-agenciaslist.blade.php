<div
    class="rounded-3xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900/70 p-6 shadow-sm hover:shadow-md transition-all duration-300 ease-in-out">

    <!-- ENCABEZADO -->
    <div class="flex items-center justify-between mb-5">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white tracking-tight flex items-center gap-2">
            <span class="inline-block w-1.5 h-6 bg-gradient-to-b from-indigo-500 to-blue-400 rounded-full"></span>
            Agencias con mas tickets
        </h3>

        <!-- Selector de Mes -->
        <div
            class="relative flex items-center rounded-xl border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/60 hover:border-blue-500 transition-all duration-200">
            <select wire:model.live="selectedMonth"
                class="appearance-none bg-transparent px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-0 pr-8 cursor-pointer">
                <option value="0">Todos los meses</option>
                @for ($month = 1; $month <= 12; $month++)
                    <option value="{{ $month }}">
                        {{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>
            <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-2 w-4 h-4 text-gray-400 pointer-events-none"
                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6" />
            </svg>
        </div>
    </div>

    <!-- SEPARADOR -->
    <div class="border-t border-gray-200 dark:border-gray-800 mb-5"></div>

    <!-- GRÁFICO DONUT -->
    <div x-data="graficoTopAgencias(@entangle('chartData'))" x-init="initChart()" class="my-4" wire:ignore>
        <div id="grafico-top-agencias" class="w-full h-[320px]"></div>
    </div>

    <!-- FOOTER -->
    <div class="flex justify-end mt-5">
        <p class="text-xs text-gray-500 dark:text-gray-400 italic">
            Actualizado al {{ now()->format('d/m/Y H:i') }}
        </p>
    </div>
</div>

<script>
    function graficoTopAgencias(chartData) {
        return {
            chart: null,
            chartData,
            initChart() {
                const el = document.querySelector('#grafico-top-agencias');
                this.chart = new ApexCharts(el, {
                    chart: {
                        type: 'donut',
                        height: 320,
                        fontFamily: 'Inter, sans-serif',
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 1200
                        },
                        toolbar: {
                            show: false
                        },
                    },
                    series: this.chartData.series,
                    labels: this.chartData.labels,
                    colors: ['#3b82f6', '#6366f1', '#0ea5e9', '#10b981', '#f59e0b'],
                    legend: {
                        show: true,
                        position: 'bottom',
                        fontSize: '13px',
                        markers: {
                            width: 12,
                            height: 12,
                            radius: 6
                        },
                        itemMargin: {
                            horizontal: 10,
                            vertical: 3
                        },
                        labels: {
                            colors: document.documentElement.classList.contains('dark') ? '#d1d5db' : '#374151'
                        },
                    },
                    tooltip: {
                        enabled: true,
                        followCursor: true,
                        style: {
                            fontSize: '13px',
                            fontFamily: 'Inter, sans-serif',
                        },
                        y: {
                            formatter: (val) => `${val} tickets`
                        },
                        theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light',
                    },
                    dataLabels: {
                        enabled: false, // 🔹 Eliminamos el texto flotante para mejorar claridad
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '75%',
                                labels: {
                                    show: true,
                                    name: {
                                        show: true,
                                        offsetY: 16,
                                        fontSize: '14px',
                                        fontWeight: 500,
                                        color: document.documentElement.classList.contains('dark') ? '#e2e8f0' :
                                            '#475569'
                                    },
                                    value: {
                                        show: true,
                                        fontSize: '26px',
                                        fontWeight: 800,
                                        offsetY: -10,
                                        color: document.documentElement.classList.contains('dark') ? '#f8fafc' :
                                            '#1e293b',
                                        formatter: (val) => val
                                    },
                                    total: {
                                        show: false
                                    }
                                }
                            }
                        }
                    },
                    stroke: {
                        width: 4,
                        colors: [document.documentElement.classList.contains('dark') ? '#111827' : '#ffffff']
                    },
                    states: {
                        hover: {
                            filter: {
                                type: 'lighten',
                                value: 0.1
                            }
                        }
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
