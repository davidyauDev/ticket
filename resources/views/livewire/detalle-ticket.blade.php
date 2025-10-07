<div class="rounded-xl  p-5">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <!-- Volver + título + estado principal -->
        <!-- Leyenda y fechas -->
        <div class="flex items-center flex-wrap gap-4 text-sm text-gray-700">
            <!-- Fechas -->
            <div class="flex bg-white flex-wrap items-center gap-6 text-sm text-gray-600 border-2 p-4 rounded-xl">
                <button onclick="window.location.href='{{ route('tickets.index') }}'"
                    class="flex items-center text-sm text-gray-700 hover:underline">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1 text-gray-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M15 19l-7-7 7-7" />
                    </svg>
                    Volver
                </button>

                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="#000000" stroke-width="0.75" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-calendar-icon lucide-calendar">
                        <path d="M8 2v4" />
                        <path d="M16 2v4" />
                        <rect width="18" height="18" x="3" y="4" rx="2" />
                        <path d="M3 10h18" />
                    </svg>
                    <span class="font-medium text-gray-700">Inicio:</span>
                    <span>{{ $this->fechaInicio?->format('d/m/Y H:i') ?? 'N/A' }}</span>
                </div>

                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="#000000" stroke-width="0.75" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-clock-icon lucide-clock">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                    </svg>
                    <span>{{ $this->fechaCierre?->format('d/m/Y H:i') ?? 'No cerrado' }}</span>
                </div>

                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="#000000" stroke-width="0.75" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-clock2-icon lucide-clock-2">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 10" />
                    </svg>
                    <span class="font-medium text-gray-700">Total:</span>
                    <span>{{ $this->getTiempoTotalProperty() }}</span>
                </div>
                @php
                    $ticketDerivado = $ticket->estado_id === 2;
                    $esMiArea = Auth::check() && Auth::user()->area_id === $ticket->area_id;
                @endphp
                @php
                    $yaAsignadoAMi =
                        isset($ticket->assignedUser) && Auth::check() && $ticket->assignedUser->id === Auth::user()->id;
                @endphp
                @if ($ticketDerivado && !$yaAsignadoAMi)
                    <button wire:click="asignarme"
                        class="ml-4 inline-flex items-center gap-2 px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold rounded-full shadow-lg transition-transform transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m16 11 2 2 4-4M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2m13-14a4 4 0 1 1-8 0 4 4 0 0 1 8 0z" />
                        </svg>
                        Asignarme
                    </button>
                @endif
            </div>

        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
        <div class="md:col-span-8 space-y-6">
            <div class="rounded-xl border bg-white ">
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
                        <textarea readonly rows="3"
                            class="w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2 text-gray-800 text-sm">{{ $ticket->falla_reportada ?? 'Sin información' }}</textarea>
                    </div>

                    <div>
                        <label class="block text-gray-500 font-medium mb-1">Comentario Inicial</label>
                        <textarea rows="3" readonly
                            class="w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2 text-gray-800 text-sm">{{ $ticket->comentario ?? 'No hay comentarios' }}</textarea>
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
                    @if (!empty($ticket->motivo_derivacion))
                        <div>
                            <label class="block text-gray-500 font-medium mb-1">Motivo de Derivación</label>
                            <input readonly type="text" value="{{ $ticket->motivo_derivacion }}"
                                class="w-full rounded-md border border-gray-200 bg-yellow-50 px-3 py-2 text-yellow-800 text-sm font-semibold" />
                        </div>
                    @endif
                    <div>
                        <label class="block text-gray-500 font-medium mb-1">Asignado a</label>
                        <input readonly type="text" value="{{ $ticket->assignedUser->name ?? 'No asignado' }}"
                            class="w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2 text-gray-800 text-sm" />
                    </div>
                    <div>
                        <label class="block text-gray-500 font-medium mb-1">Observación Inicial</label>
                        <input readonly type="text"
                            value="{{ $ticket->observacion->descripcion ?? ($ticket->observacion_consulta ?? 'No hay observaciones') }}"
                            class="w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2 text-gray-800 text-sm" />
                    </div>
                    {{-- <div>
                        <label class="block text-gray-500 font-medium mb-1">Observación Inicial</label>
                        <input readonly type="text"
                            value="{{ $ticket->observacion->descripcion ?? ($ticket->observacion_consulta ?? 'No hay observaciones') }}"
                            class="w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2 text-gray-800 text-sm" />
                    </div> --}}
                </div>

                {{-- BLOQUE DE MENSAJES DE ESTADO DEL TICKET --}}
