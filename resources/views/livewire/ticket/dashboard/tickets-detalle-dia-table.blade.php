<div
    class="bg-white dark:bg-gray-900/70 border border-gray-200 dark:border-gray-800 rounded-3xl p-6 shadow-sm hover:shadow-lg transition-all duration-300 ease-in-out">

    <!-- 🔹 ENCABEZADO -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white tracking-tight flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12h6m-6 4h6m2 6H7a2 2 0 01-2-2V4a2 2 0 012-2h8l6 6v14a2 2 0 01-2 2z" />
            </svg>
            Detalle de Tickets del Día
        </h2>

        <!-- 🔸 FILTROS -->
        <div class="flex flex-wrap items-center gap-3">
            <input type="date"
                class="border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/60 text-sm text-gray-700 dark:text-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-400 transition-all duration-200" />

            <select
                class="border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/60 text-sm text-gray-700 dark:text-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-400 transition-all duration-200">
                <option value="all">Todos los estados</option>
                <option value="resuelto">Resuelto</option>
                <option value="derivado">Derivado</option>
                <option value="pendiente">Pendiente</option>
            </select>

            <select
                class="border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/60 text-sm text-gray-700 dark:text-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-400 transition-all duration-200">
                <option value="all">Todos los técnicos</option>
                <option value="luis">Luis Vargas</option>
                <option value="carla">Carla Pérez</option>
                <option value="jose">José Rivas</option>
            </select>
        </div>
    </div>

    <!-- 🔹 TABLA -->
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-800/50 text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-700">
                    <th class="px-4 py-3 font-medium">Ticket ID</th>
                    <th class="px-4 py-3 font-medium">Cliente</th>
                    <th class="px-4 py-3 font-medium">Técnico</th>
                    <th class="px-4 py-3 font-medium">Estado</th>
                    <th class="px-4 py-3 font-medium">Derivado</th>
                    <th class="px-4 py-3 font-medium">Tiempo Resolución</th>
                    <th class="px-4 py-3 font-medium">Fecha</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @php
                    $tickets = [
                        ['id' => 'TK-1001', 'cliente' => 'Banco Andino', 'tecnico' => 'Luis Vargas', 'estado' => 'Resuelto', 'derivado' => 'No', 'tiempo' => '35 min', 'fecha' => '2025-10-15'],
                        ['id' => 'TK-1002', 'cliente' => 'Agencia Lima Norte', 'tecnico' => 'Carla Pérez', 'estado' => 'Derivado', 'derivado' => 'Sí', 'tiempo' => '–', 'fecha' => '2025-10-15'],
                        ['id' => 'TK-1003', 'cliente' => 'Clínica SaludVida', 'tecnico' => 'José Rivas', 'estado' => 'Pendiente', 'derivado' => 'No', 'tiempo' => '–', 'fecha' => '2025-10-15'],
                        ['id' => 'TK-1004', 'cliente' => 'Agencia Sur', 'tecnico' => 'Luis Vargas', 'estado' => 'Resuelto', 'derivado' => 'Sí', 'tiempo' => '50 min', 'fecha' => '2025-10-15'],
                        ['id' => 'TK-1005', 'cliente' => 'Banco Universal', 'tecnico' => 'Carla Pérez', 'estado' => 'Resuelto', 'derivado' => 'No', 'tiempo' => '41 min', 'fecha' => '2025-10-15'],
                    ];
                @endphp

                @foreach ($tickets as $ticket)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-all duration-150">
                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-gray-100">{{ $ticket['id'] }}</td>
                        <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $ticket['cliente'] }}</td>
                        <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $ticket['tecnico'] }}</td>
                        <td class="px-4 py-3">
                            @php
                                $color = match ($ticket['estado']) {
                                    'Resuelto' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300',
                                    'Derivado' => 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-300',
                                    'Pendiente' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300',
                                };
                            @endphp
                            <span class="px-2 py-1 rounded-lg text-xs font-medium {{ $color }}">
                                {{ $ticket['estado'] }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $ticket['derivado'] }}</td>
                        <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $ticket['tiempo'] }}</td>
                        <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $ticket['fecha'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- 🔸 FOOTER -->
    <div class="flex justify-between items-center mt-4 text-xs text-gray-500 dark:text-gray-400">
        <p>Total de Tickets: {{ count($tickets) }}</p>
        <p>Última actualización: {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</div>
