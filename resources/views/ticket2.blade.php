<x-layouts.app :title="__('Dashboard')">
    {{-- <div class="p-6 bg-white rounded-lg shadow">
        <!-- Título -->
        <h2 class="text-xl font-bold mb-1">Sistema de Tickets</h2>
        <p class="text-sm text-gray-600 mb-4">Gestión de tickets y seguimiento de historial</p>
        <!-- Tabs con íconos -->
        <div class="flex space-x-2 mb-4">
            <button
                class="flex items-center px-4 py-1.5 text-sm font-medium bg-black text-white border border-black rounded-full">
                <!-- Icono -->
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Mis Tickets
            </button>
            <button
                class="flex items-center px-4 py-1.5 text-sm font-medium bg-white border border-gray-300 rounded-full text-gray-700 hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h4" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7h1a1 1 0 011 1v2h-4v1" />
                </svg>
                Todos los Tickets
            </button>
            <button
                class="flex items-center px-4 py-1.5 text-sm font-medium bg-white border border-gray-300 rounded-full text-gray-700 hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h11M9 21V3m-6 6h18" />
                </svg>
                Tickets de mi Área
            </button>
        </div>
        <!-- Búsqueda y acciones -->
        <div class="flex items-center justify-between mb-4">
            <input type="text" placeholder="Buscar ticket, usuario, área..."
                class="w-1/3 px-4 py-2 border rounded-lg text-sm">

            <div class="flex gap-2">
                <!-- Exportar -->
                <button
                    class="flex items-center px-4 py-2 border border-gray-300 text-sm text-gray-700 rounded-lg hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v16h16V4H4zm8 8V8m0 4l-4-4m4 4l4-4" />
                    </svg>
                    Exportar
                </button>
                <!-- Filtros -->
                <button
                    class="flex items-center px-4 py-2 border border-gray-300 text-sm text-gray-700 rounded-lg hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L15 14.414V19a1 1 0 01-.553.894l-4 2A1 1 0 019 21v-6.586L3.293 6.707A1 1 0 013 6V4z" />
                    </svg>
                    Filtros
                </button>
                <!-- Crear -->
                <button class="flex items-center px-4 py-2 bg-black text-white text-sm rounded-lg hover:bg-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Crear Nuevo Ticket
                </button>
            </div>
        </div>
        <!-- Tabla -->
        <div class="overflow-auto">
            <table class="w-full text-sm text-left border border-gray-200 rounded-lg">
                <thead class="bg-gray-50 text-gray-700">
                    <tr>
                        <th class="px-3 py-2">Código</th>
                        <th class="px-3 py-2">Falla Reportada</th>
                        <th class="px-3 py-2">Tipo</th>
                        <th class="px-3 py-2">Técnico</th>
                        <th class="px-3 py-2">Equipo</th>
                        <th class="px-3 py-2">Agencia</th>
                        <th class="px-3 py-2">Área</th>
                        <th class="px-3 py-2">Asignado a</th>
                        <th class="px-3 py-2">Creado por</th>
                        <th class="px-3 py-2">Estado</th>
                        <th class="px-3 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800 font-medium">
                    @foreach ([1,2,3] as $i)
                    <tr class="border-t">
                        <td class="px-3 p-4 text-blue-600 font-semibold hover:underline cursor-pointer">4547{{ $i }}
                        </td>
                        <td class="px-3 p-4">SEGUIMIENTO</td>
                        <td class="px-3 py-2">
                            <span
                                class="bg-green-100 text-green-800 px-2 py-0.5 rounded-full text-xs font-semibold">Consulta</span>
                        </td>
                        <td class="px-3 p-4">Omar Humberto Julian ...</td>
                        <td class="px-3 p-4">LAC17(6027917...)</td>
                        <td class="px-3 p-4">BCP-MIRAFLORES</td>
                        <td class="px-3 p-4">Sin Área</td>
                        <td class="px-3 p-4 text-blue-600 hover:underline cursor-pointer">Asignarme</td>
                        <td class="px-3 p-4">Rafael Luigi</td>
                        <td class="px-3 p-4">
                            <span
                                class="bg-red-100 text-red-800 px-2 py-0.5 rounded-full text-xs font-semibold">Cerrado</span>
                        </td>
                        <td class="px-3 py-2 text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 cursor-pointer" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    d="M6 10a2 2 0 11-4 0 2 2 0 014 0zm6-2a2 2 0 100 4 2 2 0 000-4zm4 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="p-6">
        <a href="#" class="text-blue-600 hover:underline">&larr; Volver</a>
        <h1 class="text-2xl font-bold inline-block ml-2">Ticket #45697</h1>
        <span class="bg-blue-100 text-blue-800 text-sm font-medium ml-2 px-2.5 py-0.5 rounded">Derivado</span>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
            <!-- Detalles del Ticket -->
            <div class="md:col-span-2 bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Detalles del Ticket</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="font-semibold">Falla Reportada</p>
                        <p>REQUIERE CAMBIO DE REPUESTOS</p>
                    </div>
                    <div>
                        <p class="font-semibold">Tipo</p>
                        <span
                            class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">consulta</span>
                    </div>
                    <div>
                        <p class="font-semibold mt-2">Técnico</p>
                        <p class="flex items-center gap-1">
                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M5.121 17.804A10 10 0 1 1 12 22v-2a8 8 0 1 0-6.879-3.196z" />
                            </svg>
                            Arcangel Miguel
                        </p>
                    </div>
                    <div>
                        <p class="font-semibold mt-2">Agencia</p>
                        <p class="flex items-center gap-1">
                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M3 10h18M4 21h16a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2z" />
                            </svg>
                            BCP-TARMA
                        </p>
                    </div>
                    <div>
                        <p class="font-semibold mt-2">Área</p>
                        <p>2</p>
                    </div>
                    <div>
                        <p class="font-semibold mt-2">Asignado a</p>
                        <p class="flex items-center gap-1">
                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M5.121 17.804A10 10 0 1 1 12 22v-2a8 8 0 1 0-6.879-3.196z" />
                            </svg>
                            Juan Ronaldo
                        </p>
                    </div>
                    <div>
                        <p class="font-semibold mt-2">Comentario</p>
                        <p>Test222</p>
                    </div>
                    <div>
                        <p class="font-semibold mt-2">Observación</p>
                        <p>Testasda</p>
                    </div>
                </div>

                <!-- Formulario de actualización -->
                <form action="#" method="POST" class="mt-6">
                    @csrf
                    <div class="mb-4">
                        <label for="estado" class="block text-sm font-medium">Estado</label>
                        <select id="estado" name="estado" class="mt-1 block w-full border border-gray-300 rounded p-2">
                            <option>Pendiente</option>
                            <option>En proceso</option>
                            <option>Finalizado</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="comentario" class="block text-sm font-medium">Comentario</label>
                        <textarea id="comentario" name="comentario" rows="3"
                            class="w-full border border-gray-300 rounded p-2"
                            placeholder="Detalles adicionales..."></textarea>
                    </div>

                    <div class="flex gap-4">
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Actualizar
                            Ticket</button>
                        <a href="#" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">Cancelar</a>
                    </div>
                </form>
            </div>

            <!-- Historial del Ticket -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Historial del Ticket</h2>
                <ol class="relative border-l-2 border-gray-200 ml-6 space-y-6">
                    <!-- Item -->
                    <li class="relative">
                        <!-- Punto azul centrado -->
                        <div
                            class="absolute -left-[1.0625rem] top-2 w-4 h-4 bg-blue-500 rounded-full shadow-md border-2 border-white z-10">
                        </div>

                        <div class="pl-6">
                            <h3 class="text-sm font-semibold">El usuario se asignó el ticket</h3>
                            <p class="text-xs text-gray-500">Estado: Derivado 14/05/2025 19:39</p>
                            <p class="text-xs text-gray-700">Por: Juan Ronaldo</p>
                            <p class="text-xs text-gray-700">De área: Tecnología</p>
                        </div>
                    </li>



                    <!-- Otro Item -->
                    <li class="relative">
                        <div
                            class="absolute -left-[1.0625rem] top-2 w-4 h-4 bg-blue-500 rounded-full shadow-md border-2 border-white z-10">
                        </div>

                        <div class="pl-6">
                            <h3 class="text-sm font-semibold">Creado y Derivado</h3>
                            <p class="text-xs text-gray-500">Estado: Derivado 14/05/2025 19:25</p>
                            <p class="text-xs text-gray-700">Por: Joel Ronald</p>
                            <p class="text-xs text-gray-700">Hacía área: Tecnología</p>
                            <p class="italic text-xs text-gray-600">"Ticket creado y derivado al área correspondiente."
                            </p>
                        </div>
                    </li>
                </ol>


            </div>
        </div>
    </div>

    <div>
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm" data-v0-t="card">
            <div class="flex flex-col space-y-1.5 p-6 pb-3">
                <div class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-clock h-5 w-5 text-muted-foreground">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    <h2 class="text-xl font-semibold">Historial del Ticket</h2>
                </div>
            </div>
            <div class="p-6 pt-0">
                <div class="space-y-4">
                    <div class="relative pb-4">
                        <div class="absolute left-3.5 top-5 -bottom-4 w-px bg-border"></div>
                        <div class="absolute left-0 flex items-center justify-center mt-1">
                            <div
                                class="h-7 w-7 rounded-full border-2 border-border bg-blue-100 flex items-center justify-center">
                                <div class="h-2.5 w-2.5 rounded-full bg-blue-600"></div>
                            </div>
                        </div>
                        <div class="ml-12">
                            <div class="flex items-start">
                                <div class="flex flex-col space-y-1"><span class="font-medium">El usuario se asignó el
                                        ticket</span>
                                    <div class="flex justify-between items-center"><span
                                            class="text-sm text-muted-foreground">Estado: Derivado</span><span
                                            class="text-xs text-muted-foreground">14/05/2025 19:39</span></div>
                                </div>
                            </div>
                            <div class="ml-6 mt-2 space-y-1">
                                <div class="text-sm"><span class="font-medium">Por:</span> Juan Ronaldo</div>
                                <div class="text-sm"><span class="font-medium">De área:</span> Tecnología</div>
                            </div>
                        </div>
                    </div>
                    <div class="relative pb-4">
                        <div class="absolute left-3.5 top-5 -bottom-4 w-px bg-border"></div>
                        <div class="absolute left-0 flex items-center justify-center mt-1">
                            <div
                                class="h-7 w-7 rounded-full border-2 border-border bg-blue-100 flex items-center justify-center">
                                <div class="h-2.5 w-2.5 rounded-full bg-blue-600"></div>
                            </div>
                        </div>
                        <div class="ml-12">
                            <div class="flex items-start">
                                <div class="flex flex-col space-y-1"><span class="font-medium">El usuario se asignó el
                                        ticket</span>
                                    <div class="flex justify-between items-center"><span
                                            class="text-sm text-muted-foreground">Estado: Derivado</span><span
                                            class="text-xs text-muted-foreground">14/05/2025 19:33</span></div>
                                </div>
                            </div>
                            <div class="ml-6 mt-2 space-y-1">
                                <div class="text-sm"><span class="font-medium">Por:</span> Juan Ronaldo</div>
                                <div class="text-sm"><span class="font-medium">De área:</span> Recursos Humanos</div>
                                <div class="text-sm"><span class="font-medium">Asignado a:</span> Juan Ronaldo</div>
                            </div>
                        </div>
                    </div>
                    <div class="relative pb-4">
                        <div class="absolute left-3.5 top-5 -bottom-4 w-px bg-border"></div>
                        <div class="absolute left-0 flex items-center justify-center mt-1">
                            <div
                                class="h-7 w-7 rounded-full border-2 border-border bg-blue-100 flex items-center justify-center">
                                <div class="h-2.5 w-2.5 rounded-full bg-blue-600"></div>
                            </div>
                        </div>
                        <div class="ml-12">
                            <div class="flex items-start">
                                <div class="flex flex-col space-y-1"><span class="font-medium">Creado y Derivado</span>
                                    <div class="flex justify-between items-center"><span
                                            class="text-sm text-muted-foreground">Estado: Derivado</span><span
                                            class="text-xs text-muted-foreground">14/05/2025 19:25</span></div>
                                </div>
                            </div>
                            <div class="ml-6 mt-2 space-y-1">
                                <div class="text-sm"><span class="font-medium">Por:</span> Joel Ronald</div>
                                <div class="text-sm"><span class="font-medium">Hacia área:</span> Tecnología</div>
                                <div class="text-sm italic text-muted-foreground">"Ticket creado y derivado al área
                                    correspondiente."</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

<div class="p-6 space-y-6">
    <!-- Tarjetas resumen -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-2xl shadow">
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