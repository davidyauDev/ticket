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
                        d="M3 3v18h18M7 13l3 3 4-8 3 5h2" />
                </svg>
            </div>
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white tracking-tight">
                Tickets Ficticios por Día
            </h2>
        </div>

        <!-- Filtro de mes -->
        <div
            class="relative flex items-center rounded-xl border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/60 hover:border-blue-500 transition-all duration-200">
            <select
                class="appearance-none bg-transparent px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-0 pr-8 cursor-pointer">
                <option value="0">Todos los meses</option>
                <option value="10">Octubre</option>
                <option value="9">Septiembre</option>
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
    <div x-data="graficoFicticio(@entangle('chartData'))" x-init="initChart()" wire:ignore>
        <div id="grafico-ficticio" class="w-full h-[320px]"></div>
    </div>

    <!-- FOOTER -->
    <div class="flex justify-end mt-4">
        <p class="text-xs text-gray-500 dark:text-gray-400 italic">
            Actualizado al {{ now()->format('d/m/Y H:i') }}
        </p>
    </div>
</div>

<script>
    window.graficoFicticio = function (chartData) {
        return {
            chart: null,
            chartData,
            initChart() {
                const el = document.querySelector('#grafico-ficticio');
                this.chart = new ApexCharts(el, {
                    chart: {
                        type: 'area',
                        height: '100%',
                        fontFamily: 'Inter, sans-serif',
                        toolbar: { show: false },
                    },
                    series: [{
                        name: 'Tickets',
                        data: this.chartData.series ?? [10, 12, 9, 14, 8, 6, 11, 15, 9, 13],
                    }],
                    xaxis: {
                        categories: this.chartData.categories ?? ['01/10', '02/10', '03/10', '04/10', '05/10'],
                        labels: { style: { colors: '#475569', fontSize: '13px' } },
                    },
                    stroke: { curve: 'smooth', width: 3, colors: ['#2563eb'] },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shade: 'light',
                            type: 'vertical',
                            opacityFrom: 0.6,
                            opacityTo: 0.1,
                            stops: [0, 90, 100]
                        }
                    },
                    tooltip: {
                        y: { formatter: val => `${val} ticket${val === 1 ? '' : 's'}` }
                    },
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
