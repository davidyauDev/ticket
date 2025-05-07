<div>
    <div>
        <!-- Modal -->
        <div x-show="showModal" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div @click.away="closeModal" class="bg-white rounded-lg p-6 w-full max-w-2xl">
                <h2 class="text-xl font-bold mb-4">Nuevo Ticket</h2>

                <!-- Buscador -->
                <div class="mb-4">
                    <input
                        type="text"
                        wire:model.live="searchQuery"
                        wire:keydown.debounce.300ms="search"
                        placeholder="Buscar número de ticket..."
                        class="w-full p-2 border rounded"
                    >
                </div>

                <!-- Resultados de la API -->
                <div class="mb-4 max-h-48 overflow-y-auto">
                    @if(count($apiResults) > 0)
                        @foreach($apiResults as $result)
                            <div
                                wire:click="selectItem({{ json_encode($result) }})"
                                class="p-3 hover:bg-gray-100 cursor-pointer border-b {{ $selectedItem && $selectedItem['ticket_id'] === $result['ticket_id'] ? 'bg-blue-100 border-blue-300' : '' }}"
                            >
                                <div class="font-bold text-gray-800">
                                    {{ $result['number'] }} - {{ $result['subject'] }}
                                </div>
                                <div class="text-sm text-gray-600 mt-1">
                                    {{ $result['falla_reportada'] }}
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    Fecha: {{ date('d/m/Y', strtotime($result['tkt_fhsolicitud'])) }}
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="p-3 text-gray-500">
                            @if(strlen($searchQuery) > 2)
                                No se encontraron resultados
                            @else
                                Ingrese al menos 3 caracteres para buscar
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Comentario y resto del formulario... -->
            </div>
        </div>
    </div>

</div>