@if ($ticket->estado_id == 5)
    {{-- ✅ Ticket cerrado --}}
    <div class="px-6 pb-6">
        <div
            class="rounded-xl border p-4 border-success-500 bg-success-50 dark:border-success-500/30 dark:bg-success-500/15">
            <div class="flex items-start gap-3">
                <div class="-mt-0.5 text-success-500">
                    <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M3.70186 12.0001C3.70186 7.41711 7.41711 3.70186 12.0001 3.70186C16.5831 3.70186 20.2984 7.41711 20.2984 12.0001C20.2984 16.5831 16.5831 20.2984 12.0001 20.2984C7.41711 20.2984 3.70186 16.5831 3.70186 12.0001ZM12.0001 1.90186C6.423 1.90186 1.90186 6.423 1.90186 12.0001C1.90186 17.5772 6.423 22.0984 12.0001 22.0984C17.5772 22.0984 22.0984 17.5772 22.0984 12.0001C22.0984 6.423 17.5772 1.90186 12.0001 1.90186ZM15.6197 10.7395C15.9712 10.388 15.9712 9.81819 15.6197 9.46672C15.2683 9.11525 14.6984 9.11525 14.347 9.46672L11.1894 12.6243L9.6533 11.0883C9.30183 10.7368 8.73198 10.7368 8.38051 11.0883C8.02904 11.4397 8.02904 12.0096 8.38051 12.3611L10.553 14.5335C10.7217 14.7023 10.9507 14.7971 11.1894 14.7971C11.428 14.7971 11.657 14.7023 11.8257 14.5335L15.6197 10.7395Z"
                            fill="currentColor"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="mb-1 text-sm font-semibold text-gray-800 dark:text-white/90">Mensaje</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Este ticket ha sido cerrado y no puede ser modificado.
                    </p>
                </div>
            </div>
        </div>
    </div>

@elseif ($ticket->estado_id == 4)
    {{-- ❌ Ticket anulado --}}
    <div class="px-6 pb-6">
        <div
            class="rounded-md bg-red-50 border border-red-200 p-4 mt-4 text-sm text-red-800 flex items-center gap-2">
            <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01M12 5.5a6.5 6.5 0 11-6.5 6.5A6.5 6.5 0 0112 5.5z" />
            </svg>
            <span>Este ticket ha sido <strong>anulado</strong> y no puede modificarse.</span>
        </div>
    </div>

@elseif (!$this->puedeActualizar)
    {{-- 🔵 No asignado al usuario actual --}}
    <div class="px-6 pb-6">
        <div
            class="rounded-xl border p-4 border-blue-light-500 bg-blue-light-50 dark:border-blue-light-500/30 dark:bg-blue-light-500/15">
            <div class="flex items-start gap-3">
                <div class="-mt-0.5 text-blue-light-500">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M3.5 12C3.5 7.30558 7.30558 3.5 12 3.5C16.6944 3.5 20.5 7.30558 20.5 12C20.5 16.6944 16.6944 20.5 12 20.5C7.30558 20.5 3.5 16.6944 3.5 12ZM12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2ZM11.0991 7.52507C11.0991 8.02213 11.5021 8.42507 11.9991 8.42507H12.0001C12.4972 8.42507 12.9001 8.02213 12.9001 7.52507C12.9001 7.02802 12.4972 6.62507 12.0001 6.62507H11.9991C11.5021 6.62507 11.0991 7.02802 11.0991 7.52507ZM12.0001 17.3714C11.5859 17.3714 11.2501 17.0356 11.2501 16.6214V10.9449C11.2501 10.5307 11.5859 10.1949 12.0001 10.1949C12.4143 10.1949 12.7501 10.5307 12.7501 10.9449V16.6214C12.7501 17.0356 12.4143 17.3714 12.0001 17.3714Z"
                            fill="currentColor"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="mb-1 text-sm font-semibold text-gray-800 dark:text-white/90">
                        Información del Mensaje
                    </h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        No puedes actualizar este ticket porque no está asignado a ti.
                    </p>
                </div>
            </div>
        </div>
    </div>

