<!-- resources/views/livewire/ticket-search.blade.php -->
<div>
    <div class="rounded-lg border bg-card text-card-foreground shadow-sm mt-4 p-5">
        <div class="mb-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <flux:input wire:model.live="search" as="text" placeholder="Buscar Usuario..." icon="magnifying-glass"
                class="w-full sm:w-auto" />
            <flux:modal.trigger name="edit-profile">
                <flux:button wire:click="crearUsuario" icon="plus" class="w-full sm:w-auto"
                    wire:click="$toggle('showModal')">Crear Nuevo Ticket</flux:button>
            </flux:modal.trigger>
        </div>
        <div class="mt-4 border rounded-md overflow-x-auto">
            <table class="w-full min-w-[600px]">
                <thead>
                    <tr class="border-b bg-muted/50">
                        <th class="py-3 px-4 text-left text-sm font-medium text-muted-foreground">ID</th>
                        <th class="py-3 px-4 text-left text-sm font-medium text-muted-foreground">Codigo Ticket</th>
                        <th class="py-3 px-4 text-left text-sm font-medium text-muted-foreground">Falla Reportada</th>
                        <th class="py-3 px-4 text-left text-sm font-medium text-muted-foreground">Fecha de Creación</th>
                        <th class="py-3 px-4 text-left text-sm font-medium text-muted-foreground">Id Equipo</th>
                        <th class="py-3 px-4 text-left text-sm font-medium text-muted-foreground">Fecha de creacion</th>
                        <th class="py-3 px-4 text-left text-sm font-medium text-muted-foreground">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $ticket)
                    <tr class="border-b ">
                        <td class="py-3 px-4 text-sm">{{ $ticket->id }}</td>
                        <td class="py-3 px-4 text-sm">{{ $ticket->number }}</td>
                        <td class="py-3 px-4 text-sm">{{ $ticket->falla_reportada }}</td>
                        <td class="py-3 px-4 text-sm">{{ $ticket->subject }}</td>
                        <td class="py-3 px-4 text-sm">{{ $ticket->id_equipo }}</td>
                        <td class="py-3 px-4 text-sm">{{ $ticket->created_at }}</td>

                        <td class="py-3 px-4">
                            <flux:dropdown position="bottom" offset="-15">
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom">
                                </flux:button>
                                <flux:menu>
                                    <flux:modal.trigger name="edit-profile">
                                        <flux:menu.item icon="user">Modificar</flux:menu.item>
                                    </flux:modal.trigger>
                                    <flux:menu.item icon="trash">Anular Ticket</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal -->
    <x-modal wire:model="showModal">
        <div class="space-y-6">
            <div>
                <h2 class="text-xl font-bold">Crear Nuevo Ticket</h2>
                <p class="mt-2 text-gray-600">Ingrese el código para el nuevo ticket</p>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <input wire:model="codigoInput"
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Ingresa el código">
                <button wire:click="buscarTicket" wire:loading.attr="disabled"
                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition flex items-center justify-center gap-2">
                    <span>Buscar</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
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
                <flux:select wire:model.live="estado" placeholder="Seleccionar estado">
                    <flux:select.option value="Pendiente">Pendiente</flux:select.option>
                    <flux:select.option value="En Proceso">En Proceso</flux:select.option>
                    <flux:select.option value="Solucionado">Solucionado</flux:select.option>
                    <flux:select.option value="Resuelto">Resuelto</flux:select.option>
                    <flux:select.option value="Derivado">Derivado</flux:select.option>
                </flux:select>
            </div>
            @if($estado === 'Derivado')
                <flux:select wire:model.live="selectedArea" placeholder="Seleccione un área...">
                    @foreach($areas as $area)
                        <flux:select.option value="{{ $area['id'] }}">{{ $area['name'] }}</flux:select.option>
                    @endforeach
                </flux:select>
            @endif
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Comentario</label>
                <textarea wire:model="notes"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Detalles adicionales..."></textarea>
            </div>
            <div class="flex justify-end gap-2">
                <button wire:click="$set('showModal', false)"
                    class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
                    Cancelar
                </button>
                <button wire:click="registrarTicket" wire:loading.attr="disabled"
                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                    <span>Registrar Ticket</span>
                </button>
            </div>
        </div>
    </x-modal>
</div>