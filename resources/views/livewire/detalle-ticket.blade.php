<div class="bg-white  rounded-xl  p-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div class="flex items-center space-x-3">
            <button onclick="window.location.href='{{ route('tickets.index') }}'"
                class="inline-flex items-center gap-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 border border-gray-300 px-3 py-1.5 rounded-lg transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path d="M15 19l-7-7 7-7" />
                </svg>
                Volver
            </button>
            <h1 class="text-2xl font-bold text-gray-800">Ticket {{ $ticket->codigo ?? $ticket->id }}</h1>
            @php
            $estadoNombre = strtolower($ticket->estado->nombre ?? 'sin estado');
            $estilos = match ($estadoNombre) {
    'pendiente' => 'bg-blue-100 text-blue-800 border border-blue-300',
    'cerrado' => 'bg-green-100 text-green-700 border border-green-300',
    'proceso' => 'bg-indigo-100 text-indigo-700 border border-indigo-300',
    'derivado' => 'bg-blue-100 text-blue-800 border border-blue-300',
    'anulado' => 'bg-red-100 text-red-800 border border-red-300',
    default => 'bg-gray-100 text-gray-800 border border-gray-300',
};
            @endphp
            <div class="inline-flex items-center rounded-full text-xs font-semibold px-3 py-1 {{ $estilos }}">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke-width="2" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2" />
                </svg>
                {{ ucfirst($estadoNombre) }}
            </div>
        </div>
        <!-- Leyenda de estados -->
        <div class="flex flex-wrap items-center gap-2 text-xs text-gray-600 mt-2">
            <span
                class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-blue-100 text-blue-800 border border-blue-300">
                <span class="w-2 h-2 rounded-full bg-blue-600"></span> Pendiente
            </span>
            <span
                class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-800 border border-indigo-300">
                <span class="w-2 h-2 rounded-full bg-indigo-500"></span> En Proceso
            </span>
            <span
                class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-green-100 text-green-700 border border-green-300">
                <span class="w-2 h-2 rounded-full bg-green-600"></span> Cerrado
            </span>
            <span
                class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-red-100 text-red-800 border border-red-300">
                <span class="w-2 h-2 rounded-full bg-red-600"></span> Anulado
            </span>
        </div>
        <div class="mt-4 md:mt-0 flex items-center gap-6 text-sm text-gray-600">
            <!-- Fechas -->
            <div class="space-y-1">
                <p>
                    <span class="font-semibold text-gray-800">📅 Inicio:</span>
                    {{ $this->fechaInicio?->format('d/m/Y H:i') ?? 'N/A' }}
                </p>
                <p>
                    <span class="font-semibold text-gray-800">🛑 Cierre:</span>
                    {{ $this->fechaCierre?->format('d/m/Y H:i') ?? 'No cerrado' }}
                </p>
            </div>
            <!-- Badge de duración -->
            @if ($this->tiempoTotal)
            <div
                class="flex items-center gap-2 text-xs px-4 py-1.5 rounded-full bg-purple-100 text-purple-800 border border-purple-300 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-purple-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Cerrado en {{ $this->tiempoTotal }}
            </div>
            @endif
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-6">
            <div class="rounded-xl border bg-white shadow-sm">
                <div class="p-6 border-b {{ $estilos }}">
                    <h3 class="text-xl font-semibold">Detalles del Ticket</h3>
                </div>
                <div class="p-6 pt-4 grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-700">
                    <div>
                        <p class="font-medium text-gray-500">Falla Reportada</p>
                        <p>{{ $ticket->falla_reportada ?? 'Sin información' }}</p>
                    </div>
                    <div>
                        <p class="font-medium text-gray-500">Tipo</p>
                        <span
                            class="inline-block rounded-full bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 mt-1">
                            {{ strtoupper($ticket->tipo ?? 'No especificado') }}
                        </span>
                    </div>
                    <div>
                        <p class="font-medium text-gray-500">Técnico</p>
                        <p>{{ $ticket->tecnico_nombres ?? 'Sin técnico asignado' }}</p>
                    </div>
                    <div>
                        <p class="font-medium text-gray-500">Agencia</p>
                        <p>{{ $ticket->agencia->nombre ?? 'Sin agencia' }}</p>
                    </div>
                    <div>
                        <p class="font-medium text-gray-500">Área Inicial</p>
                        <p>{{ $ticket->area->nombre ?? 'Sin Área' }}</p>
                    </div>
                    <div>
                        <p class="font-medium text-gray-500">Asignado a</p>
                        <p>{{ $ticket->assignedUser->name ?? 'No asignado' }}</p>
                    </div>
                    <div>
                        <p class="font-medium text-gray-500">Comentario Inicial</p>
                        <p class="mt-1 text-gray-600">{{ $ticket->comentario ?? 'No hay comentarios' }}</p>
                    </div>
                    <div>
                        <p class="font-medium text-gray-500">Observación Inicial</p>
                        <p class="mt-1 text-gray-600">{{ $ticket->observacion->descripcion ?? $ticket->observacion_consulta ?? 'No hay observaciones' }}</p>
                        </p>
                    </div>
                </div>
            </div>
            @if ($this->puedeActualizar && $ticket->estado_id != 5 && $ticket->estado_id != 4)
            <div>
                @if(!$this->estaPausado)
                    <div class="mt-4 flex items-center gap-2">
                    <input type="checkbox" id="reasignarAOrigen" wire:model.live="reasignarAOrigen"
                        class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                    <label for="reasignarAOrigen" class="text-sm text-gray-700">
                        Reasignar a <strong>{{ $ticket->asignadoPor->name ?? 'usuario anterior' }}</strong>
                    </label>
                </div>
                    <div class="mt-4">
                    @if (!$reasignarAOrigen)
                    <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                    <flux:select wire:model.live="estado_id" placeholder="Seleccionar estado">
                        @foreach ($estados as $estado)
                        <flux:select.option value="{{ $estado->id }}">{{ $estado->nombre }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    @endif
                </div>
                @if($estado_id == 2)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <!-- Área principal -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Área</label>
                        <flux:select wire:model.live="selectedArea" placeholder="Seleccione un área...">
                            @foreach($areas as $area)
                            <flux:select.option value="{{ $area['id'] }}">{{ $area['nombre'] }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        @error('selectedArea') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <!-- Subárea -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Subárea</label>
                        <flux:select wire:model.live="selectedSubarea" placeholder="Seleccione una subárea...">
                            @foreach($subareas as $sub)
                            <flux:select.option value="{{ $sub['id'] }}">{{ $sub['nombre'] }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        @error('selectedSubarea') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
                @endif
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Comentario</label>
                    <textarea wire:model="comentario"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Detalles adicionales..."></textarea>
                </div>
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Archivo adjunto</label>
                    <label for="archivo"
                        class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-lg cursor-pointer bg-gray-50 border-gray-300 hover:bg-gray-100 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400 mb-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828L18 9.828a4 4 0 10-5.656-5.656l-8.486 8.486a6 6 0 108.486 8.486l7.07-7.07" />
                        </svg>
                        <span class="text-sm text-gray-500 font-medium">Seleccionar archivo</span>
                        <span class="text-xs text-gray-400">
                            {{ $archivoNombre ?: 'Ningún archivo seleccionado' }}
                        </span>

                        <input id="archivo" type="file" wire:model="archivo" class="hidden" />
                    </label>
                    @error('archivo')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                    <div wire:loading wire:target="archivo" class="text-sm text-gray-500 mt-1">
                        Subiendo archivo...
                    </div>
                </div>
                @else
                {{-- Puedes dejar aquí un mensaje informativo si quieres --}}
                <p class="mt-4 text-sm text-gray-500">🛑 Este ticket está pausado. Puedes reanudarlo para continuar.</p>
                @endif
                {{-- Botón final según el estado --}}
                <div class="flex justify-end mt-4">
                    @if ($this->estaPausado)
                    <button wire:click="reanudarTicket"2
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg transition">
                        ▶️ Reanudar Ticket
                    </button>
                    @else
                    <button wire:click="ActualizarTicket" wire:loading.attr="disabled"
                        class="bg-black hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition">
                        Actualizar Ticket
                    </button>
                    @endif
                </div>
            </div>
            @endif
            @if (!$this->puedeActualizar)
            <p class="text-sm text-red-500 mt-2">No puedes actualizar este ticket porque no está asignado a ti.</p>
            @endif
        </div>
        <!-- Sección Historial del Ticket mejorado con acordeón y buscador -->
        <div class="rounded-xl border bg-white shadow-sm">
            <!-- Encabezado -->
            <div class="p-6 border-b flex items-center justify-between bg-gray-50">
                <h2 class="text-xl font-semibold text-gray-800">Historial del Ticket</h2>

                <div class="relative">
                    <svg class="absolute left-2 top-1/2 -translate-y-1/2 text-gray-400 w-4 h-4"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z" />
                    </svg>
                    <input type="text" wire:model="searchComentario"
                        class="text-sm pl-8 pr-3 py-1.5 bg-white border border-gray-300 rounded-md focus:ring-0 focus:outline-none placeholder:text-gray-400"
                        placeholder="Buscar comentarios...">
                </div>
            </div>
            <!-- Lista de historial como acordeón -->
            <div class="divide-y">
                @forelse($historiales as $index => $item)
                <div x-data="{ open: false, verMas: false }" class="p-6 hover:bg-gray-50 transition">
                    <!-- Título acordeón -->
                    <div class="flex items-center justify-between cursor-pointer" @click="open = !open">
                        <div class="flex items-center gap-2">
                            <svg :class="open ? 'rotate-90 text-gray-600' : 'text-gray-400'"
                                class="transition-transform duration-200 w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 18l6-6-6-6" />
                            </svg>
                            <div>
                                <div class="font-semibold text-gray-800">{{ $item->accion ?? 'Actualización' }}
                                </div>
                                <div class="text-xs text-gray-400">{{ $item->created_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                        </div>
                        @php
                        $estado = strtolower($item->estado->nombre ?? '');
                        $estilos = match ($estado) {
                        'pendiente' => 'bg-yellow-100 bg-blue-600',
                        'cerrado' => 'bg-green-100 text-green-700',
                        'proceso' => 'bg-indigo-100 text-indigo-700',
                        'derivado' => 'bg-blue-100 text-blue-800',
                        'anulado' => 'bg-red-100 text-red-800',
                        default => 'bg-gray-200 text-gray-800',
                        };
                        @endphp
                        <span class="inline-block text-xs font-medium px-2 py-0.5 rounded-full">
                            {{ $item->estado->nombre ?? 'Sin estado' }}
                        </span>
                    </div>
                    <!-- Contenido desplegable -->
                    <div x-show="open" x-collapse.transition.duration.300ms
                        class="mt-3 text-sm text-gray-700 space-y-2">
                        @if ($item->started_at && $item->ended_at)
                        @php
                        $duracion = \Carbon\Carbon::parse($item->started_at)->diffForHumans(
                        \Carbon\Carbon::parse($item->ended_at),
                        ['syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE, 'parts' => 2]
                        );
                        @endphp
                        <p><strong>⏱ Duración:</strong> {{ $duracion }}</p>
                        @endif

                        <div class="grid md:grid-cols-2 gap-4 text-sm">
                            <p><strong>👤 Por:</strong> {{ $item->usuario->name ?? 'N/A' }}</p>
                            @if ($item->from_area_id)
                            <p><strong>🏢 De área:</strong> {{ $item->fromArea->nombre }}</p>
                            @endif
                            @if ($item->to_area_id)
                            <p><strong>➡️ Hacia área:</strong> {{ $item->toArea->nombre }}</p>
                            @endif
                            @if ($item->asignado_a)
                            <p><strong>👨‍🔧 Asignado a:</strong> {{ $item->asignadoA->name }}</p>
                            @endif
                        </div>

                        @if ($item->comentario)
                        <div>
                            <p x-show="!verMas" class="italic text-gray-500">
                                "{{ \Illuminate\Support\Str::limit($item->comentario, 100) }}"
                                <button @click="verMas = true" class="text-blue-500 text-xs ml-1">Ver
                                    más</button>
                            </p>
                            <p x-show="verMas" class="italic text-gray-500">
                                "{{ $item->comentario }}"
                                <button @click="verMas = false" class="text-blue-500 text-xs ml-1">Ver
                                    menos</button>
                            </p>
                        </div>
                        @endif

                        @if ($item->archivos->isNotEmpty())
                        <div class="mt-2">
                            <div class="flex items-center gap-2 mb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-file">
                                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                                    <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                </svg>
                                <p class="text-sm font-semibold text-gray-600">Archivos adjuntos:</p>
                            </div>
                            <ul class="list-disc pl-5 text-sm text-blue-600 space-y-1">
                                @foreach ($item->archivos as $archivo)
                                <li>
                                    <a href="{{ asset('storage/' . $archivo->ruta) }}" target="_blank"
                                        class="hover:underline">
                                        {{ $archivo->nombre_original }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-500 p-6">No hay historial disponible para este ticket.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@script
<script>
    $wire.on("notifyActu", () => {
            Swal.fire({
                icon: 'success',
                title: 'Ticket',
                text: 'Ticket Actualizad exitosamente',
            });
        })
</script>
@endscript