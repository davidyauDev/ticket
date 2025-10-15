<div
    class="bg-white dark:bg-gray-900/70 border border-gray-200 dark:border-gray-800 rounded-3xl p-6 shadow-sm hover:shadow-lg transition-all duration-300 ease-in-out">

    <!-- 🔹 ENCABEZADO -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <div
                class="w-9 h-9 flex items-center justify-center rounded-full bg-gradient-to-r from-blue-500 to-indigo-500 text-white shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 3v18h18M7 13l3 3 4-8 3 5h2" />
                </svg>
            </div>
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white tracking-tight">
                Actividad de Tickets – Por Día
            </h2>
        </div>

        <!-- 🔸 Filtro de fecha -->
        <div class="flex items-center gap-2">
            <input type="date"
                class="border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/60 text-sm text-gray-700 dark:text-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-400 transition-all duration-200" />
        </div>
    </div>

    <!-- 🔹 GRÁFICO PRINCIPAL -->
    <div x-data="graficoTicketsDia()" x-init="initChart()" wire:ignore>
        <div id="grafico-tickets-dia" class="w-full h-[340px]"></div>
    </div>

    <!-- 🔸 TARJETA EXTRA: TIEMPO PROMEDIO -->
    <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="p-4 rounded-xl bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700">
            <p class="text-sm text-gray-600 dark:text-gray-300">Total Tickets</p>
            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400 mt-1">32</p>
        </div>
        <div class="p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-700">
            <p class="text-sm text-gray-600 dark:text-gray-300">Tiempo Promedio</p>
            <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 mt-1">47 min</p>
        </div>
        <div class="p-4 rounded-xl bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-700">
            <p class="text-sm text-gray-600 dark:text-gray-300">Tickets Pendientes</p>
            <p class="text-2xl font-bold text-orange-600 dark:text-orange-400 mt-1">4</p>
        </div>
    </div>

    <!-- FOOTER -->
    <div class="flex justify-end mt-4">
        <p class="text-xs text-gray-500 dark:text-gray-400 italic">
            Datos ficticios generados el {{ now()->format('d/m/Y H:i') }}
        </p>
    </div>
</div>

<!-- ✅ SCRIPT -->
<script>
    window.graficoTicketsDia = function () {
        return {
            chart: null,
            initChart() {
                const el = document.querySelector('#grafico-tickets-dia');
                if (!el) return;

                this.chart = new ApexCharts(el, {
                    chart: {
                        type: 'bar',
                        height: 340,
                        fontFamily: 'Inter, sans-serif',
                        toolbar: { show: false },
                        animations: { enabled: true, easing: 'easeinout', speed: 800 },
                    },
                    plotOptions: {
                        bar: {
                            horizontal: true,
                            borderRadius: 6,
                            barHeight: '45%',
                        },
                    },
                    series: [{
                        name: 'Tickets',
                        data: [20, 6, 4] // Ficticio: Resueltos, Derivados, Pendientes
                    }],
                    colors: ['#3b82f6', '#f97316', '#ef4444'],
                    xaxis: {
                        categories: ['Resueltos', 'Derivados', 'Pendientes'],
                        labels: {
                            style: { colors: '#475569', fontSize: '13px', fontWeight: 500 },
                        },
                    },
                    dataLabels: {
                        enabled: true,
                        style: { fontSize: '13px', fontWeight: 600, colors: ['#1e293b'] },
                        formatter: val => `${val}`,
                    },
                    tooltip: {
                        theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light',
                        y: { formatter: val => `${val} ticket${val === 1 ? '' : 's'}` },
                    },
                    grid: {
                        borderColor: '#e2e8f0',
                        strokeDashArray: 4,
                    },
                    legend: { show: false },
                });

                this.chart.render();
            }
        }
    }
</script>
