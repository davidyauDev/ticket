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

            <h1 class="text-xl font-bold text-gray-900">Ticket {{ $ticket->codigo ?? $ticket->codigo_formateado }}</h1>
            @php
            $estadoNombre = strtolower($ticket->estado->nombre ?? 'sin estado');
            $estiloEstado = match ($estadoNombre) {
            'pendiente' => 'bg-blue-100 text-blue-700',
            'cerrado' => 'bg-red-100 text-red-700',
            'proceso' => 'bg-indigo-100 text-indigo-700',
            'derivado' => 'bg-yellow-100 text-yellow-700',
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
            {{-- <div class="flex items-center gap-2">
                <span class="text-xs px-2 py-1 rounded-full bg-blue-50 text-blue-700 font-medium">Pendiente</span>
                <span class="text-xs px-2 py-1 rounded-full border text-gray-700">En Proceso</span>
                <span class="text-xs px-2 py-1 rounded-full border text-gray-700">Cerrado</span>
                <span class="text-xs px-2 py-1 rounded-full border text-gray-700">Anulado</span>
            </div> --}}
            <!-- Fechas -->
            <div class="flex flex-wrap items-center gap-6 text-sm text-gray-600">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="#000000" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-calendar-icon lucide-calendar">
                        <path d="M8 2v4" />
                        <path d="M16 2v4" />
                        <rect width="18" height="18" x="3" y="4" rx="2" />
                        <path d="M3 10h18" />
                    </svg>
                    <span class="font-medium text-gray-700">Inicio:</span>
                    <span>{{ $this->fechaInicio?->format('d/m/Y H:i') ?? 'N/A' }}</span>
                </div>

                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="#000000" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-clock-icon lucide-clock">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                    </svg>
                    <span>{{ $this->fechaCierre?->format('d/m/Y H:i') ?? 'No cerrado' }}</span>
                </div>

                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="#000000" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-clock2-icon lucide-clock-2">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 10" />
                    </svg>
                    <span class="font-medium text-gray-700">Total:</span>
                    <span>{{ $this->getTiempoTotalProperty() }}</span>
                </div>
            </div>

        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
        <div class="md:col-span-8 space-y-6">
            <div class="rounded-xl border bg-white shadow-sm">
                <!--  Detalle ticket-->
                <!-- Encabezado Detalle-->
                @php
                $estadoNombre = strtolower($ticket->estado->nombre ?? 'sin estado');
                $estiloEncabezado = match ($estadoNombre) {
                'pendiente' => 'bg-blue-50 text-blue-800',
                'cerrado' => 'bg-red-50 text-red-800',
                'proceso' => 'bg-indigo-50 text-indigo-800',
                'derivado' => 'bg-yellow-50 text-yellow-800',
                'anulado' => 'bg-red-50 text-red-800',
                default => 'bg-gray-50 text-gray-800',
                };
                @endphp
                <div class="px-6 py-4 border-b  flex items-center gap-2 rounded-t-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h2 class="text-base font-semibold">Detalles del Ticket</h2>
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
                        <textarea rows="4" readonly
                            class="w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2 text-gray-800 text-sm">{{ $ticket->comentario ?? 'No hay comentarios' }}</textarea>
                    </div>
                    <div>
                        <label class="block text-gray-500 font-medium mb-1">Observación Inicial</label>
                        <input readonly type="text"
                            value="{{ $ticket->observacion->descripcion ?? ($ticket->observacion_consulta ?? 'No hay observaciones') }}"
                            class="w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2 text-gray-800 text-sm" />
                    </div>
                </div>

                @if ($ticket->estado_id == 5)
                <div class="px-6 pb-6">
                    <div
                        class="rounded-md bg-red-50 border border-red-200 p-4 mt-4 text-sm text-red-700 flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01M12 5.5a6.5 6.5 0 11-6.5 6.5A6.5 6.5 0 0112 5.5z" />
                        </svg>
                        <span>Este ticket ha sido cerrado y no puede ser modificado.</span>
                    </div>
                </div>
                @elseif (!$this->puedeActualizar)
                <div class="px-6 pb-6">
                    <div
                        class="rounded-md bg-gray-50 border border-gray-200 p-4 mt-4 text-sm text-gray-700 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01M12 5.5a6.5 6.5 0 11-6.5 6.5A6.5 6.5 0 0112 5.5z" />
                        </svg>
                        <span>No puedes actualizar este ticket porque no está asignado a ti.</span>
                    </div>
                </div>
                @endif
            </div>
            <!--  Form ticket-->
            @if ($ticket->estado_id != 5 && $this->puedeActualizar && !$this->estaPausado)
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
                            <flux:select wire:model.live="estado_id" class="text-sm" placeholder="Estado">
                                @foreach ($estados as $estado)
                                <flux:select.option value="{{ $estado->id }}">{{ $estado->nombre }}
                                </flux:select.option>
                                @endforeach
                            </flux:select>
                        </div>
                        @if ($estado_id == 2)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Área</label>
                                <flux:select wire:model.live="selectedArea" class="text-sm" placeholder="Área">
                                    @foreach ($areas as $area)
                                    <flux:select.option value="{{ $area['id'] }}">{{ $area['nombre'] }}
                                    </flux:select.option>
                                    @endforeach
                                </flux:select>
                                @error('selectedArea')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Subárea</label>
                                <flux:select wire:model.live="selectedSubarea" class="text-sm" placeholder="Subárea">
                                    @foreach ($subareas as $sub)
                                    <flux:select.option value="{{ $sub['id'] }}">{{ $sub['nombre'] }}
                                    </flux:select.option>
                                    @endforeach
                                </flux:select>
                                @error('selectedSubarea')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        @endif
                    </div>

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
                        @error('archivo')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                        <div wire:loading wire:target="archivo" class="text-sm text-gray-500 mt-1">Subiendo
                            archivo...
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

                    @endif
                </div>
            </div>
            @endif
            @if ($ticket->estado_id == 6 && $this->puedeActualizar)
            <div class="px-6 pb-6">
                <div
                    class="rounded-md bg-green-50 border border-green-200 p-4 mt-4 text-sm text-green-800 flex items-center justify-between gap-2">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01M12 5.5a6.5 6.5 0 11-6.5 6.5A6.5 6.5 0 0112 5.5z" />
                        </svg>
                        <span>Este ticket está pausado. Puedes reanudarlo para
                            continuar.</span>
                    </div>
                    <button wire:click="reanudarTicket"
                        class="text-sm px-4 py-1.5 bg-blue-500 hover:bg-blue-700 text-white rounded-md">
                        Reanudar Ticket
                    </button>
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
                    <input type="text" wire:model.live="searchComentario"
                        class="w-full text-sm pl-8 pr-3 py-2 bg-white border border-gray-300 rounded-md focus:ring-0 focus:outline-none placeholder:text-gray-400"
                        placeholder="Buscar comentarios...">
                </div>
            </div>
            <!-- Lista de historial -->
            <div class="px-6 pb-4 space-y-6 overflow-y-auto max-h-170">
                @forelse($historiales as $item)
                {{$item->accion}}
                @php
                $accion = strtolower($item->accion ?? 'evento');

                $icono = match($accion) {
                'creado' => 'clock',
                'derivado' => 'arrow-path',
                'cerrado' => 'lock',
                'pausado' => 'pause',
                default => 'document'
                };

                $iconoSVGs = [
                'clock' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="#2b7fff" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-clock-icon lucide-clock">
                    <circle cx="12" cy="12" r="10" />
                    <polyline points="12 6 12 12 16 14" />
                </svg>',

                'arrow-path' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="#f0b100" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-forward-icon lucide-forward">
                    <path d="m15 17 5-5-5-5" />
                    <path d="M4 18v-2a4 4 0 0 1 4-4h12" />
                </svg>',

                'lock' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="#fb2c36" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-check-icon lucide-check">
                    <path d="M20 6 9 17l-5-5" />
                </svg>',

                'document' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="#ccd0d7" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-file-plus2-icon lucide-file-plus-2">
                    <path d="M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v4" />
                    <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                    <path d="M3 15h6" />
                    <path d="M6 12v6" />
                </svg>',
                'pause' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="#37d75f" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-pause-icon lucide-pause">
                    <rect x="14" y="4" width="4" height="16" rx="1" />
                    <rect x="6" y="4" width="4" height="16" rx="1" />
                </svg>'
                ];
                @endphp
                <div class="space-y-1 text-sm text-gray-700 border-t pt-4">
                    <!-- Encabezado de acción -->
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-2">
                            {!! $iconoSVGs[$icono] !!}
                            <div>
                                <div class="font-medium text-gray-900">{{ $item->accion ?? 'Evento' }}</div>
                                @if ($item->estado)
                                @php
                                $estadoNombre = strtolower($item->estado->nombre ?? 'sin estado');
                                $estiloEstado = match ($estadoNombre) {
                                'pendiente' => 'bg-blue-100 text-blue-700',
                                'cerrado' => 'bg-red-100 text-red-700',
                                'proceso' => 'bg-indigo-100 text-indigo-700',
                                'derivado' => 'bg-yellow-100 text-yellow-700',
                                'anulado' => 'bg-red-100 text-red-700',
                                default => 'bg-gray-100 text-gray-700',
                                };
                                @endphp
                                <span
                                    class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-0.5 rounded-full {{ $estiloEstado }} border border-opacity-30 shadow-sm">
                                    {{ ucfirst($estadoNombre) }}
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
                            <span class="inline-block text-gray-400 mr-1"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#121212"
                                    stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-user-icon lucide-user">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg></span>
                            <span class="text-gray-600">Por:</span>
                            <strong class="text-gray-900">{{ $item->usuario->name }}</strong>
                        </p>
                        @endif
                        @if ($item->asignadoA)
                        <p>
                            <span class="inline-block text-gray-400 mr-1"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#000000"
                                    stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-user-check-icon lucide-user-check">
                                    <path d="m16 11 2 2 4-4" />
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                    <circle cx="9" cy="7" r="4" />
                                </svg></span>
                            <span class="text-gray-600">Asignado a:</span>
                            <strong class="text-gray-900">{{ $item->asignadoA->name }}</strong>
                        </p>
                        @endif
                        @if ($item->toArea)
                        <div class="text-sm bg-gray-50 text-gray-800 px-4 py-1.5 rounded border border-gray-100 mt-1">
                            @php
                            $areaPadre = $item->toArea->parent_id
                            ? \App\Models\Area::find($item->toArea->parent_id)
                            : null;
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
                        <div x-data="{ verMas: false }">
                            <p class="text-xs text-gray-500 italic mt-1">
                                <template x-if="verMas">
                                    <span>{{ $item->comentario }}</span>
                                </template>
                                <template x-if="!verMas">
                                    <span>{{ Str::limit($item->comentario, 100) }}</span>
                                </template>
                                @if (strlen($item->comentario) > 100)
                                <a @click="verMas = !verMas" class="text-blue-500 font-medium cursor-pointer ml-1"
                                    x-text="verMas ? 'ver menos' : 'ver más'"></a>
                                @endif
                            </p>
                        </div>

                        @endif
                        @if ($item->archivos && $item->archivos->count())
                        <div class="mt-1 text-sm text-gray-700">
                            <strong class="block text-xs text-gray-500 mb-1">Archivos adjuntos:</strong>
                            <ul class="list-disc pl-5 text-sm text-blue-600 space-y-1">
                                @foreach($item->archivos as $archivo)
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