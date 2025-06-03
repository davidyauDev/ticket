<div class="bg-white  rounded-xl  p-1">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <!-- Volver + título + estado principal -->
        <div class="flex items-center flex-wrap gap-3">
            <button onclick="window.location.href='{{ route('tickets.index') }}'"
                class="flex items-center text-sm text-gray-700 hover:underline">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1 text-gray-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M15 19l-7-7 7-7" />
                </svg>
                Volver
            </button>

            <h1 class="text-xl font-bold text-gray-900">Ticket  {{ $ticket->codigo ?? $ticket->codigo_formateado }}</h1>
            @php
            $estadoNombre = strtolower($ticket->estado->nombre ?? 'sin estado');
            $estiloEstado = match ($estadoNombre) {
            'pendiente' => 'bg-blue-100 text-blue-700',
            'cerrado' => 'bg-green-100 text-green-700',
            'proceso' => 'bg-indigo-100 text-indigo-700',
            'derivado' => 'bg-blue-100 text-blue-700',
            'anulado' => 'bg-red-100 text-red-700',
            default => 'bg-gray-100 text-gray-700',
            };
            @endphp
            <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $estiloEstado }}">
                {{ ucfirst($estadoNombre) }}
            </span>
        </div>
        <!-- Leyenda y fechas -->
        <div class="flex items-center flex-wrap gap-4 text-sm text-gray-700">
            <!-- Leyenda estados -->
            <div class="flex items-center gap-2">
                <span class="text-xs px-2 py-1 rounded-full bg-blue-50 text-blue-700 font-medium">Pendiente</span>
                <span class="text-xs px-2 py-1 rounded-full border text-gray-700">En Proceso</span>
                <span class="text-xs px-2 py-1 rounded-full border text-gray-700">Cerrado</span>
                <span class="text-xs px-2 py-1 rounded-full border text-gray-700">Anulado</span>
            </div>
            <!-- Fechas -->
            <div class="flex items-center gap-4 text-sm">
                <div class="flex items-center gap-1">
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10m-11 5h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v7a2 2 0 002 2z" />
                    </svg>
                    Inicio: {{ $this->fechaInicio?->format('d/m/Y H:i') ?? 'N/A' }}
                </div>
                <div class="flex items-center gap-1 text-red-600 font-medium">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Cierre: {{ $this->fechaCierre?->format('d/m/Y H:i') ?? 'No cerrado' }}
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
        <div class="md:col-span-8 space-y-6">
            <div class="rounded-xl border bg-white shadow-sm">
                <!--  Detalle ticket-->
                <!-- Encabezado Detalle-->
                <div class="px-6 py-4 border-b bg-blue-50 text-blue-800 flex items-center gap-2 rounded-t-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-base font-semibold">Detalles del Ticket</h3>
                </div>
                <!-- Cuerpo -->
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                    <div>
                        <label class="block text-gray-500 font-medium mb-1">Falla Reportada</label>
                        <input readonly type="text" value="{{ $ticket->falla_reportada ?? 'Sin información' }}"
                            class="w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2 text-gray-800 text-sm" />
                    </div>
                    <div>
                        <label class="block text-gray-500 font-medium mb-1">Tipo</label>
                        <span
                            class="inline-block rounded-full bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 mt-1">{{
                            strtoupper($ticket->tipo ?? 'No especificado') }}</span>
                    </div>
                    <div>
                        <label class="block text-gray-500 font-medium mb-1">Técnico</label>
                        <input readonly type="text" value="{{ $ticket->tecnico_nombres ?? 'Sin técnico asignado' }}"
                            class="w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2 text-gray-800 text-sm" />
                    </div>
                    <div>
                        <label class="block text-gray-500 font-medium mb-1">Agencia</label>
                        <input readonly type="text" value="{{ $ticket->agencia->nombre ?? 'Sin agencia' }}"
                            class="w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2 text-gray-800 text-sm" />
                    </div>
                    <div>
                        <label class="block text-gray-500 font-medium mb-1">Área Inicial</label>
                        <input readonly type="text" value="{{ $ticket->area->nombre ?? 'Sin Área' }}"
                            class="w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2 text-gray-800 text-sm" />
                    </div>
                    <div>
                        <label class="block text-gray-500 font-medium mb-1">Asignado a</label>
                        <input readonly type="text" value="{{ $ticket->assignedUser->name ?? 'No asignado' }}"
                            class="w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2 text-gray-800 text-sm" />
                    </div>
                    <div>
                        <label class="block text-gray-500 font-medium mb-1">Comentario Inicial</label>
                        <input readonly type="text" value="{{ $ticket->comentario ?? 'No hay comentarios' }}"
                            class="w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2 text-gray-800 text-sm" />
                    </div>
                    <div>
                        <label class="block text-gray-500 font-medium mb-1">Observación Inicial</label>
                        <input readonly type="text"
                            value="{{ $ticket->observacion->descripcion ?? ($ticket->observacion_consulta ?? 'No hay observaciones') }}"
                            class="w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2 text-gray-800 text-sm" />
                    </div>
                </div>

                @if ($ticket->estado_id == 5 )
                <div class="px-6 pb-6">
                    <div
                        class="rounded-md bg-red-50 border border-red-200 p-4 mt-4 text-sm text-red-700 flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01M12 5.5a6.5 6.5 0 11-6.5 6.5A6.5 6.5 0 0112 5.5z" />
                        </svg>
                        <span>Ticket Cerrado</span>
                    </div>
                </div>
                @elseif (!$this->puedeActualizar )
                <div class="px-6 pb-6">
                    <div
                        class="rounded-md bg-red-50 border border-red-200 p-4 mt-4 text-sm text-red-700 flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01M12 5.5a6.5 6.5 0 11-6.5 6.5A6.5 6.5 0 0112 5.5z" />
                        </svg>
                        <span>No puedes actualizar este ticket porque no está asignado a ti.</span>
                    </div>
                </div>
                @endif
            </div>
             <!--  Form ticket-->
            @if($ticket->estado_id != 5 && $this->puedeActualizar )
            <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
                <!-- Título -->
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16.862 4.487A4.5 4.5 0 019 19.5H6a2 2 0 01-2-2V7a2 2 0 012-2h7.5a4.5 4.5 0 013.362-.513z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-800">Actualizar Ticket</h3>
                </div>
               
                    <div class="p-6 space-y-6">
                    @if (!$this->estaPausado)
                    <!-- Estado y Subárea -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                                <flux:select wire:model.live="estado_id" placeholder="Seleccionar estado">
                                    @foreach ($estados as $estado)
                                    <flux:select.option value="{{ $estado->id }}">{{ $estado->nombre }}</flux:select.option>
                                    @endforeach
                                </flux:select>
                            </div>
                            @if ($estado_id == 2)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Subárea</label>
                                <flux:select wire:model.live="selectedSubarea" placeholder="Seleccione una subárea...">
                                    @foreach ($subareas as $sub)
                                    <flux:select.option value="{{ $sub['id'] }}">{{ $sub['nombre'] }}</flux:select.option>
                                    @endforeach
                                </flux:select>
                                @error('selectedSubarea') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>
                            @endif
                        </div>

                        @if ($estado_id == 2)
                        <!-- Área -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Área</label>
                            <flux:select wire:model.live="selectedArea" placeholder="Seleccione un área...">
                                @foreach ($areas as $area)
                                <flux:select.option value="{{ $area['id'] }}">{{ $area['nombre'] }}</flux:select.option>
                                @endforeach
                            </flux:select>
                            @error('selectedArea') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                        @endif

                    <!-- Comentario -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Comentario</label>
                            <textarea wire:model="comentario"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                rows="3" placeholder="Detalles adicionales..."></textarea>
                        </div>

                    <!-- Archivo -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Archivo adjunto</label>
                            <label for="archivo"
                                class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-gray-300 rounded-md bg-gray-50 hover:bg-gray-100 cursor-pointer transition text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400 mb-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828L18 9.828a4 4 0 10-5.656-5.656l-8.486 8.486a6 6 0 108.486 8.486l7.07-7.07" />
                                </svg>
                                <span class="text-sm text-blue-600 font-medium">Seleccionar archivo</span>
                                <span class="text-xs text-gray-400">
                                    {{ $archivoNombre ?: 'Ningún archivo seleccionado' }}
                                </span>
                                <input id="archivo" type="file" wire:model="archivo" class="hidden" />
                            </label>
                            @error('archivo') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
                            <div wire:loading wire:target="archivo" class="text-sm text-gray-500 mt-1">Subiendo archivo...
                            </div>
                        </div>

                    <!-- Botón -->
                        <div class="flex justify-end mt-4">
                            <button wire:click="ActualizarTicket" wire:loading.attr="disabled"
                                class="flex items-center gap-2 px-5 py-2 bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white text-sm font-medium rounded-lg transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Actualizar Ticket
                            </button>
                        </div>
                        @else
                        <p class="text-sm text-gray-500">🛑 Este ticket está pausado. Puedes reanudarlo para continuar.</p>
                        @endif
                </div>
               
            </div>
            @endif
        </div>
        <!-- Sección Historial del Ticket mejorado con acordeón y buscador -->
        <div class="md:col-span-4 rounded-xl border border-gray-200 bg-white shadow-sm">
            <!-- Encabezado -->
            <div class="px-6 py-4 border-b bg-gray-50 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h2 class="text-lg font-semibold text-gray-800">Historial del Ticket</h2>
            </div>

            <!-- Buscador -->
            <div class="px-6 py-4">
                <div class="relative">
                    <svg class="absolute left-2 top-1/2 -translate-y-1/2 text-gray-400 w-4 h-4"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z" />
                    </svg>
                    <input type="text" wire:model="searchComentario"
                        class="w-full text-sm pl-8 pr-3 py-2 bg-white border border-gray-300 rounded-md focus:ring-0 focus:outline-none placeholder:text-gray-400"
                        placeholder="Buscar comentarios...">
                </div>
            </div>

            <!-- Lista de historial -->
            <div class="px-6 pb-4 space-y-6">
                @forelse($historiales as $item)
                <div class="space-y-1 text-sm text-gray-700 border-t pt-4">
                    <!-- Encabezado de acción -->
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mt-1"></div>
                            <div>
                                <div class="font-medium text-gray-900">{{ $item->accion ?? 'Evento' }}</div>
                                @if ($item->estado)
                                <span
                                    class="inline-block mt-1 px-2 py-0.5 text-xs font-medium rounded-full bg-blue-100 text-blue-700">
                                    {{ $item->estado->nombre }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="text-xs text-gray-400">{{ $item->created_at->format('d/m/Y H:i') }}</div>
                    </div>

                    <!-- Detalles del historial -->
                    <div class="mt-2 space-y-1 text-sm">
                        @if ($item->usuario)
                        <p>
                            <span class="inline-block text-gray-400 mr-1">👤</span>
                            <span class="text-gray-600">Por:</span>
                            <strong class="text-gray-900">{{ $item->usuario->name }}</strong>
                        </p>
                        @endif
                        @if ($item->asignadoA)
                        <p>
                            <span class="inline-block text-gray-400 mr-1">👥</span>
                            <span class="text-gray-600">Asignado a:</span>
                            <strong class="text-gray-900">{{ $item->asignadoA->name }}</strong>
                        </p>
                        @endif
                       @if ($item->toArea)
    <div class="text-sm bg-gray-50 text-gray-800 px-4 py-1.5 rounded border border-gray-100 mt-1">
        @php
            $areaPadre = $item->toArea->parent_id ? \App\Models\Area::find($item->toArea->parent_id) : null;
        @endphp
        @if ($areaPadre)
            Área: <strong>{{ $areaPadre->nombre }}</strong><br>
            Subárea: <strong>{{ $item->toArea->nombre }}</strong>
        @else
            Área: <strong>{{ $item->toArea->nombre }}</strong>
        @endif
    </div>
@endif

                        @if ($item->comentario)
                        <p class="text-xs text-gray-500 italic mt-1">
                            {{ Str::limit($item->comentario, 100) }}
                            @if(strlen($item->comentario) > 100)
                            <a @click="verMas = true" class="text-blue-500 font-medium cursor-pointer ml-1">ver más</a>
                            @endif
                        </p>
                        @endif
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-500">No hay historial disponible para este ticket.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>
@script
<script>
    $wire.on("notifyActu", ({
            type,
            message
        }) => {
            Swal.fire({
                icon: type,
                title: 'Ticket',
                text: message,
            });
        });
</script>
@endscript