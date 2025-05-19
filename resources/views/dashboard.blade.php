<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern
                    class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />

            </div>
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern
                    class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern
                    class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
        </div>
        <div
            class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <!-- Tickets por mes -->
               <!-- Gráfico más pequeño y ancho completo -->
<div class="bg-white p-4 rounded-2xl shadow lg:col-span-2" x-data x-init="
    new Chart($refs.monthChart, {
        type: 'bar',
        data: {
            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            datasets: [
                {
                    label: 'Resueltos',
                    data: [100, 120, 130, 140, 160, 150, 130, 135, 125, 140, 150, 145],
                    backgroundColor: '#10B981'
                },
                {
                    label: 'Abiertos',
                    data: [50, 60, 55, 70, 80, 75, 65, 70, 60, 68, 72, 70],
                    backgroundColor: '#111827'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        boxWidth: 12,
                        font: { size: 12 }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        font: { size: 12 }
                    }
                },
                x: {
                    ticks: {
                        font: { size: 12 }
                    }
                }
            }
        }
    });
">
    <p class="font-semibold text-sm mb-2">📊 Tickets por Mes</p>
    <div class="relative h-[500px]">
        <canvas x-ref="monthChart" class="w-full h-full"></canvas>
    </div>
</div>

        </div>
    </div>
    </div>
</x-layouts.app>