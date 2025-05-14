<div class="p-6 bg-white rounded-lg shadow-md">
    <div class="flex items-center mb-6">
        <button onclick="window.location.href='{{ route('tickets.index') }}'" class="inline-flex items-center justify-center gap-2 text-sm font-medium 
            ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 
            focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none 
            disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3 mr-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-arrow-left mr-2 h-4 w-4">
                <path d="m12 19-7-7 7-7"></path>
                <path d="M19 12H5"></path>
            </svg>Volver
        </button>
        <h1 class="text-2xl font-bold">Ticket #{{ $ticket->codigo }}</h1>
        <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold
            bg-red-100 text-red-800 hover:bg-red-100 ml-4" data-v0-t="badge">
            {{ $ticket->estado->nombre ?? 'Sin estado' }}
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-6">
            <div class="rounded-lg border bg-card shadow-sm">
                <div class="p-6">
                    <h3 class="text-2xl font-semibold">Detalles del Ticket</h3>
                </div>
                <div class="p-6 pt-0 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-muted-foreground">Falla Reportada</p>
                            <p>{{ $ticket->falla_reportada ?? 'Sin información' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-muted-foreground">Tipo</p>
                            <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold
                                bg-blue-100 text-blue-800 hover:bg-blue-100">
                                {{ $ticket->tipo ?? 'No especificado' }}
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-muted-foreground">Técnico</p>
                            <p>{{ $ticket->tecnico_nombres ?? 'Sin técnico asignado' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-muted-foreground">Agencia</p>
                            <p>{{ $ticket->agencia->nombre ?? 'Sin agencia' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-muted-foreground">Área</p>
                            <p>{{ $ticket->area_id ?? 'Sin Área' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-muted-foreground">Asignado a</p>
                            <p>{{ $ticket->assignedUser->name ?? 'No asignado' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-muted-foreground">Comentario</p>
                            <p class="mt-1">{{ $ticket->comentario ?? 'No hay comentarios' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-muted-foreground">Observación</p>
                            <p class="mt-1">{{ $ticket->observacion ?? 'No hay observaciones' }}</p>
                        </div>
                    </div>
                </div>
            </div>
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
                <label class="block text-sm font-medium text-gray-700 mb-1">Areas</label>
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
                <div class="flex justify-end gap-2 mt-4">
                    <button wire:click="$set('showModal', false)"
                        class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
                        Cancelar
                    </button>
                    <button wire:click="ActualizarTicket" wire:loading.attr="disabled"
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                        <span>Actualizar Ticket</span>
                    </button>
                </div>
            </div>
        </div>
        <div>
            <div class="rounded-lg border bg-card text-card-foreground shadow-sm" data-v0-t="card">
                <div class="flex flex-col space-y-1.5 p-6 pb-3">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-clock h-5 w-5 text-muted-foreground">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        <h2 class="text-xl font-semibold">Historial del Ticket</h2>
                    </div>
                </div>
                <div class="p-6 pt-0">
                    <div class="space-y-4">
                        @forelse($historiales as $item)
                        <div class="relative pb-4">
                            <div class="absolute left-3.5 top-5 -bottom-4 w-px bg-border"></div>
                            <div class="absolute left-0 flex items-center justify-center mt-1">
                                <div
                                    class="h-7 w-7 rounded-full border-2 border-border bg-blue-100 flex items-center justify-center">
                                    <div class="h-2.5 w-2.5 rounded-full bg-blue-600"></div>
                                </div>
                            </div>
                            <div class="ml-12">
                                <div class="flex items-start">
                                    <div class="flex flex-col space-y-1">
                                        <span class="font-medium">{{ $item->accion ?? 'Actualización' }}</span>
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-muted-foreground">Estado: {{ $item->estado->nombre
                                                ?? 'N/A' }}</span>
                                            <span class="text-xs text-muted-foreground">{{
                                                $item->created_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="ml-6 mt-2 space-y-1">
                                    <div class="text-sm"><span class="font-medium">Por:</span> {{ $item->usuario->name
                                        ?? 'N/A' }}</div>
                                    @if($item->from_area_id)
                                    <div class="text-sm"><span class="font-medium">De área:</span> {{
                                        $item->fromArea->nombre ?? '' }}</div>
                                    @endif
                                    @if($item->to_area_id)
                                    <div class="text-sm"><span class="font-medium">Hacia área:</span> {{
                                        $item->toArea->nombre ?? '' }}</div>
                                    @endif
                                    @if($item->asignado_a)
                                    <div class="text-sm"><span class="font-medium">Asignado a:</span> {{
                                        $item->asignadoA->name ?? '' }}</div>
                                    @endif
                                    @if($item->comentario)
                                    <div class="text-sm italic text-muted-foreground">"{{ $item->comentario }}"</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <p class="text-sm text-muted-foreground">No hay historial disponible para este ticket.</p>
                        @endforelse
                    </div>
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