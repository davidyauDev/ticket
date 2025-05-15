<div>
    <div>
    <div class="rounded-lg border bg-card text-card-foreground shadow-sm mt-4 p-5">
       
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
</div>
</div>
