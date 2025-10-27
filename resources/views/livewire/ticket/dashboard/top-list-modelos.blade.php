<div>
    <div
        class="rounded-3xl border border-gray-200 bg-white p-6 shadow-md hover:shadow-lg dark:border-gray-700 dark:bg-gray-900/60 transition-all duration-300">

        <!-- Título y Filtro -->
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white tracking-tight">
                Modelos con más tickets
            </h3>

            <div class="flex items-center gap-3">
                <!-- Selector de Mes -->
                <select wire:model.live="selectedMonth"
                    class="border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-xl px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-150 shadow-sm hover:shadow-md">
                    <option value="0">Todos los meses</option>
                    @for ($month = 1; $month <= 12; $month++)
                        <option value="{{ $month }}">
                            {{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>
            </div>
        </div>

        <!-- Tabla de Modelos -->
        <div class="divide-y divide-gray-100 dark:divide-gray-800">
            <div class="flex justify-between pb-3 text-xs font-semibold uppercase text-gray-400 tracking-wider">
                <span>Modelos</span>
                <span>Total de tickets</span>
            </div>

            @forelse ($topModelos as $index => $modelo)
                @php
                    // Paleta visual moderna (coherente y armónica)
                    $palettes = [
                        'bg-blue-500',
                        'bg-sky-500',
                        'bg-indigo-500',
                        'bg-teal-500',
                        'bg-emerald-500',
                        'bg-fuchsia-500',
                    ];
                    $color = $palettes[$index % count($palettes)];
                @endphp

                <div wire:key="modelo-{{ $loop->index }}"
                    class="flex justify-between items-center py-3 px-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800/60 transition-all duration-200">
                    <div class="flex items-center gap-2">
                        <div class="w-2.5 h-2.5 rounded-full {{ $color }}"></div>
                        <span
                            class="text-gray-800 dark:text-gray-200 hover:text-blue-600 font-medium cursor-pointer transition-colors duration-200"
                            title="{{ $modelo['name'] }}">
                            {{ $modelo['name'] }}
                        </span>
                    </div>
                    <span class="text-gray-600 dark:text-gray-400 font-semibold">
                        {{ $modelo['total_tickets'] }}
                    </span>
                </div>
            @empty
                <p class="text-gray-500 text-sm dark:text-gray-400 py-3">No hay datos disponibles.</p>
            @endforelse
        </div>

        <!-- Botón de Reporte -->
        <a href="#" wire:click="showAllModelos"
            class="group flex justify-center items-center gap-2 mt-6 rounded-xl bg-gradient-to-r from-indigo-500 to-blue-500 hover:from-indigo-600 hover:to-blue-600 text-white font-medium py-2.5 shadow-md hover:shadow-lg transition-all duration-200 active:scale-95">
            Ver reporte completo
            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 20 20" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 5-7 5V5z" />
            </svg>
        </a>

        <!-- Modal -->
        <div>
            <x-modal wire:model="showModal" class="w-full max-w-6xl">
                <div class="bg-white dark:bg-gray-900 p-5 space-y-6">
                    <!-- Título -->
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                        Lista completa de modelos con tickets
                    </h2>

                    <!-- Listado Completo -->
                    <div class="max-h-[500px] overflow-y-auto space-y-3">
                        <!-- Total General -->
                        <div
                            class="flex items-center justify-between px-5 py-3 mt-4 mb-2 rounded-2xl bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-900 border border-blue-100 dark:border-gray-700 shadow-sm hover:shadow-md transition-all duration-300">

                            <div class="flex items-center gap-3">
                                <!-- Ícono -->
                                <div
                                    class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                                    </svg>
                                </div>

                                <!-- Texto -->
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-300 font-medium">
                                        @if ($selectedMonth > 0)
                                            Total de tickets del mes de
                                            <span class="font-semibold text-blue-600 dark:text-blue-400">
                                                {{ \Carbon\Carbon::create()->month($selectedMonth)->translatedFormat('F') }}
                                            </span>
                                        @else
                                            Total de tickets de todos los meses
                                        @endif
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 italic">
                                        Actualizado al {{ now()->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                            </div>

                            <!-- Valor numérico -->
                            <div class="text-right">
                                <p class="text-3xl font-extrabold text-blue-600 dark:text-blue-400 tracking-tight">
                                    {{ collect($allModelos)->sum('total_tickets') }}
                                </p>
                                <p class="text-xs uppercase text-gray-400 dark:text-gray-500 font-semibold">
                                    tickets
                                </p>
                            </div>
                        </div>

                        <!-- Lista de todos los modelos -->
                        <div class="space-y-2">
                            @forelse ($allModelos as $index => $modelo)
                                @php
                                    $palettes = [
                                        'bg-blue-500',
                                        'bg-sky-500',
                                        'bg-indigo-500',
                                        'bg-teal-500',
                                        'bg-emerald-500',
                                        'bg-fuchsia-500',
                                        'bg-orange-500',
                                        'bg-purple-500',
                                        'bg-pink-500',
                                        'bg-green-500',
                                    ];
                                    $bgColors = [
                                        'bg-blue-100 text-blue-700',
                                        'bg-sky-100 text-sky-700',
                                        'bg-indigo-100 text-indigo-700',
                                        'bg-teal-100 text-teal-700',
                                        'bg-emerald-100 text-emerald-700',
                                        'bg-fuchsia-100 text-fuchsia-700',
                                        'bg-orange-100 text-orange-700',
                                        'bg-purple-100 text-purple-700',
                                        'bg-pink-100 text-pink-700',
                                        'bg-green-100 text-green-700',
                                    ];
                                    $dotColor = $palettes[$index % count($palettes)];
                                    $bgColor = $bgColors[$index % count($bgColors)];
                                @endphp

                                <div wire:key="modal-modelo-{{ $index }}"
                                    class="flex items-center justify-between p-4 rounded-xl bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-750 transition-colors">
                                    <div class="flex items-center gap-4">
                                        <!-- Posición -->
                                        <div
                                            class="flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600">
                                            <span class="text-sm font-bold text-gray-700 dark:text-gray-200">
                                                {{ $index + 1 }}
                                            </span>
                                        </div>
                                        <!-- Indicador de color -->
                                        <div class="w-3 h-3 rounded-full {{ $dotColor }}"></div>
                                        <!-- Nombre del modelo -->
                                        <div class="flex-1">
                                            <span class="text-gray-800 dark:text-gray-200 font-medium text-lg"
                                                title="{{ $modelo['name'] }}">
                                                {{ $modelo['name'] }}
                                            </span>
                                        </div>
                                    </div>
                                    <!-- Cantidad de tickets -->
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="px-4 py-2 rounded-lg text-sm font-semibold {{ $bgColor }} dark:opacity-90">
                                            {{ $modelo['total_tickets'] }}
                                            ticket{{ $modelo['total_tickets'] != 1 ? 's' : '' }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No hay datos
                                        disponibles</h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        No se encontraron modelos para el período seleccionado.
                                    </p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Botón para cerrar -->
                    <div class="flex justify-end mt-6">
                        <button wire:click="closeModal"
                            class="mr-2 px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-100 rounded-lg transition-all duration-150">
                            Cerrar
                        </button>
                    </div>
                </div>
            </x-modal>
        </div>
    </div>
