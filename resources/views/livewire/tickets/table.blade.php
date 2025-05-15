<div>
    <div class="rounded-lg border bg-card text-card-foreground shadow-sm mt-4 p-5">
        <div class="mb-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <flux:input wire:model.live="search" as="text" placeholder="Buscar Usuario..." icon="magnifying-glass"
                class="w-full sm:w-auto" />
            <flux:modal.trigger name="edit-profile">
                <flux:modal.trigger name="edit-profile">
                    <flux:button wire:click="crearUsuario" icon="plus" class="w-full sm:w-auto bg-black"
                        wire:click="$toggle('showModal')">Crear Nuevo Ticket</flux:button>
                </flux:modal.trigger>
            </flux:modal.trigger>
        </div>
        <div class="overflow-auto">
            <table class="w-full text-sm text-left border border-gray-200 rounded-lg">
                <thead class="bg-gray-50 text-gray-700">
                    <tr>
                        <th class="px-3 py-2"">Código</th>
                        <th class=" px-3 py-2"">Falla Reportada</th>
                        <th class="px-3 py-2"">Tipo</th>
                        <th class=" px-3 py-2"">Técnico</th>
                        <th class="px-3 py-2"">Equipo</th>
                        <th class=" px-3 py-2"">Agencia</th>
                        <th class="px-3 py-2"">Área</th>
                        <th class=" px-3 py-2"">Asignado a</th>
                        <th class="px-3 py-2"">Creado por</th>
                        <th class=" px-3 py-2"">Estado</th>
                        <th class="px-3 py-2"">Acciones</th>
                    </tr>
                </thead>
                <tbody class=" text-gray-800 font-medium">
                            @foreach ($tickets as $ticket)
                    <tr class="border-t">
                        <td class="p-4 align-middle font-medium">
                            <a href="{{ route('tickets.show', $ticket->id) }}" class="text-blue-500 hover:underline">
                                {{ $ticket->codigo }}
                            </a>
                        </td>
                        <td class="py-3 px-4 ">{{ $ticket->falla_reportada }}</td>
                        <td class="py-3 px-4 ">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $ticket->tipo === 'ticket' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                {{ ucfirst($ticket->tipo) }}
                            </span>
                        </td>
                        <td class="py-3 px-4">{{ $ticket->tecnico_nombres }} {{ $ticket->tecnico_apellidos }}
                        </td>
                        <td class="py-3 px-4 ">{{ $ticket->equipo->serie }} - {{ $ticket->equipo->modelo}}</td>
                        <td class="py-3 px-4 ">{{ $ticket->agencia->nombre }}</td>
                        <td class="py-3 px-4 ">{{ $ticket->area->nombre ?? 'Sin Area' }}</td>
                        <td class="py-3 px-4">
                            @if ($ticket->assignedUser)
                            {{ $ticket->assignedUser->name }}
                            @else
                            <flux:modal.trigger name="asignar-ticket-{{ $ticket->id }}">
                                <span class="text-blue-600 hover:underline cursor-pointer">Asignarme</span>
                            </flux:modal.trigger>
                            @endif
                        </td>
                        </td>
                        <td class="py-3 px-4 ">{{ $ticket->createdBy->name }}</td>
                        <td class="py-3 px-4 ">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $ticket->estado->nombre === 'Abierto' ? 'bg-green-100 text-green-800' : ($ticket->estado->nombre === 'Cerrado' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($ticket->estado->nombre) }}
                            </span>
                        </td>
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
                    <div class="mt-5 flex flex-col sm:flex-row justify-between items-start sm:items-center ml-2">
                    </div>
            </table>
        </div>
        <div class="text-sm opacity-50 mt-4">
            Mostrando {{ $tickets->firstItem() }} a {{ $tickets->lastItem() }} de {{ $tickets->total() }} usuarios
        </div>
        <div class="inline-flex rounded-md px-4 py-2">
            {{ $tickets->links('vendor.livewire.custom-tailwind') }}
        </div>
    </div>
    <!-- Modal -->
    <x-modal wire:model="showModal">
        <div class="space-y-6">
            <div>
                <h2 class="text-xl font-bold">Crear Nuevo Ticket</h2>
                <p class="mt-2 text-gray-600">Ingrese el código para el nuevo ticket</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-start">
                <!-- Input de código -->
                <div class="col-span-2">
                    <input wire:model="codigoInput"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Ingresa el código">
                    @error('codigoInput')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                    @error('ticketError')
                    <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Botón de búsqueda -->
                <div>
                    <button wire:click="buscarTicket" wire:loading.attr="disabled"
                        class="w-full px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition flex items-center justify-center gap-2">
                        <span>Buscar</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
            </div>
            <!-- Resultado del ticket -->
            @if($ticketData)
            <div class="mt-6 bg-gray-50 p-4 rounded shadow text-sm text-gray-700">
                <h3 class="text-base font-bold mb-2">🎫 Ticket {{ $ticketData['number'] }}</h3>
                {{-- <p><strong>ID:</strong> {{ $ticketData['ticket_id'] }}</p> --}}
                <p><strong>Asunto:</strong> {{ $ticketData['subject'] }}</p>
                <p><strong>Falla reportada:</strong> {{ $ticketData['falla_reportada'] }}</p>
                <p><strong>Equipo:</strong> {{ $ticketData['id_equipo'] }} - {{ $ticketData['serie'] }} - {{
                    $ticketData['modelo'] }}</p>
                <p><strong>Usuario:</strong> {{ $ticketData['dni'] }} - {{ $ticketData['nombres'] }} {{
                    $ticketData['apellidos'] }}</p>
                <p><strong>ID Agencia:</strong> {{ $ticketData['id_agencia'] }}</p>
                <p><strong>Agencia:</strong> {{ $ticketData['agencia'] }}</p>
                <p><strong>ID Cliente:</strong> {{ $ticketData['id_cliente'] }}</p>
                <p><strong>Cliente:</strong> {{ $ticketData['cliente'] }}</p>
                <p><strong>ID Empresa:</strong> {{ $ticketData['id_empresa'] }}</p>
                <p><strong>Empresa:</strong> {{ $ticketData['empresa'] }}</p>
            </div>
            @endif
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                <flux:select wire:model.live="estado_id" placeholder="Seleccionar estado">
                    @foreach($estados as $estado)
                    <flux:select.option value="{{ $estado->id }}">{{ $estado->nombre }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Observación</label>
                <textarea wire:model="observacion"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Escribe una observación..."></textarea>
                @error('observacion')
                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror
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
            <div class="mt-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                <flux:select wire:model.live="tipoTicket" placeholder="Seleccionar tipo">
                    <flux:select.option value="ticket">Ticket</flux:select.option>
                    <flux:select.option value="consulta">Consulta</flux:select.option>
                </flux:select>
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Comentario</label>
                <textarea wire:model="comentario"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Detalles adicionales..."></textarea>
                @error('comentario')
                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex justify-end gap-2 mt-4">
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
    @foreach ($tickets as $ticket)
    {{-- ... tu fila de tabla ... --}}
    @if (!$ticket->assignedUser)
    <flux:modal name="asignar-ticket-{{ $ticket->id }}" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">¿Quieres asignarte este ticket?</flux:heading>
                <flux:text class="mt-2">Este ticket aún no ha sido asignado.</flux:text>
            </div>
            <div class="flex justify-end space-x-2">
                <flux:button variant="ghost" @click="$closeModal()">Cancelar</flux:button>
                <flux:button variant="primary" wire:click="asignar({{ $ticket->id }})" wire:loading.attr="disabled">
                    Confirmar
                </flux:button>
            </div>
        </div>
    </flux:modal>
    @endif
    @endforeach
</div>
@script
<script>
    $wire.on("notify", () =>{
    Swal.fire({
    icon: 'success',
    title: 'Ticket',
    text: 'Ticket registrado exitosamente',
    });
   })
//     $wire.on("notifyError", () =>{
//     Swal.fire({
//     icon: 'error',
//     title: 'Ticket',
//     text: 'Error al registrar el ticket',
//     });
//    })   
</script>
@endscript