@elseif ($ticket->estado_id == 6 && $this->puedeActualizar)
    {{-- 🟢 Ticket pausado --}}
    <div class="px-6 pb-6">
        <div
            class="rounded-md bg-green-50 border border-green-200 p-4 mt-4 text-sm text-green-800 flex items-center justify-between gap-2">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01M12 5.5a6.5 6.5 0 11-6.5 6.5A6.5 6.5 0 0112 5.5z" />
                </svg>
                <span>Este ticket está pausado. Puedes reanudarlo para continuar.</span>
            </div>
            <button wire:click="reanudarTicket"
                class="text-sm px-4 py-1.5 bg-blue-500 hover:bg-blue-700 text-white rounded-md">
                Reanudar Ticket
            </button>
        </div>
    </div>

@elseif ($ticket->estado_id != 5 && $this->puedeActualizar && !$this->estaPausado)
    {{-- ✏️ Formulario de actualización --}}
    <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
        <!-- Título -->
       
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
                            <div class="flex flex-col mt-4">
                                <label for="usuario_derivacion" class="text-sm font-semibold text-gray-700 mb-2">
                                    Derivar a Usuario
                                </label>
                                <select id="usuario_derivacion" wire:model="usuario_derivacion" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg shadow-sm 
                   focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                   bg-white">
                                    <option value="">Seleccione un usuario</option>
                                    @foreach ($responsables as $resp)
                                    <option value="{{ $resp->id }}">
                                        {{ $resp->name }} {{ $resp->lastname }} — Prioridad {{ $resp->prioridad }}
                                    </option>
                                    @endforeach
                                </select>
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
                            wire:target="ActualizarTicket" x-data x-on:click="Swal.fire({ 
                                    title: 'Actualizando...', 
                                    text: 'Por favor espera.', 
                                    allowOutsideClick: false, 
                                    didOpen: () => { Swal.showLoading() } 
                                })"
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
        
    </div>
@endif


 </div>
        </div>
        <!-- Sección Historial del Ticket mejorado con acordeón y buscador -->
        <div class="md:col-span-4 rounded-xl border  bg-white ">
            <!-- Encabezado -->
            <div class="px-6 py-4 border-b  flex items-center gap-2">
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

                    @php
                        $accion = strtolower($item->accion ?? 'evento');

                        $icono = match ($accion) {
                            'creado' => 'clock',
                            'derivado' => 'arrow-path',
                            'cerrado' => 'lock',
                            'pausado' => 'pause',
                            default => 'document',
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
                </svg>',
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
                                    <span class="inline-block text-gray-400 mr-1"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="#121212" stroke-width="1.25"
                                            stroke-linecap="round" stroke-linejoin="round"
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
                                    <span class="inline-block text-gray-400 mr-1"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1.25"
                                            stroke-linecap="round" stroke-linejoin="round"
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
                                <div
                                    class="text-sm bg-gray-50 text-gray-800 px-4 py-1.5 rounded border border-gray-100 mt-1">
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
                                    <p class="text-base text-gray-500 italic mt-1">
                                        <template x-if="verMas">
                                            <span>{{ $item->comentario }}</span>
                                        </template>
                                        <template x-if="!verMas">
                                            <span>{{ Str::limit($item->comentario, 100) }}</span>
                                        </template>
                                        @if (strlen($item->comentario) > 100)
                                            <a @click="verMas = !verMas"
                                                class="text-blue-500 font-medium cursor-pointer ml-1"
                                                x-text="verMas ? 'ver menos' : 'ver más'"></a>
                                        @endif
                                    </p>
                                </div>
                            @endif
                            @if ($item->archivos && $item->archivos->count())
                                <div class="mt-1 text-sm text-gray-700">
                                    <strong class="block text-xs text-gray-500 mb-1">Archivos adjuntos:</strong>
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

    <script>
        $wire.on("notifyActu", ({
            type,
            message
        }) => {
            Swal.close(); // Cierra el loader
            Swal.fire({
                icon: type,
                title: 'Ticket',
                text: message,
            });
        });
    </script>
@endscript
