<div class="p-6 space-y-8 max-w-8xl mx-auto">

    {{-- ENCABEZADO --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Dashboard de Tickets</h1>
            <p class="text-sm text-gray-500">Resumen de actividad y métricas de rendimiento</p>
        </div>

        <div class="flex gap-2 mt-2 md:mt-0">
            {{-- Botón Actualizar --}}
            <button
                class="px-4 py-2 bg-gray-100 border rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-200 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-refresh-ccw-icon lucide-refresh-ccw">
                    <path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                    <path d="M3 3v5h5" />
                    <path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16" />
                    <path d="M16 16h5v5" />
                </svg>
                Actualizar
            </button>

            {{-- Botón Exportar --}}
            <button
                class="px-4 py-2 bg-white border rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-download-icon lucide-download">
                    <path d="M12 15V3" />
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    <path d="m7 10 5 5 5-5" />
                </svg>
                Exportar
            </button>
        </div>
    </div>

    {{-- CARDS DE MÉTRICAS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow p-5 flex justify-between items-center">
            <div>
                <p class="text-sm text-gray-500">Total Tickets</p>
                <h2 class="text-2xl font-bold ">{{ $totalTickets }}</h2>
                <p class="text-xs text-green-600 mt-1">+12%</p>
            </div>
            <div class="bg-blue-100 text-blue-600 p-2 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-circle-equal-icon lucide-circle-equal">
                    <path d="M7 10h10" />
                    <path d="M7 14h10" />
                    <circle cx="12" cy="12" r="10" />
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-5 flex justify-between items-center">
            <div>
                <p class="text-sm text-gray-500">Tickets Cerrados</p>
                <h2 class="text-2xl font-bold ">{{ $cerrados }}</h2>
                <p class="text-xs text-green-600 mt-1">+8%</p>
            </div>
            <div class="bg-green-100 text-green-600 p-2 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-circle-check-big-icon lucide-circle-check-big">
                    <path d="M21.801 10A10 10 0 1 1 17 3.335" />
                    <path d="m9 11 3 3L22 4" />
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-5 flex justify-between items-center">
            <div>
                <p class="text-sm text-gray-500">Tiempo Promedio</p>
                <h2 class="text-2xl font-bold ">{{ $tiempoPromedio }}</h2>
                <p class="text-xs text-gray-400 mt-1">--</p>
            </div>
            <div class="bg-indigo-100 text-indigo-600 p-2 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-clock-icon lucide-clock">
                    <circle cx="12" cy="12" r="10" />
                    <polyline points="12 6 12 12 16 14" />
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-5 flex justify-between items-center">
            <div>
                <p class="text-sm text-gray-500">% Cerrados</p>
                <h2 class="text-2xl font-bold ">{{ $porcentajeCerrados }}%</h2>
                <p class="text-xs text-green-600 mt-1">+5.2%</p>
            </div>
            <div class="bg-purple-100 text-purple-600 p-2 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-chart-line-icon lucide-chart-line">
                    <path d="M3 3v16a2 2 0 0 0 2 2h16" />
                    <path d="m19 9-5 5-4-4-3 3" />
                </svg>
            </div>
        </div>
    </div>

    {{-- FILTROS DE FECHA --}}
    <div class="flex flex-wrap items-center gap-4">
        <span class="text-sm font-medium text-gray-700">📅 Filtros de Fecha:</span>
        <div class="flex items-center gap-2">
            <label class="text-sm text-gray-600">Desde:</label>
            <input type="date" wire:model.live="fechaInicio"
                class="border border-gray-300 rounded px-3 py-1.5 shadow-sm">
        </div>
        <div class="flex items-center gap-2">
            <label class="text-sm text-gray-600">Hasta:</label>
            <input type="date" wire:model.live="fechaFin" class="border border-gray-300 rounded px-3 py-1.5 shadow-sm">
        </div>
    </div>

    {{-- GRAFICOS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Gráfico de estados --}}
        <div x-data="graficoTickets(@entangle('datosGrafico'))" x-init="initChart()"
            class="bg-white p-6 rounded-xl shadow border border-gray-100" wire:ignore>
            <h2 class="text-base font-semibold text-gray-700 mb-4">Resumen de Estados de Ticket</h2>
            <div id="grafico-tickets" class="w-full h-64"></div>
        </div>

        {{-- Gráfico por área --}}
        <div x-data="graficoPorArea(@js(array_values($ticketsPorArea)), @js(array_keys($ticketsPorArea)))"
            x-init="initChart()" class="bg-white p-6 rounded-xl shadow border border-gray-100" wire:ignore>
            <h2 class="text-base font-semibold text-gray-700 mb-4">Tickets por Área</h2>
            <div id="grafico-area" class="w-full h-[500px]"></div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function graficoTickets(data) {
        return {
            datos: data,
            chart: null,
            initChart() {
                const el = document.querySelector('#grafico-tickets');

                this.chart = new ApexCharts(el, {
                    chart: {
                        type: 'bar',
                        height: 300,
                        toolbar: { show: false }
                    },
                    series: [{
                        name: 'Tickets',
                        data: this.datos,
                    }],
                    xaxis: {
                        categories: ['Pendientes', 'Cerrados', 'Derivados'],
                    },
                    colors: ['#3b82f6'], // Azul de Tailwind
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

                this.$watch('datos', (nuevoValor) => {
                    this.chart.destroy();
                    this.chart = new ApexCharts(el, {
                        chart: {
                            type: 'bar',
                            height: 300,
                            toolbar: { show: false }
                        },
                        series: [{
                            name: 'Tickets',
                            data: nuevoValor,
                        }],
                        xaxis: {
                            categories: ['Pendientes', 'Cerrados', 'Derivados'],
                        },
                        colors: ['#3b82f6'],
                        noData: {
                            text: "No hay datos",
                            style: { color: '#64748b' }
                        }
                    });

                    this.chart.render();
                });
            }
        }
    }
</script>

<script>
    function graficoPorArea(data, labels) {
        return {
            initChart() {
                const chart = new ApexCharts(document.querySelector('#grafico-area'), {
                    chart: {
                        type: 'bar',
                        height: 500,
                        toolbar: { show: false }
                    },
                    series: [{
                        name: 'Tickets',
                        data: data,
                    }],
                    xaxis: {
                        categories: labels,
                    },
                    plotOptions: {
                        bar: {
                            horizontal: true,
                            borderRadius: 4,
                            barHeight: '70%',
                        }
                    },
                    colors: ['#10b981'], // Tailwind green
                    dataLabels: {
                        enabled: true
                    },
                    noData: {
                        text: "No hay datos",
                        style: { color: '#64748b' }
                    }
                });

                chart.render();
            }
        }
    }
</script>

@endpush