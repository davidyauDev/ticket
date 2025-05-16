<x-layouts.app :title="__('Dashboard')">
     <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
                
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <!-- Tickets por mes -->
        <div class="bg-white p-4 rounded-2xl shadow" x-data x-init="
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
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        ">
            <p class="font-semibold mb-2">Tickets por Mes</p>
            <canvas x-ref="monthChart" class="w-full h-64"></canvas>
        </div>

        <!-- Tickets por Estado -->
        <div class="bg-white p-4 rounded-2xl shadow" x-data x-init="
            new Chart($refs.statusChart, {
                type: 'pie',
                data: {
                    labels: ['Abierto', 'Pendientes', 'En Progreso', 'Resueltos'],
                    datasets: [{
                        data: [26, 7, 12, 55],
                        backgroundColor: ['#F97316', '#FACC15', '#3B82F6', '#10B981']
                    }]
                }
            });
        ">
            <p class="font-semibold mb-2">Tickets por Estado</p>
            <canvas x-ref="statusChart" class="w-full h-64"></canvas>
        </div>
    </div>
        </div>
    </div>
    
    <div class="p-6 space-y-6">
    <!-- Tarjetas resumen -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-sm text-gray-500">Total Tickets</p>
            <h2 class="text-2xl font-bold">1,248</h2>
            <p class="text-green-500 text-xs">+12.5% desde el mes pasado</p>
        </div>
        <div class="bg-white p-4 rounded-2xl shadow">
            <p class="text-sm text-gray-500">Tickets Abiertos</p>
            <h2 class="text-2xl font-bold">324</h2>
            <p class="text-red-500 text-xs">-4% desde el mes pasado</p>
        </div>
        <div class="bg-white p-4 rounded-2xl shadow">
            <p class="text-sm text-gray-500">Tiempo de Respuesta</p>
            <h2 class="text-2xl font-bold">2.4h</h2>
            <p class="text-red-500 text-xs">-18% desde el mes pasado</p>
        </div>
        <div class="bg-white p-4 rounded-2xl shadow">
            <p class="text-sm text-gray-500">Tiempo de Resolución</p>
            <h2 class="text-2xl font-bold">18.5h</h2>
            <p class="text-red-500 text-xs">-7% desde el mes pasado</p>
        </div>
    </div> 

    <!-- Gráficos -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <!-- Tickets por mes -->
        <div class="bg-white p-4 rounded-2xl shadow" x-data x-init="
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
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        ">
            <p class="font-semibold mb-2">Tickets por Mes</p>
            <canvas x-ref="monthChart" class="w-full h-64"></canvas>
        </div>

        <!-- Tickets por Estado -->
        <div class="bg-white p-4 rounded-2xl shadow" x-data x-init="
            new Chart($refs.statusChart, {
                type: 'pie',
                data: {
                    labels: ['Abierto', 'Pendientes', 'En Progreso', 'Resueltos'],
                    datasets: [{
                        data: [26, 7, 12, 55],
                        backgroundColor: ['#F97316', '#FACC15', '#3B82F6', '#10B981']
                    }]
                }
            });
        ">
            <p class="font-semibold mb-2">Tickets por Estado</p>
            <canvas x-ref="statusChart" class="w-full h-64"></canvas>
        </div>
    </div>
    <!-- Tickets por Departamento y Tickets Recientes -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <!-- Tickets por Departamento -->
        <div class="bg-white p-4 rounded-3xl shadow" x-data x-init="
            new Chart($refs.deptChart, {
                type: 'pie',
                data: {
                    labels: ['Sistemas y TI', 'Finanzas', 'Ingeniería', 'Operaciones', 'RRHH', 'Soporte'],
                    datasets: [{
                        data: [25, 10, 16, 19, 7, 22],
                        backgroundColor: ['#3B82F6', '#10B981', '#8B5CF6', '#F97316', '#F43F5E', '#EAB308']
                    }]
                }
            });
        ">
            <p class="font-semibold mb-2">Tickets por Departamento</p>
            <canvas x-ref="deptChart" class="w-full h-64"></canvas>
        </div>
        <!-- Tickets Recientes -->
        <div class="bg-white p-4 rounded-2xl shadow space-y-4">
            <p class="font-semibold mb-2">Tickets Recientes</p>
            <ul class="space-y-3 text-sm">
                <li class="flex justify-between items-center">
                    <span>📌 Problemas de red - Finanzas</span>
                    <span class="bg-red-500 text-white px-2 rounded-full text-xs">Abierto</span>
                </li>
                <li class="flex justify-between items-center">
                    <span>🖨 Impresora RRHH</span>
                    <span class="bg-gray-800 text-white px-2 rounded-full text-xs">En Progreso</span>
                </li>
                <li class="flex justify-between items-center">
                    <span>🛠 Instalación software</span>
                    <span class="bg-yellow-400 text-white px-2 rounded-full text-xs">Pendiente</span>
                </li>
                <li class="flex justify-between items-center">
                    <span>📧 Configuración correo</span>
                    <span class="bg-green-500 text-white px-2 rounded-full text-xs">Resuelto</span>
                </li>
                <li class="flex justify-between items-center">
                    <span>🔐 VPN remoto</span>
                    <span class="bg-red-500 text-white px-2 rounded-full text-xs">Abierto</span>
                </li>
            </ul>
        </div>
    </div>
</div>


</x-layouts.app>
