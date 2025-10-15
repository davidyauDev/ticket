<div
    class="bg-white dark:bg-gray-900/70 border border-gray-200 dark:border-gray-800 rounded-3xl p-5  shadow-sm hover:shadow-lg transition-all duration-300 ease-in-out">

    <!-- ENCABEZADO -->
    <div class="flex items-center justify-between mb-4 ">
        <div class="flex items-center gap-3">
            <div
                class="w-9 h-9 flex items-center justify-center rounded-full bg-gradient-to-r from-blue-500 to-indigo-500 text-white shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12l2 2 4-4m-7 8h8a2 2 0 002-2V6a2 2 0 00-2-2H9a2 2 0 00-2 2v12z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white tracking-tight">
                Tickets Cerrados
            </h3>
        </div>

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
            <svg xmlns="http://www.w3.org/2000/svg"
                class="absolute right-2 w-4 h-4 text-gray-400 pointer-events-none" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6" />
            </svg>
        </div>
    </div>

    <!-- SEPARADOR -->
    <div class="border-t border-gray-200 dark:border-gray-800 mb-5"></div>

    <!-- GRÁFICO DONUT -->
    <div x-data="graficoDonut(@entangle('chartData'))" x-init="initChart()" class="my-4" wire:ignore>
        <div id="grafico-donut" class="w-full h-[270px]"></div>
    </div>

    <!-- FOOTER -->
    <div class="flex justify-end mt-14">
        <p class="text-xs text-gray-500 dark:text-gray-400 italic">
            Actualizado al {{ now()->format('d/m/Y H:i') }}
        </p>
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
                        height: 270,
                        fontFamily: 'Inter, sans-serif',
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 900
                        },
                    },
                    series: this.chartData.series,
                    labels: this.chartData.labels,
                    colors: ['#2563eb', '#6366f1', '#0ea5e9'],
                    legend: {
                        show: true,
                        position: 'bottom',
                        fontSize: '13px',
                        fontWeight: 500,
                        horizontalAlign: 'center',
                        markers: {
                            width: 10,
                            height: 10,
                            radius: 3
                        },
                        itemMargin: { horizontal: 12, vertical: 5 },
                        labels: {
                            colors: document.documentElement.classList.contains('dark') ? '#cbd5e1' : '#475569'
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: (val) => (val > 0 ? `${val.toFixed(1)}%` : ''),
                        style: {
                            fontSize: '12px',
                            fontWeight: 600,
                            colors: [document.documentElement.classList.contains('dark') ? '#f8fafc' : '#0f172a']
                        },
                        dropShadow: { enabled: false }
                    },
                    tooltip: {
                        theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light',
                        y: {
                            formatter: (val) => `${val} ticket${val === 1 ? '' : 's'}`
                        }
                    },
                    plotOptions: {
                        pie: {
                            expandOnClick: true,
                            donut: {
                                size: '75%',
                                background: 'transparent',
                                labels: {
                                    show: true,
                                    name: {
                                        show: true,
                                        offsetY: 18,
                                        fontSize: '14px',
                                        fontWeight: 500,
                                        color: document.documentElement.classList.contains('dark') ? '#e2e8f0' : '#475569'
                                    },
                                    value: {
                                        show: true,
                                        fontSize: '28px',
                                        fontWeight: 800,
                                        color: document.documentElement.classList.contains('dark') ? '#f8fafc' : '#1e293b',
                                        offsetY: -10
                                    },
                                    total: {
                                        show: true,
                                        label: 'Total de tickets',
                                        fontSize: '12px',
                                        fontWeight: 500,
                                        color: document.documentElement.classList.contains('dark') ? '#cbd5e1' : '#64748b',
                                        formatter: (w) => w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                                    }
                                }
                            }
                        }
                    },
                    stroke: {
                        width: 5,
                        colors: ['#fff']
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shade: 'light',
                            type: 'horizontal',
                            shadeIntensity: 0.3,
                            gradientToColors: ['#3b82f6', '#818cf8', '#38bdf8'],
                            inverseColors: false,
                            opacityFrom: 0.95,
                            opacityTo: 1,
                            stops: [0, 100]
                        }
                    },
                    states: {
                        hover: { filter: { type: 'lighten', value: 0.05 } },
                        active: { filter: { type: 'none' } }
                    },
                    responsive: [{
                        breakpoint: 640,
                        options: {
                            chart: { height: 240 },
                            legend: { fontSize: '11px' }
                        }
                    }]
                });

                this.chart.render();

                this.$watch('chartData', (newData) => {
                    this.chart.updateSeries(newData.series);
                    this.chart.updateOptions({ labels: newData.labels });
                });
            }
        }
    }
</script>
