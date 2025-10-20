<div
    class="bg-white dark:bg-gray-900/70 border border-gray-200 dark:border-gray-800 rounded-3xl p-6 shadow-sm hover:shadow-lg transition-all duration-300 ease-in-out">

    <!-- 🔹 ENCABEZADO -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
        <div class="flex items-center gap-4">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white tracking-tight flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h6m-6 4h6m2 6H7a2 2 0 01-2-2V4a2 2 0 012-2h8l6 6v14a2 2 0 01-2 2z" />
                </svg>
                Detalle de Tickets del Día
            </h2>

            @if ($totales['total'] > 0)
                @php
                    $porcentajeCompletado = round(($totales['cerrados'] / $totales['total']) * 100, 1);
                @endphp
                <div class="flex items-center gap-2">
                    <div class="w-16 h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-green-400 to-green-600 transition-all duration-300"
                            style="width: {{ $porcentajeCompletado }}%"></div>
                    </div>
                    <span class="text-sm font-medium text-gray-600 dark:text-gray-300">{{ $porcentajeCompletado }}%
                        completado</span>
                </div>
            @endif
        </div>

        <!-- 🔸 FILTRO DE FECHA -->
        <div class="flex items-center gap-2">
            <input id="datepicker" type="text" readonly wire:model.live="fecha"
                class="border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/60
               text-sm text-gray-700 dark:text-gray-200 rounded-full px-4 py-2
               focus:outline-none focus:ring-2 focus:ring-blue-500
               focus:border-blue-400 transition-all duration-200 cursor-pointer
               shadow-sm hover:shadow focus:ring-offset-1 w-36 text-center" />

            <span
                class="inline-block px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded-full">
                {{ \Carbon\Carbon::parse($fecha)->format('d M Y') }}
            </span>
        </div>

    </div>

    <!-- 🔹 TARJETAS DE TOTALES -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
        <!-- Total -->
        <div
            class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 border border-blue-200 dark:border-blue-700 rounded-xl p-4 text-center transition-all duration-200 hover:shadow-md">
            <div class="flex items-center justify-center mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-blue-700 dark:text-blue-300">{{ $totales['total'] }}</p>
            <p class="text-xs font-medium text-blue-600 dark:text-blue-400">Total</p>
        </div>

        <!-- Pendientes -->
        <div
            class="bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-800/20 border border-orange-200 dark:border-orange-700 rounded-xl p-4 text-center transition-all duration-200 hover:shadow-md">
            <div class="flex items-center justify-center mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-orange-600 dark:text-orange-400"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-orange-700 dark:text-orange-300">{{ $totales['pendientes'] }}</p>
            <p class="text-xs font-medium text-orange-600 dark:text-orange-400">Pendientes</p>
        </div>

        <!-- Derivados -->
        <div
            class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 border border-blue-200 dark:border-blue-700 rounded-xl p-4 text-center transition-all duration-200 hover:shadow-md">
            <div class="flex items-center justify-center mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-blue-700 dark:text-blue-300">{{ $totales['derivados'] }}</p>
            <p class="text-xs font-medium text-blue-600 dark:text-blue-400">Derivados</p>
        </div>

        <!-- Cerrados -->
        <div
            class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 border border-green-200 dark:border-green-700 rounded-xl p-4 text-center transition-all duration-200 hover:shadow-md">
            <div class="flex items-center justify-center mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600 dark:text-green-400"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-green-700 dark:text-green-300">{{ $totales['cerrados'] }}</p>
            <p class="text-xs font-medium text-green-600 dark:text-green-400">Cerrados</p>
        </div>

        <!-- Pausados -->
        <div
            class="bg-gradient-to-br from-yellow-50 to-yellow-100 dark:from-yellow-900/20 dark:to-yellow-800/20 border border-yellow-200 dark:border-yellow-700 rounded-xl p-4 text-center transition-all duration-200 hover:shadow-md">
            <div class="flex items-center justify-center mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-600 dark:text-yellow-400"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6l4-2-4-2z" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-yellow-700 dark:text-yellow-300">{{ $totales['pausados'] }}</p>
            <p class="text-xs font-medium text-yellow-600 dark:text-yellow-400">Pausados</p>
        </div>

        <!-- Anulados -->
        <div
            class="bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 border border-red-200 dark:border-red-700 rounded-xl p-4 text-center transition-all duration-200 hover:shadow-md">
            <div class="flex items-center justify-center mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-600 dark:text-red-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-red-700 dark:text-red-300">{{ $totales['anulados'] }}</p>
            <p class="text-xs font-medium text-red-600 dark:text-red-400">Anulados</p>
        </div>
    </div>

    <!-- 🔹 TABLA -->
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left border-collapse">
            <thead>
                <tr
                    class="bg-gray-100 dark:bg-gray-800/50 text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-700">
                    <th class="px-4 py-3 font-medium">#</th>
                    <th class="px-4 py-3 font-medium">Cliente</th>
                    <th class="px-4 py-3 font-medium">Modelo</th>
                    <th class="px-4 py-3 font-medium">Técnico</th>
                    <th class="px-4 py-3 font-medium">Estado</th>
                    <th class="px-4 py-3 font-medium">Fecha</th>
                    <th class="px-4 py-3 font-medium text-center">Historial</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach ($tickets as $ticket)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-all duration-150">
                        <td class="px-4 py-3">{{ $ticket->id }}</td>
                        <td class="px-4 py-3">{{ $ticket->agencia_nombre }}</td>
                        <td class="px-4 py-3">{{ $ticket->modelo_nombre }}</td>
                        <td class="px-4 py-3">{{ $ticket->tecnico_nombres }}</td>
                        <td class="px-4 py-3">
                            <span @class([
                                'inline-block px-2 py-1 text-xs font-semibold rounded-full',
                                'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' =>
                                    $ticket->estado_nombre === 'Cerrado',
                                'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' =>
                                    $ticket->estado_nombre === 'Pausado',
                                'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' =>
                                    $ticket->estado_nombre === 'Derivado',
                                'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' =>
                                    $ticket->estado_nombre === 'Anulado',
                                'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200' => !in_array(
                                    $ticket->estado_nombre,
                                    ['Cerrado', 'Pausado', 'Derivado', 'Anulado']),
                            ])>
                                {{ $ticket->estado_nombre }}
                            </span>

                        </td>

                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($ticket->created_at)->format('Y-m-d') }}</td>

                        <td class="px-4 py-3 text-center">
                            @if (($historiales[$ticket->id] ?? collect())->isNotEmpty())
                                <button wire:click="$toggle('showHistorial.{{ $ticket->id }}')"
                                    class="inline-flex items-center text-blue-500 hover:underline transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-4 h-4 mr-1 transform transition-transform duration-200 {{ !empty($showHistorial[$ticket->id]) ? 'rotate-90' : '' }}"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                    Ver historial
                                </button>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                    </tr>

                    @if (!empty($showHistorial[$ticket->id]))
                        <tr>
                            <td colspan="7"
                                class="p-4 bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-400 dark:border-blue-600 text-sm">
                                <ul class="space-y-2">
                                    @foreach ($historiales[$ticket->id] as $h)
                                        <li>
                                            <p class="font-medium text-blue-700 dark:text-blue-300">
                                                {{ $h->accion }}
                                            </p>
                                            <p class="text-gray-600 dark:text-gray-300">
                                                <span class="font-semibold">{{ $h->usuario_nombre ?? 'N/A' }}</span>
                                                ({{ $h->from_area ?? '-' }} → {{ $h->to_area ?? '-' }})
                                                | Estado: <span
                                                    class="text-gray-800 dark:text-gray-200">{{ $h->estado_nombre ?? '-' }}</span>
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ $h->started_at }} - {{ $h->ended_at ?? 'Actual' }}
                                            </p>
                                            @if ($h->comentario)
                                                <p class="italic text-gray-500 mt-1">"{{ $h->comentario }}"</p>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="flex justify-between items-center mt-4 text-xs text-gray-500 dark:text-gray-400">
        <p>📊 Tickets del {{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}:
            <strong>{{ $tickets->count() }}</strong></p>
        <p>🕒 Actualizado: {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</div>

<script>
    function initFlatpickr() {
        flatpickr("#datepicker", {
            dateFormat: "Y-m-d",
            defaultDate: @json($fecha), // Livewire binding
            onChange: function(selectedDates, dateStr, instance) {
                @this.set('fecha', dateStr);
            }
        });
    }


    document.addEventListener('livewire:load', function() {
        initFlatpickr();
        Livewire.hook('message.processed', () => {
            initFlatpickr();
        });
    });


    document.addEventListener('init-flatpickr', () => {
        initFlatpickr();
    });
</script>
