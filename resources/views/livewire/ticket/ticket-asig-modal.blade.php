<div>
   <x-modal wire:model="showModal" class="w-full max-w-xl">
    <div class=" bg-black bg-opacity-30 "></div>

        <div class=" flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl w-full max-w-2xl p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Asignación de Ticket</h2>

                @if ($ticket)
                    <div class="space-y-2 text-sm text-gray-700">
                        <p><strong>Código:</strong> {{ $ticket->codigo ?? $ticket->id }}</p>
                        <p><strong>Falla Reportada:</strong> {{ $ticket->falla_reportada ?? 'Sin información' }}</p>
                        <p><strong>Agencia:</strong> {{ $ticket->agencia->nombre ?? 'No especificada' }}</p>
                        <p><strong>Creado por:</strong> {{ $ticket->createdBy->name ?? 'N/A' }} el {{ $ticket->created_at?->format('d/m/Y H:i') }}</p>
                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <button wire:click="$set('showModal', false)"
                            class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                            Cancelar
                        </button>

                        <button wire:click="asignarme"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">
                            Asignarme
                        </button>
                    </div>
                @else
                    <p class="text-gray-500">No se encontró información del ticket.</p>
                @endif
            </div>
        </div>

</x-modal>

</div>