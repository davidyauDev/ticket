<div>
    <x-modal wire:model="showModal" class="w-full max-w-2xl">
        <div class="bg-white rounded-xl w-full p-5 space-y-6">
            <!-- Título -->
            <h2 class="text-lg font-semibold text-gray-800">Información del Ticket</h2>

            @if ($ticket)
                <!-- Información del Ticket -->
                <div class="border border-gray-200 rounded-lg p-4 space-y-3 text-sm text-gray-800">

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        <div class="flex items-center gap-2">
                            <!-- Agencia -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8fbbff" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-house-icon lucide-house"><path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/><path d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                            <span><strong>Agencia:</strong> {{ $ticket->agencia->nombre ?? 'No especificada' }}</span>
                        </div>

                        <div class="flex items-center gap-2">
                            <!-- Fecha -->
                           <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ff964c" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock12-icon lucide-clock-12"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12"/></svg>
                            <span><strong>Fecha de Creación:</strong> {{ $ticket->created_at?->format('d/m/Y H:i') }}</span>
                        </div>

                        <div class="flex items-center gap-2">
                            <!-- Usuario -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#b860ff" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-plus-icon lucide-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
                            <span><strong>Creado por:</strong> {{ $ticket->createdBy->name ?? 'N/A' }}</span>
                        </div>

                        <div class="flex items-center gap-2">
                            <!-- Tiempo activo -->
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ff9042" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock-plus-icon lucide-clock-plus"><path d="M12 6v6l3.644 1.822"/><path d="M16 19h6"/><path d="M19 16v6"/><path d="M21.92 13.267a10 10 0 1 0-8.653 8.653"/></svg>
                            <span><strong>Tiempo Activo:</strong>
                                <span class="text-orange-600">
                                    {{ now()->diff($ticket->created_at)->format('%hh %im') }}
                                </span>
                            </span>
                        </div>

                        <div class="flex items-center gap-2">
                            <!-- Área -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#f865b3" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-align-justify-icon lucide-align-justify"><path d="M3 12h18"/><path d="M3 18h18"/><path d="M3 6h18"/></svg>
                            <span><strong>Área:</strong> {{ $ticket->area->nombre ?? 'No especificada' }}</span>
                        </div>

                        <div class="flex items-center gap-2">
                            <!-- Tipo -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#615fff" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-equal-approximately-icon lucide-equal-approximately"><path d="M5 15a6.5 6.5 0 0 1 7 0 6.5 6.5 0 0 0 7 0"/><path d="M5 9a6.5 6.5 0 0 1 7 0 6.5 6.5 0 0 0 7 0"/></svg>
                            <span><strong>Tipo:</strong> {{ ucfirst($ticket->tipo ?? 'No especificado') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Observación -->
                <div>
                    <p class="text-sm font-medium text-gray-800 mb-1">Observación</p>
                    <div class="bg-gray-50 border border-gray-200 rounded p-3 text-sm text-gray-700">
                        {{ $ticket->observacion_consulta ?? 'Sin observaciones' }}
                    </div>
                </div>

                <!-- Comentario de la Persona Derivada -->
                <div>
                    <p class="text-sm font-medium text-gray-800 mb-1">Comentario de la Persona Derivada</p>
                    <div class="bg-blue-50 border border-blue-200 rounded p-3 text-sm text-gray-700">
                        {{ $ultimoHistorialComentario ?? 'Sin comentario registrado' }}
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex justify-end gap-2 pt-4">
                    <button wire:click="$set('showModal', false)"
                        class="px-4 py-2 text-sm text-gray-600 border border-gray-300 rounded hover:bg-gray-100 transition">
                        Cancelar
                    </button>
                    <button wire:click="asignarme"
                        class="px-4 py-2 text-sm text-white bg-green-600 rounded hover:bg-green-700 transition">
                        Asignarme
                    </button>
                </div>
            @else
                <p class="text-gray-500 text-sm">No se encontró información del ticket.</p>
            @endif
        </div>
    </x-modal>
</div>
