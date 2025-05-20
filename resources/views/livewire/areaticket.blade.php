<div>
    <div class="bg-white shadow-md rounded-xl border p-6 ">
        <h2 class="text-xl sm:text-2xl font-semibold text-gray-700 mb-2">
            Tickets del Área
            <span class="ml-1 text-gray-500 font-normal italic">{{ ucwords(str_replace('-', ' ', $slug)) }}</span>
        </h2>
        <p class="text-sm text-gray-500 mb-6">
            Filtra y visualiza los tickets de soporte según su estado y fechas de creación.
        </p>
        </h2>
        <div
            class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 space-y-2 sm:space-y-0 sm:space-x-4">
            <div class="flex space-x-2 border-b">
                <button wire:click="setEstado(1)"
                    class="px-4 py-2 font-semibold border-b-2 {{ $estado_id === 1 ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-600' }}">
                    Abiertos ({{ $total_abiertos }})
                </button>
                <button wire:click="setEstado(2)"
                    class="px-4 py-2 font-semibold border-b-2 {{ $estado_id === 2 ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-600' }}">
                    En Proceso ({{ $total_en_proceso }})
                </button>
                <button wire:click="setEstado(4)"
                    class="px-4 py-2 font-semibold border-b-2 {{ $estado_id === 4 ? 'border-red-500 text-red-600' : 'border-transparent text-gray-600' }}">
                    Cerrados ({{ $total_cerrados }})
                </button>
            </div>
            <!-- Filtros de fecha -->
            <div class="flex space-x-2">
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Desde</label>
                    <input type="date" wire:model.live="fecha_inicio"
                        class="border border-gray-300 rounded-lg px-3 py-1 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Hasta</label>
                    <input type="date" wire:model.live="fecha_fin"
                        class="border border-gray-300 rounded-lg px-3 py-1 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
            </div>
        </div>

        <div class="overflow-auto rounded-lg">
            <table class="w-full text-sm text-left border border-gray-200">
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
                        <td class="py-3 px-4">
                            <div x-data="{ open: false }">
                                <template x-if="!open">
                                    <span>
                                        {{ \Illuminate\Support\Str::limit($ticket->falla_reportada, 15) }}
                                        @if(strlen($ticket->falla_reportada) > 15)
                                        <a href="#" class="text-blue-600 ml-1 hover:underline"
                                            @click.prevent="open = true">Ver más</a>
                                        @endif
                                    </span>
                                </template>
                                <template x-if="open">
                                    <span>
                                        {{ $ticket->falla_reportada }}
                                        <a href="#" class="text-blue-600 ml-1 hover:underline"
                                            @click.prevent="open = false">Ver menos</a>
                                    </span>
                                </template>
                            </div>
                        </td>
                        <td class="py-3 px-4 ">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $ticket->tipo === 'ticket' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                {{ ucfirst($ticket->tipo) }}
                            </span>
                        </td>
                        <td class="py-3 px-4">{{ $ticket->tecnico_nombres }} {{ $ticket->tecnico_apellidos }}
                        </td>
                        <td class="py-3 px-4">
                            <div x-data="{ open: false }">
                                <template x-if="!open">
                                    <span>
                                        {{ \Illuminate\Support\Str::limit($ticket->equipo->serie . ' - ' .
                                        $ticket->equipo->modelo, 10) }}
                                        @if(strlen($ticket->equipo->serie . ' - ' . $ticket->equipo->modelo) > 10)
                                        <a href="#" class="text-blue-600 ml-1 hover:underline"
                                            @click.prevent="open = true">Ver más</a>
                                        @endif
                                    </span>
                                </template>
                                <template x-if="open">
                                    <span>
                                        {{ $ticket->equipo->serie }} - {{ $ticket->equipo->modelo }}
                                        <a href="#" class="text-blue-600 ml-1 hover:underline"
                                            @click.prevent="open = false">Ver menos</a>
                                    </span>
                                </template>
                            </div>
                        </td>
                        <td class="py-3 px-4 ">{{ $ticket->agencia->nombre }}</td>
                        <td class="py-3 px-4 ">{{ $ticket->area->nombre ?? 'Sin Area' }}</td>
                        <td class="py-3 px-4">
                            @if ($ticket->assignedUser)
                            {{ $ticket->assignedUser->name }}
                            @else
                                <span class="text-blue-600 hover:underline cursor-pointer">No asignado</span>
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
                                    <flux:modal.trigger name="delete-profile">
                                        <flux:menu.item icon="trash">Anular Ticket</flux:menu.item>
                                    </flux:modal.trigger>
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
        <div class="flex justify-between items-center mt-4">
            <div class="text-sm opacity-50">
                Mostrando {{ $tickets->firstItem() }} a {{ $tickets->lastItem() }} de {{ $tickets->total() }} tickets
            </div>
            <div>
                {{ $tickets->links('vendor.livewire.custom-tailwind') }}
            </div>
        </div>

    </div>
</div>