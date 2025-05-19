<div>
    <div class="rounded-lg   text-card-foreground  mt-4 p-2">
        <div class="mb-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <flux:input wire:model.live="search" as="text" placeholder="Buscar Usuario..." icon="magnifying-glass"
                class="w-full sm:w-auto" />
            <flux:modal.trigger name="edit-profile">
                <flux:modal.trigger name="edit-profile">
                    <flux:button icon="plus" class="w-full sm:w-auto bg-black" variant="primary"
                        wire:click="$toggle('showModal')">Crear
                        Nuevo Ticket</flux:button>
                </flux:modal.trigger>
            </flux:modal.trigger>
        </div>
        <div class="overflow-auto">
            <table class="w-full text-sm text-left  border-gray-100  ">
                <thead class="bg-gray-50 text-gray-700 ">
                    <tr>
                        <th class="px-3 py-2"">Código</th>
                        <th class=" px-3 py-2"">Falla Reportada</th>
                        <th class="px-3 py-2"">Tipo</th>
                        <th class=" px-3 py-2"">Técnico</th>
                        <th class="px-3 py-2"">Equipo</th>
                        <th class=" px-3 py-2"">Agencia</th>
                        {{-- <th class="px-3 py-2"">Área</th> --}}
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
                        {{-- <td class="py-3 px-4 ">{{ $ticket->area->nombre ?? 'Sin Area' }}</td> --}}
                        <td class="py-3 px-4">
                            @if ($ticket->assignedUser)
                            {{ $ticket->assignedUser->name }}
                            @else
                            <span class="text-blue-600 hover:underline cursor-pointer"
                                wire:click="confirmarAsignac({{ $ticket->id }})">Asignarme</span>
                            @endif
                        </td>
                        </td>
                        <td class="py-3 px-4 ">{{ $ticket->createdBy->name }}</td>
                        <td class="py-3 px-4">
                            @php
                            $estado = strtolower($ticket->estado->nombre);
                            $estilos = match ($estado) {
                            'abierto' => 'bg-green-600/10 text-green-800 ring-1 ring-inset ring-green-600',
                            'cerrado' => 'bg-red-600/10 text-red-800 ring-1 ring-inset ring-red-600',
                            'pendiente' => 'bg-yellow-400/10 text-yellow-700 ring-1 ring-inset ring-yellow-400',
                            'anulado' => 'bg-gray-500/10 text-gray-800 ring-1 ring-inset ring-gray-500',
                            'derivado' => 'bg-blue-500/10 text-blue-800 ring-1 ring-inset ring-blue-500',
                            default => 'bg-neutral-200 text-neutral-800 ring-1 ring-inset ring-neutral-400',
                            };
                            @endphp
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium capitalize {{ $estilos }}">
                                {{ $ticket->estado->nombre }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <flux:dropdown position="bottom" offset="-15">
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom">
                                </flux:button>
                                <flux:menu>
                                    <flux:menu.item icon="trash" wire:click="confirmarAnulacion({{ $ticket->id }})">
                                        Anular Ticket</flux:menu.item>
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
                Mostrando {{ $tickets->firstItem() }} a {{ $tickets->lastItem() }} de {{ $tickets->total() }} usuarios
            </div>
            <div class="inline-flex rounded-md px-4 py-2">
                {{ $tickets->links('vendor.livewire.custom-tailwind') }}
            </div>
        </div>
    </div>
   <x-modal wire:model="showModal">
    <div class="space-y-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Crear Nuevo Ticket</h2>
            <p class="mt-2 text-gray-600">Ingrese el código para el nuevo ticket</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-start">
            <div class="col-span-2">
                <input wire:model="codigoInput"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black"
                    placeholder="Ingresa el código">
                @error('codigoInput')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror
                @error('ticketError')
                    <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <button wire:click="buscarTicket" wire:loading.attr="disabled"
                    class="w-full px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition flex items-center justify-center gap-2">
                    <span>Buscar</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
        </div>

        @if($ticketData)
        <div class="mt-6 bg-gray-100 p-4 rounded-lg shadow text-sm text-gray-800">
            <h3 class="text-base font-bold mb-2">🎫 Ticket {{ $ticketData['number'] }}</h3>
            <p><strong>Asunto:</strong> {{ $ticketData['subject'] }}</p>
            <p><strong>Falla reportada:</strong> {{ $ticketData['falla_reportada'] }}</p>
            <p><strong>Equipo:</strong> {{ $ticketData['id_equipo'] }} - {{ $ticketData['serie'] }} - {{ $ticketData['modelo'] }}</p>
            <p><strong>Usuario:</strong> {{ $ticketData['dni'] }} - {{ $ticketData['nombres'] }} {{ $ticketData['apellidos'] }}</p>
            <p><strong>Agencia:</strong> {{ $ticketData['agencia'] }}</p>
            <p><strong>Cliente:</strong> {{ $ticketData['cliente'] }}</p>
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
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black"
                placeholder="Escribe una observación..."></textarea>
            @error('observacion')
                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        @if($estado_id == 2)
        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Áreas</label>
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
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black"
                placeholder="Detalles adicionales..."></textarea>
            @error('comentario')
                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex justify-end gap-2 mt-6">
            <button wire:click="$set('showModal', false)"
                class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
                Cancelar
            </button>
            <button wire:click="registrarTicket" wire:loading.attr="disabled"
                class="px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition">
                <span>Registrar Ticket</span>
            </button>
        </div>
    </div>
</x-modal>


    <x-modal wire:model="showAsigna">
        <div class="p-2 space-y-6">
            <div>
                <h2 class="text-2xl font-semibold text-gray-900 mb-2">Asignacion de Ticket</h2>
                <p class="text-sm text-gray-600">
                    ¿Estás seguro que deseas anular el ticket con ID
                    <span class="font-semibold text-red-600">{{ $registroId }}</span>?<br>
                    Esta acción no se puede deshacer.
                </p>
            </div>
            <!-- Botones -->
            <div class="flex justify-end gap-2 pt-4 border-t border-gray-200">
                <flux:button wire:click="$set('showAnularModal', false)" variant="ghost"
                    class="text-gray-600 hover:text-gray-900">
                    Cancelar
                </flux:button>

                <flux:button variant="primary" wire:click="asignar" color="destructive">
                    Asginarme Ticket
                </flux:button>
            </div>
        </div>
    </x-modal>

    <x-modal wire:model="showAnularModal" maxWidth="md">
        <div class="px-6 py-5 space-y-6">
            <!-- Header -->
            <div class="space-y-1">
                <h2 class="text-2xl font-bold text-gray-900">¿Anular Ticket?</h2>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Estás a punto de anular el ticket con ID
                    <span class="font-semibold text-red-600">#{{ $registroId }}</span>.
                    <br>Esta acción no se puede deshacer.
                </p>
            </div>
            <!-- Campo: Motivo -->
            <div class="space-y-1">
                <label for="motivo" class="block text-sm font-medium text-gray-700">
                    Motivo de la anulación <span class="text-red-500">*</span>
                </label>
                <textarea wire:model.defer="motivoAnulacion" id="motivo" rows="4"
                    placeholder="Ej. El cliente canceló la solicitud, error en datos, etc."
                    class="w-full rounded-md border border-gray-300 focus:border-red-500 focus:ring-1 focus:ring-red-500 shadow-sm text-sm resize-none"></textarea>
                @error('motivoAnulacion')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <!-- Botones -->
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                <flux:button wire:click="$set('showAnularModal', false)" variant="ghost" class="text-sm px-4 py-2">
                    Cancelar
                </flux:button>
                <flux:button wire:click="anularRegistro" variant="danger" class="text-sm px-4 py-2">
                    Sí, Anular Ticket
                </flux:button>
            </div>
        </div>
    </x-modal>
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
     $wire.on("notifyError", () =>{
     Swal.fire({
     icon: 'error',
     title: 'Ticket',
     text: 'Error al registrar el ticket',
     });
    }) 
    
    $wire.on("anular", () =>{
     Swal.fire({
     icon: 'success',
     title: 'Ticket',
     text: 'Anulado exitosamente',
     });
    })
</script>
@endscript