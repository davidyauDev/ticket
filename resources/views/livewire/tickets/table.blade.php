<div>
    <div class="rounded-lg   text-card-foreground  mt-4 p-2">
        <div class="mb-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <flux:input wire:model.live="search" as="text" placeholder="Buscar Ticket por ID" icon="magnifying-glass"
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
            <table class="w-full text-sm text-left border-gray-100">
                <thead class="bg-gray-50 text-gray-700">
                    <tr>
                        <th class="px-3 py-2">ID</th>
                        <th class="px-3 py-2">Código</th>
                        <th class="px-3 py-2">Falla Reportada</th>
                        <th class="px-3 py-2">Tipo</th>
                        <th class="px-3 py-2">Técnico</th>
                        <th class="px-3 py-2">Equipo</th>
                        <th class="px-3 py-2">Agencia</th>
                        <th class="px-3 py-2">Asignado a</th>
                        <th class="px-3 py-2">Creado por</th>
                        <th class="px-3 py-2">Estado</th>
                        <th class="px-3 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800 font-medium">
                    @foreach ($tickets as $ticket)
                    <tr class="border-t">
                        <td class="p-4 align-middle font-medium">
                            <a href="{{ route('tickets.show', $ticket->id) }}" class="text-blue-500 hover:underline">
                                {{ $ticket->id ?? $ticket->id }}
                            </a>
                        </td>
                        <td class="p-4 align-middle font-medium">
                            <a href="{{ route('tickets.show', $ticket->id) }}" class="text-blue-500 hover:underline">
                                {{ $ticket->codigo ?? $ticket->id }}
                            </a>
                        </td>
                        <td class="py-3 px-4">
                            <div x-data="{ open: false }">
                                @if (empty($ticket->falla_reportada))
                                <span class="text-gray-400 italic">Sin información</span>
                                @else
                                <template x-if="!open">
                                    <span class="font-semibold text-gray-800">
                                        {{ \Illuminate\Support\Str::limit($ticket->falla_reportada, 15) }}
                                        @if(strlen($ticket->falla_reportada) > 15)
                                        <a href="#" class="text-blue-600 ml-1 hover:underline text-xs"
                                            @click.prevent="open = true">Ver más</a>
                                        @endif
                                    </span>
                                </template>
                                <template x-if="open">
                                    <span class="font-semibold text-gray-800">
                                        {{ $ticket->falla_reportada }}
                                        <a href="#" class="text-blue-600 ml-1 hover:underline text-xs"
                                            @click.prevent="open = false">Ver menos</a>
                                    </span>
                                </template>
                                @endif
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold 
                        {{ $ticket->tipo === 'ticket' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                {{ ucfirst($ticket->tipo ?? '') }}
                            </span>

                        </td>
                        <td class="py-3 px-4">
                            @if(!$ticket->tecnico_nombres)
                            <span
                                class="inline-flex items-center rounded-full bg-gray-100 text-gray-600 text-xs font-semibold px-3 py-1">No
                                asignado</span>
                            @else
                            {{ $ticket->tecnico_nombres }} {{ $ticket->tecnico_apellidos }}
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            @if(!$ticket->equipo)
                            <span class="text-gray-400 italic flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Sin equipo
                            </span>
                            @else
                            <div x-data="{ open: false }">
                                <template x-if="!open">
                                    <span class="font-semibold text-gray-800">
                                        {{ \Illuminate\Support\Str::limit($ticket->equipo->serie . ' - ' .
                                        $ticket->equipo->modelo, 15) }}
                                        @if(strlen($ticket->equipo->serie . ' - ' . $ticket->equipo->modelo) > 15)
                                        <a href="#" class="text-blue-600 ml-1 hover:underline text-xs"
                                            @click.prevent="open = true">...</a>
                                        @endif
                                    </span>
                                </template>
                                <template x-if="open">
                                    <span class="font-semibold text-gray-800">
                                        {{ $ticket->equipo->serie }} - {{ $ticket->equipo->modelo }}
                                        <a href="#" class="text-blue-600 ml-1 hover:underline text-xs"
                                            @click.prevent="open = false">...</a>
                                    </span>
                                </template>
                            </div>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-gray-400 italic">
                            {{ $ticket->agencia?->nombre ?? 'No especificada' }}
                        </td>
                        <td class="py-3 px-4">
                            @if ($ticket->assignedUser)
                            <div class="flex items-center gap-2 text-gray-800">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="#000000" stroke-width="0.5" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-circle-user-icon lucide-circle-user">
                                    <circle cx="12" cy="12" r="10" />
                                    <circle cx="12" cy="10" r="3" />
                                    <path d="M7 20.662V19a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1.662" />
                                </svg>
                                {{ $ticket->assignedUser->name }}
                            </div>
                            @else
                            <span class="text-blue-600 hover:underline cursor-pointer"
                                wire:click="confirmarAsignac({{ $ticket->id }})">
                                Asignarme
                            </span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            @if ($ticket->createdBy)
                            <div class="flex items-center gap-2 text-gray-800">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="#000000" stroke-width="0.5" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-circle-user-icon lucide-circle-user">
                                    <circle cx="12" cy="12" r="10" />
                                    <circle cx="12" cy="10" r="3" />
                                    <path d="M7 20.662V19a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1.662" />
                                </svg>
                                {{ $ticket->createdBy->name }}
                            </div>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            @php
                            $estado = strtolower($ticket->estado->nombre ?? '');
                            $icono = '';
                            $clases = '';
                            switch ($estado) {
                            case 'pendiente':
                            $icono = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock-icon lucide-clock"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>';
                            $clases = 'bg-yellow-100 text-yellow-700';
                            break;
                            case 'cerrado':
                            $icono = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-icon lucide-check"><path d="M20 6 9 17l-5-5"/></svg>';
                            $clases = 'bg-green-100 text-green-700';
                            break;
                            case 'proceso':
                            $icono = '<svg class="w-4 h-4 mr-1 text-yellow-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>';
                            $clases = 'bg-yellow-100 text-yellow-700';
                            break;
                            case 'anulado':
                            $icono = '<svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 6L6 18M6 6l12 12" />
                            </svg>';
                            $clases = 'bg-gray-100 text-gray-600';
                            break;
                            case 'derivado':
                            $icono = '<svg class="w-4 h-4 mr-1 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 12h14M12 5l7 7-7 7" />
                            </svg>';
                            $clases = 'bg-blue-100 text-blue-700';
                            break;
                            default:
                            $icono = '';
                            $clases = 'bg-neutral-100 text-neutral-700';
                            }
                            @endphp
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $clases }}">
                                {!! $icono !!}
                                {{ ucfirst($ticket->estado->nombre ?? '') }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <flux:dropdown position="bottom" offset="-15">
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom">
                                </flux:button>
                                <flux:menu>
                                    <flux:menu.item icon="trash" wire:click="confirmarAnulacion({{ $ticket->id }})">
                                        Anular Ticket
                                    </flux:menu.item>
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

    <x-modal wire:model="showModal" class="w-full max-w-4xl">
        <div class="p-6">
            <!-- Encabezado -->
            <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2 mb-1">
                <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Crear Nuevo Ticket
            </h2>
            <p class="text-sm text-gray-500 mb-4">Completa los datos para registrar el ticket.</p>
            <hr class="mb-6">
            @if ($errors->any())
            <div class="p-3 mb-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <!-- Formulario -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Columna 1 -->
                <div class="bg-white border rounded-lg shadow p-4 space-y-4">
                    <p class="text-sm font-semibold text-gray-600">Información general</p>
                    <!-- Tipo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                        <flux:select wire:model.live="tipoTicket" placeholder="Seleccionar tipo">
                            <flux:select.option value="ticket">Ticket</flux:select.option>
                            <flux:select.option value="consulta">Consulta</flux:select.option>
                        </flux:select>
                        @error('tipoTicket') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                    @if ($tipoTicket == 'ticket')
                    <!-- Código -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Código del ticket</label>
                        <div class="grid grid-cols-3 gap-2">
                            <input wire:model="codigoInput"
                                class="col-span-2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black"
                                placeholder="Código">
                            <button wire:click="buscarTicket" wire:loading.attr="disabled"
                                class="col-span-1 px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800 flex justify-center items-center gap-1">
                                <span>Buscar</span>
                            </button>
                        </div>
                        @error('codigoInput') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        @error('ticketError') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                    @endif
                    <!-- Datos del ticket -->
                    @if($ticketData)
                    <div class="bg-gray-100 p-3 rounded-lg shadow text-sm text-gray-800">
                        <h3 class="text-base font-semibold mb-2">🎫 Ticket {{ $ticketData['number'] }}</h3>
                        <p><strong>Asunto:</strong> {{ $ticketData['subject'] }}</p>
                        <p><strong>Falla reportada:</strong> {{ $ticketData['falla_reportada'] }}</p>
                        <p><strong>Equipo:</strong> {{ $ticketData['serie'] }} - {{ $ticketData['modelo'] }}</p>
                        <p><strong>Usuario:</strong> {{ $ticketData['nombres'] }} {{ $ticketData['apellidos'] }}</p>
                        <p><strong>Agencia:</strong> {{ $ticketData['agencia'] }}</p>
                        <p><strong>Cliente:</strong> {{ $ticketData['cliente'] }}</p>
                        <p><strong>Empresa:</strong> {{ $ticketData['empresa'] }}</p>
                    </div>
                    @endif
                </div>
                <!-- Columna 2 -->
                <div class="bg-white border rounded-lg shadow p-4 space-y-4">
                    <p class="text-sm font-semibold text-gray-600">Detalles del Ticket</p>
                    <!-- Estado -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                        <flux:select wire:model.live="estado_id" placeholder="Seleccionar estado">
                            @foreach($estados as $estado)
                            <flux:select.option value="{{ $estado->id }}">{{ $estado->nombre }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        @error('estado_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                    @if($estado_id == 2)
                    <!-- Área principal -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Área</label>
                        <flux:select wire:model.live="selectedArea" placeholder="Seleccione un área...">
                            @foreach($areas as $area)
                            <flux:select.option value="{{ $area['id'] }}">{{ $area['nombre'] }}</flux:select.option>
                            @endforeach 
                        </flux:select>
                        @error('selectedArea') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <!-- Subárea (solo si hay área seleccionada) -->
                    @if (!empty($subareas))
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Subárea</label>
                        <flux:select wire:model.live="selectedSubarea" placeholder="Seleccione una subárea...">
                            @foreach($subareas as $sub)
                            <flux:select.option value="{{ $sub['id'] }}">{{ $sub['nombre'] }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        @error('selectedSubarea') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                    @endif
                    @endif
                    <!-- Observación -->
                    @if ($tipoTicket == 'ticket')
                    <div x-data="{
                        open: false,
                        search: '',
                        filtered() {
                            return @js($observaciones).filter(obs =>
                                obs.descripcion.toLowerCase().includes(this.search.toLowerCase())
                            );
                        },
                        select(obs) {
                            this.search = obs.descripcion;
                            this.open = false;
                            $wire.set('observacion', obs.id);
                        }
                    }" class="relative">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Observación</label>

                        <input type="text" x-model="search" @focus="open = true" @click.away="open = false"
                            placeholder="Buscar observación..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black" />
                        <!-- Lista de sugerencias -->
                        <div x-show="open && filtered().length > 0"
                            class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-auto">
                            <template x-for="obs in filtered()" :key="obs.id">
                                <div @click="select(obs)" class="cursor-pointer px-4 py-2 hover:bg-gray-100">
                                    <span x-text="obs.descripcion"></span>
                                </div>
                            </template>
                        </div>
                        @error('observacion') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                    @else
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Observación</label>
                        <textarea wire:model="observacion"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black"
                            placeholder="Escribe una observación..."></textarea>
                        @error('observacion') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                    @endif
                    <!-- Comentario -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Comentario</label>
                        <textarea wire:model="comentario"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black"
                            placeholder="Detalles adicionales..."></textarea>
                        @error('comentario') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex items-center mt-4 space-x-2">
                        <input type="checkbox" id="resuelto" wire:model="resueltoAlCrear"
                            class="form-checkbox h-5 w-5 text-green-600 rounded border-gray-300 focus:ring-green-500" />
                        <label for="resuelto" class="text-sm text-gray-700">
                            Registrar este ticket como resuelto
                        </label>
                    </div>
                    <!-- Archivo adjunto -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Archivo adjunto</label>
                        <label for="archivo"
                            class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-lg cursor-pointer bg-gray-50 border-gray-300 hover:bg-gray-100 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400 mb-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828L18 9.828a4 4 0 10-5.656-5.656l-8.486 8.486a6 6 0 108.486 8.486l7.07-7.07" />
                            </svg>
                            <span class="text-sm text-gray-600 font-medium">Arrastra o haz clic para subir
                                archivo</span>
                            <span class="text-xs text-gray-400">{{ $archivoNombre ?: 'Ningún archivo seleccionado'
                                }}</span>
                            <input id="archivo" type="file" wire:model="archivo" class="hidden" />
                        </label>
                        @error('archivo') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        <div wire:loading wire:target="archivo" class="text-sm text-gray-500 mt-1">Subiendo archivo...
                        </div>
                    </div>
                </div>
            </div>
            <!-- Botones -->
            <div class="flex justify-end gap-2 mt-6">
                <button wire:click="$set('showModal', false)"
                    class="px-5 py-2.5 bg-gray-100 text-gray-800 rounded-md hover:bg-gray-200">
                    Cancelar
                </button>
                <button wire:click="registrarTicket" wire:loading.attr="disabled"
                    class="px-5 py-2.5 bg-black text-white rounded-md hover:bg-gray-900">
                    Registrar Ticket
                </button>
            </div>
        </div>
    </x-modal>

    <x-modal wire:model="showAsigna" class="w-full max-w-md">
        <div class="px-6 py-5">
            <!-- Título -->
            <h2 class="text-xl font-bold text-gray-800 mb-1">Asignación de Ticket</h2>
            <p class="text-sm text-gray-500 mb-4">Confirma si deseas asignarte el ticket pendiente.</p>
            <hr class="mb-4">
            <!-- Detalle del ticket -->
            <div class="bg-gray-50 border rounded-lg p-3 text-sm text-gray-700">
                <p class="mb-1">Estás a punto de asignarte el ticket con:</p>
                <ul class="list-disc list-inside text-sm ml-2">
                    <li><strong>ID:</strong> <span class="text-red-600 font-semibold">#{{ $registroId }}</span></li>
                </ul>
            </div>
            <!-- Acciones -->
            <div class="flex justify-end gap-2 mt-6">
                <button wire:click="$set('showAsigna', false)"
                    class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100">
                    Cancelar
                </button>
                <button wire:click="asignar" class="px-4 py-2 bg-black text-white rounded-md hover:bg-gray-900">
                    Asignarme Ticket
                </button>
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
   $wire.on("notify1", () =>{
        Swal.fire({
        icon: 'success',
        title: 'Ticket',
        text: 'Ticket asignado exitosamente',
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