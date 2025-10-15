<div
    class="bg-white dark:bg-gray-900/70 border border-gray-200 dark:border-gray-800 rounded-3xl p-4 shadow-sm hover:shadow-lg transition-all duration-300 ease-in-out">

    <!-- ENCABEZADO -->
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
            <div
                class="w-9 h-9 flex items-center justify-center rounded-full bg-gradient-to-r from-blue-500 to-indigo-500 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 3v18h18M7 13h2v5H7m4-8h2v8h-2m4-11h2v11h-2" />
                </svg>
            </div>
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white tracking-tight">
                Tickets por Tipo de Soporte
            </h2>
        </div>

        <!-- Filtro de mes -->
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

    <!-- GRÁFICO -->
    <div x-data="graficoSoporte(@entangle('chartData'))" x-init="initChart()" wire:ignore>
        <div id="grafico-soporte" class="w-full h-[320px]"></div>
    </div>

    <!-- FOOTER -->
    <div class="flex justify-end mt-4">
        <p class="text-xs text-gray-500 dark:text-gray-400 italic">
            Actualizado al {{ now()->format('d/m/Y H:i') }}
        </p>
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
                        height: '100%',
                        toolbar: { show: false },
                        fontFamily: 'Inter, sans-serif',
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 700,
                        },
                    },
                    plotOptions: {
                        bar: {
                            horizontal: true,
                            borderRadius: 8,
                            barHeight: '55%',
                            distributed: true,
                        },
                    },
                    series: [{ name: 'Tickets', data: this.chartData.series }],
                    colors: ['#2563eb', '#4f46e5', '#0284c7', '#06b6d4', '#0ea5e9', '#60a5fa'],
                    xaxis: {
                        categories: this.chartData.categories,
                        labels: {
                            style: {
                                colors: '#475569',
                                fontSize: '13px',
                                fontWeight: 500,
                            },
                        },
                        axisBorder: { show: false },
                        axisTicks: { show: false },
                    },
                    yaxis: {
                        labels: {
                            align: 'left',
                            style: {
                                colors: '#475569',
                                fontSize: '13px',
                                fontWeight: 500,
                                whiteSpace: 'normal',
                            },
                        },
                    },
                    grid: {
                        borderColor: '#f1f5f9',
                        strokeDashArray: 3,
                        xaxis: { lines: { show: true } },
                        yaxis: { lines: { show: false } },
                        padding: { left: 15, right: 15 },
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: (val) => val,
                        style: {
                            fontSize: '13px',
                            fontWeight: '600',
                            colors: ['#1e293b'],
                        },
                        background: { enabled: false },
                        offsetX: 10,
                    },
                    tooltip: {
                        theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light',
                        style: { fontSize: '13px', fontWeight: 500 },
                        y: {
                            formatter: (val) => `${val} ticket${val === 1 ? '' : 's'}`,
                        },
                    },
                    // 🔹 Se quitan completamente las leyendas
                    legend: {
                        show: false,
                    },
                    noData: {
                        text: "No hay datos disponibles",
                        align: 'center',
                        verticalAlign: 'middle',
                        style: {
                            color: '#94a3b8',
                            fontSize: '14px',
                            fontWeight: 500,
                        },
                    },
                });

                this.chart.render();

                this.$watch('chartData', (newData) => {
                    this.chart.updateSeries([{ data: newData.series }]);
                    this.chart.updateOptions({
                        xaxis: { categories: newData.categories },
                    });
                });
            },
        };
    }
</script>
