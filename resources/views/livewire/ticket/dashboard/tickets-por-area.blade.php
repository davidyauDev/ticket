<div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100 dark:bg-white/[0.03] dark:border-gray-800">

    <!-- Encabezado -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Distribución de Tickets en Ingeniería por
            Subárea</h2>
    </div>

    <!-- Gráfico -->
    <div x-data="graficoTicketsArea(@entangle('chartData'))" x-init="initChart()" wire:ignore>
        <div id="grafico-tickets-area" class="w-full min-h-[400px]"></div>
    </div>

</div>

<script>
    function graficoTicketsArea(chartData) {
        return {
            chart: null,
            chartData,

            initChart() {
                const el = document.querySelector('#grafico-tickets-area');

                this.chart = new ApexCharts(el, {
    chart: {
        type: 'bar',
        stacked: true, // Activar modo apilado
        height: this.chartData.categories.length * 60,
        toolbar: { show: false }
    },
    plotOptions: {
        bar: {
            horizontal: true,
            borderRadius: 8,
            barHeight: '45%',
        }
    },
    series: this.chartData.series,
    xaxis: {
        categories: this.chartData.categories,
        labels: {
            style: {
                colors: '#334155',
                fontSize: '14px',
                fontWeight: 500,
                whiteSpace: 'normal'
            }
        }
    },
    yaxis: {
        labels: {
            style: {
                colors: '#334155',
                fontSize: '14px',
                fontWeight: 500
            }
        }
    },
    colors: ['#10b981', '#f59e0b', '#ef4444'],
    grid: {
        borderColor: '#e2e8f0'
    },
    dataLabels: {
        enabled: true,
        style: {
            colors: ['#000']
        }
    },
    legend: {
        position: 'top',
        horizontalAlign: 'center',
        fontSize: '14px',
        labels: {
            colors: '#334155'
        }
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
                    this.chart.updateSeries(newData.series);
                    this.chart.updateOptions({
                        xaxis: { categories: newData.categories }
                    });
                });
            }
        }
    }
</script>