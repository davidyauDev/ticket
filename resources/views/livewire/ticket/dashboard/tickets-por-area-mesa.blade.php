<div
    class="rounded-3xl border border-gray-200 bg-white p-6 shadow-md hover:shadow-lg dark:border-gray-700 dark:bg-gray-900/60 transition-all duration-300">

    <!-- Título y Filtro -->
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white tracking-tight">
            Tickets Resueltos
        </h3>

        <select wire:model.live="selectedMonth"
            class="border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-150">
            <option value="0">Todos los meses</option>
            @for ($month = 1; $month <= 12; $month++)
                <option value="{{ $month }}">
                    {{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }}
                </option>
            @endfor
        </select>
    </div>

    <!-- Tabla de Técnicos -->
    <div class="divide-y divide-gray-100 dark:divide-gray-800">
        <div class="flex justify-between pb-3 text-xs font-semibold uppercase text-gray-400 tracking-wider">
            <span>Nombres</span>
            <span>Total de Tickets Resueltos</span>
        </div>

        @forelse ($topTechnicians as $technician)
            <div wire:key="tech-{{ $loop->index }}"
                class="flex justify-between items-center py-3 px-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800/60 transition-all duration-200">
                <div class="flex items-center gap-2">
                    <div class="w-2.5 h-2.5 rounded-full bg-blue-500"></div>
                    <span
                        class="text-gray-800 dark:text-gray-200 hover:text-blue-600 font-medium cursor-pointer transition-colors duration-200">
                        {{ $technician['name'] }}
                    </span>
                </div>
                <span class="text-gray-600 dark:text-gray-400 font-semibold">
                    {{ $technician['total_tickets'] }}
                </span>
            </div>
        @empty
            <p class="text-gray-500 text-sm dark:text-gray-400 py-3">No hay datos disponibles.</p>
        @endforelse
    </div>

    <!-- Botón de Reporte -->
    <a href="#" wire:click="showModal2"
        class="group flex justify-center items-center gap-2 mt-6 rounded-xl bg-gradient-to-r from-indigo-500 to-blue-500 hover:from-indigo-600 hover:to-blue-600 text-white font-medium py-2.5 shadow-md hover:shadow-lg transition-all duration-200 active:scale-95">
        Ver reporte completo
        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" xmlns="http://www.w3.org/2000/svg"
            fill="none" viewBox="0 0 20 20" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 5-7 5V5z" />
        </svg>
    </a>

    <!-- Modal -->
    <div>
        <x-modal wire:model="showModal" class="w-full max-w-6xl ">
            <div class="bg-white dark:bg-gray-900  p-5 space-y-6 " x-data="{ open: null }">
                <!-- Título -->
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                    Detalle de llamadas
                </h2>

                <!-- Listado Agrupado -->
                <div class="max-h-[500px] overflow-y-auto space-y-3" x-data="{ open: null }">
                    @forelse ($technicianCalls as $index => $data)
                        <div wire:key="detail-{{ $index }}" class="border rounded-lg dark:border-gray-700">
                            <!-- Cabecera -->
                            <button
                                @click="open === 'tech-{{ $index }}' ? open = null : open = 'tech-{{ $index }}'"
                                :aria-expanded="open === 'tech-{{ $index }}'"
                                aria-label="Ver llamadas de {{ $index }}"
                                class="w-full flex justify-between items-center px-4 py-3 text-left border-b transition-all duration-200 rounded-t-lg"
                                :class="open === 'tech-{{ $index }}'
                                    ?
                                    'bg-blue-600 text-white shadow-md border-blue-500' :
                                    'bg-white hover:bg-gray-100 text-gray-700 border-gray-200 dark:bg-gray-900 dark:hover:bg-gray-800 dark:text-gray-200 dark:border-gray-700'">
                                <div class="flex items-center gap-2">
                                    <!-- Flecha -->
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5 transition-transform duration-300 ease-in-out"
                                        :class="open === 'tech-{{ $index }}' ? 'rotate-90 text-white' :
                                            'rotate-0 text-blue-500 dark:text-blue-400'"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                    </svg>

                                    <span class="font-semibold text-base">
                                        {{ $index }}
                                    </span>
                                </div>

                                <span class="text-sm font-medium transition-colors duration-200"
                                    :class="open === 'tech-{{ $index }}' ? 'text-white' :
                                        'text-gray-500 dark:text-gray-400'">
                                    {{ $data['total'] }} llamadas
                                </span>
                            </button>

                            <!-- Contenido Desplegable -->
                            <div x-show="open === 'tech-{{ $index }}'" x-collapse x-transition.duration.300ms
                                class="border-t bg-gray-50 dark:bg-gray-800/30 px-4 py-3 rounded-b-lg space-y-2">

                                <div
                                    class="grid grid-cols-12 gap-2 px-3 py-2 bg-gray-100 dark:bg-gray-800/60 rounded-lg text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    <div class="col-span-2 text-left">Código</div>
                                    <div class="col-span-2 text-center">Fecha</div>
                                    <div class="col-span-2 text-center">Modelo</div>
                                    <div class="col-span-3 text-center">Tiempo de Solucion</div>
                                    <div class="col-span-2 text-left">Comentario</div>
                                </div>
                                @foreach ($data['calls'] as $call)
                                    <div
                                        class="grid grid-cols-12 items-center gap-4 p-3 bg-white dark:bg-gray-900/50 
               border border-gray-200 dark:border-gray-700 rounded-lg 
               hover:shadow-md transition-all duration-150">

                                        <!-- Código -->
                                        <div class="col-span-2 font-medium text-blue-600 hover:text-blue-700 truncate">
                                            <a href="{{ route('tickets.show', $call['id']) }}">
                                                TCK-{{ str_pad($call['id'], 7, '0', STR_PAD_LEFT) }}
                                            </a>
                                        </div>

                                        <!-- Fecha -->
                                        <div class="col-span-2 text-gray-500 text-sm whitespace-nowrap">
                                            {{ $call['date'] }}
                                        </div>

                                        <!-- Modelo -->
                                        <div
                                            class="col-span-2 text-gray-700 dark:text-gray-300 text-sm font-medium truncate text-center">
                                            {{ $call['modelo'] ?? 'Sin modelo' }}
                                        </div>

                                        <!-- Tiempo total -->
                                        <div
                                            class="col-span-2 text-gray-700 text-sm dark:text-gray-300 whitespace-nowrap font-medium text-center">
                                            {{ $call['tiempo_total'] }}
                                        </div>

                                        <!-- Comentario Expandible -->
                                        <div x-data="{ showFull: false }" @click="showFull = !showFull"
                                            class="col-span-4 text-gray-600 text-sm italic dark:text-gray-400 cursor-pointer leading-snug">
                                            <p x-show="!showFull" class="truncate">{{ $call['motivo'] }}</p>
                                            <p x-show="showFull" x-transition.duration.200ms.origin.top>
                                                {{ $call['motivo'] }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach




                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 text-sm">No hay llamadas registradas.</p>
                    @endforelse
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
