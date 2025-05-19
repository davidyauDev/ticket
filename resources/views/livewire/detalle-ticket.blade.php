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
            <h1 class="text-2xl font-bold text-gray-800">Ticket #{{ $ticket->codigo }}</h1>
            <div
                class="inline-flex items-center rounded-full bg-red-100 text-red-700 text-xs font-semibold px-3 py-1 border border-red-200">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                {{ $ticket->estado->nombre ?? 'Sin estado' }}
            </div>
        </div>

        <div class="mt-4 md:mt-0 flex items-center gap-4 text-sm text-gray-600">
            <div>
                <p><span class="font-medium">Inicio:</span> {{ $this->fechaInicio?->format('d/m/Y H:i') ?? 'N/A' }}</p>
                <p><span class="font-medium">Cierre:</span> {{ $this->fechaCierre?->format('d/m/Y H:i') ?? 'No cerrado'
                    }}</p>
            </div>
            @if($this->tiempoTotal)
            <div class="text-xs px-3 py-1 rounded-lg bg-gray-100 text-gray-800 border border-gray-300">
                ⏱️ Cerrado en {{ $this->tiempoTotal }}
            </div>
            @endif
        </div>
    </div>



    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-6">

            <div class="rounded-xl border bg-white shadow-sm">
                <div class="p-6 border-b">
                    <h3 class="text-xl font-semibold text-gray-800">Detalles del Ticket</h3>
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
                            {{ $ticket->tipo ?? 'No especificado' }}
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
                        <p class="mt-1 text-gray-600">{{ $ticket->observacion ?? 'No hay observaciones' }}</p>
                    </div>
                </div>
            </div>

            @if($this->puedeActualizar && $ticket->estado_id != 5 && $ticket->estado_id != 4)
            <div>
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                    <flux:select wire:model.live="estado_id" placeholder="Seleccionar estado">
                        @foreach($estados as $estado)
                        <flux:select.option value="{{ $estado->id }}">{{ $estado->nombre }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
                @if($estado_id == 2)
                <label class="block text-sm font-medium text-gray-700 mt-3">Areas</label>
                <div class="mt-2">
                    <flux:select wire:model.live="selectedArea" placeholder="Seleccione un área...">
                        @foreach($areas as $area)
                        <flux:select.option value="{{ $area['id'] }}">{{ $area['nombre'] }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
                @endif
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Comentario</label>
                    <textarea wire:model="comentario"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Detalles adicionales..."></textarea>
                </div>
                <div class="flex justify-end mt-4">
                    <button wire:click="ActualizarTicket" wire:loading.attr="disabled"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition">
                        Actualizar Ticket
                    </button>
                </div>
            </div>
            @endif
            @if(!$this->puedeActualizar)
            <p class="text-sm text-red-500 mt-2">No puedes actualizar este ticket porque no está asignado a ti.</p>
            @endif
        </div>
        <div>
           <div class="rounded-xl border bg-white shadow-sm">
    <div class="p-6 border-b flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock-arrow-down-icon lucide-clock-arrow-down"><path d="M12.338 21.994A10 10 0 1 1 21.925 13.227"/><path d="M12 6v6l2 1"/><path d="m14 18 4 4 4-4"/><path d="M18 14v8"/></svg>
        <h2 class="text-xl font-semibold text-gray-800">Historial del Ticket</h2>
    </div>

    <div class="p-6 pt-4 max-h-[700px] overflow-y-auto space-y-6">
        @forelse($historiales as $item)
        <div class="flex items-start gap-4 border-b pb-4 last:border-0">
            <!-- Icono a la izquierda -->
           <div class="mt-1">
               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-chevron-right-icon lucide-circle-chevron-right"><circle cx="12" cy="12" r="10"/><path d="m10 8 4 4-4 4"/></svg>
            </div> 
            <!-- Contenido -->
            <div class="flex-1">
                <div class="flex justify-between items-center">
                    <div class="font-semibold text-gray-800">{{ $item->accion ?? 'Actualización' }}</div>
                    <div class="text-xs text-gray-400">{{ $item->created_at->format('d/m/Y H:i') }}</div>
                </div>
                <!-- Estado con badge -->
                <div class="mt-1">
                    @php
                        $estado = strtolower($item->estado->nombre ?? '');
                        $estilos = match($estado) {
                            'pendiente' => 'bg-yellow-100 text-yellow-800',
                            'cerrado' => 'bg-red-100 text-red-800',
                            'abierto' => 'bg-green-100 text-green-800',
                            'derivado' => 'bg-blue-100 text-blue-800',
                            default => 'bg-gray-200 text-gray-800',
                        };
                    @endphp
                    <span class="inline-block text-xs font-medium px-2 py-0.5 rounded-full {{ $estilos }}">
                        {{ $item->estado->nombre ?? 'Sin estado' }}
                    </span>
                </div>
                <!-- Detalles -->
                <div class="mt-2 text-sm text-gray-700 space-y-1">
                    <p><strong>Por:</strong> {{ $item->usuario->name ?? 'N/A' }}</p>

                    @if($item->from_area_id)
                    <p><strong>De área:</strong> {{ $item->fromArea->nombre }}</p>
                    @endif

                    @if($item->to_area_id)
                    <p><strong>Hacia área:</strong> {{ $item->toArea->nombre }}</p>
                    @endif

                    @if($item->asignado_a)
                    <p><strong>Asignado a:</strong> {{ $item->asignadoA->name }}</p>
                    @endif

                    @if($item->comentario)
                    <p class="italic text-gray-500">"{{ $item->comentario }}"</p>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <p class="text-sm text-gray-500">No hay historial disponible para este ticket.</p>
        @endforelse
    </div>
</div>
        </div>
    </div>
</div>

@script
<script>
    $wire.on("notifyActu", () =>{
    Swal.fire({
    icon: 'success',
    title: 'Ticket',
    text: 'Ticket Actualizad exitosamente',
    });
   })
</script>
@endscript