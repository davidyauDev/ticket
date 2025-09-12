<div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 dark:bg-slate-900 dark:border-gray-700">

    <!-- Encabezado -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-bold text-gray-800 dark:text-gray-100">
            Distribución de Tickets por Encargado
        </h2>
    </div>

    <!-- Gráfico -->
    <div x-data="graficoTicketsAreaMesa(@entangle('chartData'))" x-init="initChart()" wire:ignore>
        <div id="grafico-tickets-area-mesa" class="w-full min-h-[400px]"></div>
    </div>

</div>

<script>
    function graficoTicketsAreaMesa(chartData) {
        return {
            chart: null,
            chartData,

            initChart() {
                const el = document.querySelector('#grafico-tickets-area-mesa');

                this.chart = new ApexCharts(el, {
                    chart: {
                        type: 'bar',
                        stacked: true,
                        height: this.chartData.categories.length * 70, // más alto por fila
                        toolbar: { show: false },
                        background: 'transparent'
                    },
                    plotOptions: {
                        bar: {
                            horizontal: true,
                            borderRadius: 6,
                            barHeight: '40%',
                            dataLabels: {
                                position: 'center'
                            }
                        }
                    },
                    series: this.chartData.series,
                    xaxis: {
                        categories: this.chartData.categories,
                        labels: {
                            style: {
                                colors: '#475569', // más suave que #334155
                                fontSize: '13px',
                                fontWeight: 500
                            }
                        },
                        axisTicks: { show: false },
                        axisBorder: { show: false }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: '#475569',
                                fontSize: '13px',
                                fontWeight: 600
                            }
                        }
                    },
                    colors: ['#22c55e', '#f59e0b', '#ef4444'], // tonos más modernos
                    grid: {
                        borderColor: '#e2e8f0',
                        strokeDashArray: 4,
                        xaxis: { lines: { show: false } }
                    },
                    dataLabels: {
                        enabled: true,
                        style: {
                            colors: ['#fff'], // etiquetas blancas
                            fontSize: '12px',
                            fontWeight: 'bold'
                        },
                        dropShadow: {
                            enabled: true,
                            top: 1,
                            left: 1,
                            blur: 2,
                            color: '#000',
                            opacity: 0.4
                        }
                    },
                    legend: {
                        position: 'top',
                        horizontalAlign: 'center',
                        fontSize: '13px',
                        fontWeight: 600,
                        markers: {
                            radius: 6
                        },
                        labels: {
                            colors: '#334155'
                        }
                    },
                    tooltip: {
                        theme: 'light',
                        style: {
                            fontSize: '13px'
                        },
                        y: {
                            formatter: function (val) {
                                return val + " tickets"
                            }
                        }
                    },
                    noData: {
                        text: "No hay datos disponibles",
                        align: 'center',
                        verticalAlign: 'middle',
                        style: {
                            color: '#94a3b8',
                            fontSize: '14px',
                            fontWeight: 500
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
