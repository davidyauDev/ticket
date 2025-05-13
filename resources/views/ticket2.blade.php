<x-layouts.app :title="__('Dashboard')">
    <div class="p-6 bg-white rounded-lg shadow">
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
</x-layouts.app>