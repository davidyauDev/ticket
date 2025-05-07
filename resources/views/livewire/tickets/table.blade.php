<!-- resources/views/livewire/ticket-search.blade.php -->
<div class="p-4 bg-gray-100 rounded-lg shadow-md">
    <div class="flex flex-wrap gap-4 mb-4">
        <input
            type="text"
            wire:model.live.debounce.500ms="search"
            placeholder="Buscar por código o comentario..."
            class="w-full md:w-1/3 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        <select
            wire:model.live="estado"
            class="w-full md:w-1/4 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            {{-- @foreach($estados as $estadoOption)
                <option value="{{ $estadoOption }}">{{ $estadoOption }}</option>
            @endforeach --}}
        </select>
        <input
            wire:model.live="usuario"
            class="w-full md:w-1/4 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Usuario asignado...">
        <button
            wire:click="$toggle('showModal')"
            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
            Crear Nuevo Ticket
        </button>
    </div>

    <!-- Modal -->
    <x-modal wire:model="showModal">
        <div class="space-y-6">
            <div>
                <h2 class="text-xl font-bold">Crear Nuevo Ticket</h2>
                <p class="mt-2 text-gray-600">Ingrese el código para el nuevo ticket</p>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <input
                    wire:model="codigoInput"
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Ingresa el código">
                <button
                    wire:click="buscarTicket"
                    wire:loading.attr="disabled"
                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition flex items-center justify-center gap-2">
                    <span wire:loading.remove>Buscar</span>
                    <span wire:loading>Buscando...</span>
                    <svg wire:loading.remove class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </div>

            <!-- Resultado del ticket -->
            @if($ticketData)
                <div class="mt-6 bg-gray-50 p-4 rounded shadow text-sm text-gray-700">
                    <h3 class="text-base font-bold mb-2">🎫 Ticket {{ $ticketData['number'] }}</h3>
                    <p><strong>ID:</strong> {{ $ticketData['ticket_id'] }}</p>
                    <p><strong>Asunto:</strong> {{ $ticketData['subject'] }}</p>
                    <p><strong>Falla reportada:</strong> {{ $ticketData['falla_reportada'] }}</p>
                    <p><strong>Fecha de solicitud:</strong> {{ $ticketData['tkt_fhsolicitud'] }}</p>
                    <p><strong>Estado ID:</strong> {{ $ticketData['status_id'] }}</p>
                    <p><strong>Departamento ID:</strong> {{ $ticketData['dept_id'] }}</p>
                    <p><strong>Prioridad:</strong> {{ $ticketData['priority'] }}</p>
                    <p><strong>Fuente:</strong> {{ $ticketData['source'] }}</p>
                    <p><strong>Equipo:</strong> {{ $ticketData['id_equipo'] ?? 'N/A' }}</p>
                    <p><strong>Activo:</strong> {{ $ticketData['activo'] }}</p>
                    <p><strong>Fecha estimada vencimiento:</strong> {{ $ticketData['est_duedate'] ?? 'No definida' }}</p>
                </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Notas del ticket</label>
                <textarea
                    wire:model="notes"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Detalles adicionales..."></textarea>
            </div>

            <div class="flex justify-end gap-2">
                <button
                    wire:click="$set('showModal', false)"
                    class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
                    Cancelar
                </button>
                <button
                    wire:click="registrarTicket"
                    wire:loading.attr="disabled"
                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                    <span wire:loading.remove>Registrar Ticket</span>
                    <span wire:loading>Registrando...</span>
                </button>
            </div>
        </div>
    </x-modal>
</div>
