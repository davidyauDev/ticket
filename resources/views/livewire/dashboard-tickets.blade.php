<div class="p-6 space-y-6">
    <div class="flex gap-4">
        <input type="date" wire:model.live="fechaInicio" class="border rounded px-3 py-1.5">
        <input type="date" wire:model.live="fechaFin" class="border rounded px-3 py-1.5">
    </div>

   <div x-data="graficoTickets(@entangle('datosGrafico'))"
     x-init="initChart()"
     class="mt-6 bg-white p-4 rounded shadow"
     wire:ignore> 
    <div id="grafico-tickets" class="w-full h-64"></div>
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
                },
                series: [{
                    name: 'Tickets',
                    data: this.datos,
                }],
                xaxis: {
                    categories: ['Pendientes', 'Cerrados', 'Derivados'],
                },
                noData: {
                    text: "No hay datos",
                }
            });

            this.chart.render();

            this.$watch('datos', (nuevoValor) => {
                // 🔥 Solución garantizada: destruir y volver a crear el gráfico
                this.chart.destroy();

                this.chart = new ApexCharts(el, {
                    chart: {
                        type: 'bar',
                        height: 300,
                    },
                    series: [{
                        name: 'Tickets',
                        data: nuevoValor,
                    }],
                    xaxis: {
                        categories: ['Pendientes', 'Cerrados', 'Derivados'],
                    },
                    noData: {
                        text: "No hay datos",
                    }
                });

                this.chart.render();
            });
        }
    }
}

</script>
@endpush