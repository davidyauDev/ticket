<div class="space-y-4 p-2">
    <div class="overflow-x-auto">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-4 px-6 py-5">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                    Gestión de Registros de llamadas de Ticket
                </h3>
                @if (auth()->user()?->area_id == 1 || auth()->user()->role == 'admin')
                    <button wire:click="$dispatch('abrirModalCreacionTicket')"
                        class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">
                        Nuevo ticket por llamada
                        <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M9.2502 4.99951C9.2502 4.5853 9.58599 4.24951 10.0002 4.24951C10.4144 4.24951 10.7502 4.5853 10.7502 4.99951V9.24971H15.0006C15.4148 9.24971 15.7506 9.5855 15.7506 9.99971C15.7506 10.4139 15.4148 10.7497 15.0006 10.7497H10.7502V15.0001C10.7502 15.4143 10.4144 15.7501 10.0002 15.7501C9.58599 15.7501 9.2502 15.4143 9.2502 15.0001V10.7497H5C4.58579 10.7497 4.25 10.4139 4.25 9.99971C4.25 9.5855 4.58579 9.24971 5 9.24971H9.2502V4.99951Z"
                                fill=""></path>
                        </svg>
                    </button>
                @endif
            </div>
            <div>
            </div>
            <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
                <div class="space-y-5">
                    <div class="overflow-hidden">
                        <div
                            class="flex flex-col gap-2 px-4 py-4 border border-b-0 border-gray-200 rounded-b-none rounded-xl dark:border-gray-800 sm:flex-row sm:items-center sm:justify-between">
                            <div class="flex items-center gap-3"><span
                                    class="text-gray-500 dark:text-gray-400">Mostrar</span>
                                <div class="relative z-20 bg-transparent"><select wire:model.live="perPage"
                                        class="w-full py-2 pl-3 pr-8 text-sm text-gray-800 bg-transparent border border-gray-300 rounded-lg appearance-none dark:bg-dark-900 h-9 bg-none shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800 text-gray-500 dark:text-gray-400">
                                        <option class="text-gray-500 dark:bg-gray-900 dark:text-gray-400"
                                            value="10">10
                                        </option>
                                        <option class="text-gray-500 dark:bg-gray-900 dark:text-gray-400"
                                            value="8">8
                                        </option>
                                        <option class="text-gray-500 dark:bg-gray-900 dark:text-gray-400"
                                            value="5">5
                                        </option>
                                    </select><span
                                        class="absolute z-30 text-gray-500 -translate-y-1/2 pointer-events-none right-2 top-1/2 dark:text-gray-400"><svg
                                            class="stroke-current" width="16" height="16" viewBox="0 0 16 16"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3.8335 5.9165L8.00016 10.0832L12.1668 5.9165" stroke=""
                                                stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                        </svg></span></div><span
                                    class="text-gray-500 dark:text-gray-400">registros</span>
                            </div>

                            <div class="flex gap-3.5">
                                <div
                                    class="hidden h-11 items-center gap-0.5 rounded-lg bg-gray-100 p-0.5 lg:inline-flex dark:bg-gray-900">
                                    <button wire:click="$set('filterType', '')"
                                        class="shadow-theme-xs text-theme-sm h-10 rounded-md px-3 py-2 font-medium transition-colors"
                                        style="@if (empty($filterType)) background-color:#3b82f6;color:white;@else background-color:white;color:#6b7280; @endif">Todos</button>
                                    <button wire:click="$set('filterType', 'solved')"
                                        class="text-theme-sm h-10 rounded-md px-3 py-2 font-medium transition-colors"
                                        style="@if ($filterType === 'solved') background-color:#3b82f6;color:white;@else background-color:white;color:#6b7280; @endif">Solucionados</button>
                                    <button wire:click="$set('filterType', 'pending')"
                                        class="text-theme-sm h-10 rounded-md px-3 py-2 font-medium transition-colors"
                                        style="@if ($filterType === 'pending') background-color:#3b82f6;color:white;@else background-color:white;color:#6b7280; @endif">En
                                        Proceso</button>
                                    <button wire:click="$set('filterType', 'paused')"
                                        class="text-theme-sm h-10 rounded-md px-3 py-2 font-medium transition-colors"
                                        style="@if ($filterType === 'paused') background-color:#3b82f6;color:white;@else background-color:white;color:#6b7280; @endif">Pausados</button>
                                        <button wire:click="$set('filterType', 'anuled')"
                                        class="text-theme-sm h-10 rounded-md px-3 py-2 font-medium transition-colors"
                                        style="@if ($filterType === 'anuled') background-color:#3b82f6;color:white;@else background-color:white;color:#6b7280; @endif">Anulados</button>
                                </div>
                                <div class="hidden flex-col gap-3 sm:flex sm:flex-row sm:items-center">
                                    <div class="relative"><span
                                            class="absolute top-1/2 left-4 -translate-y-1/2 text-gray-500 dark:text-gray-400"><svg
                                                class="fill-current" width="20" height="20" viewBox="0 0 20 20"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M3.04199 9.37363C3.04199 5.87693 5.87735 3.04199 9.37533 3.04199C12.8733 3.04199 15.7087 5.87693 15.7087 9.37363C15.7087 12.8703 12.8733 15.7053 9.37533 15.7053C5.87735 15.7053 3.04199 12.8703 3.04199 9.37363ZM9.37533 1.54199C5.04926 1.54199 1.54199 5.04817 1.54199 9.37363C1.54199 13.6991 5.04926 17.2053 9.37533 17.2053C11.2676 17.2053 13.0032 16.5344 14.3572 15.4176L17.1773 18.238C17.4702 18.5309 17.945 18.5309 18.2379 18.238C18.5308 17.9451 18.5309 17.4703 18.238 17.1773L15.4182 14.3573C16.5367 13.0033 17.2087 11.2669 17.2087 9.37363C17.2087 5.04817 13.7014 1.54199 9.37533 1.54199Z"
                                                    fill=""></path>
                                            </svg></span><input type="text" placeholder="Search..."
                                            wire:model.live="search"
                                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pr-4 pl-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden xl:w-[300px] dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="max-w-full overflow-x-auto">
                            <table class="w-full min-w-full">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                            <div class="flex items-center justify-between w-full cursor-pointer">
                                                <div class="flex items-center gap-3">
                                                    <p
                                                        class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">

                                                        ID</p>
                                                </div>
                                            </div>
                                        </th>
                                        <th class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                            <div class="flex items-center justify-between w-full cursor-pointer">
                                                <div class="flex items-center gap-3">
                                                    <p
                                                        class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">
                                                        Código</p>
                                                </div>
                                            </div>
                                        </th>
                                        {{-- <th
                                            class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                            <div class="flex items-center justify-between w-full cursor-pointer">
                                                <div class="flex items-center gap-3">
                                                    <p
                                                        class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">
                                                        Falla Reportada</p>
                                                </div>
                                            </div>
                                        </th> --}}
                                        {{-- <th
                                            class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                            <div class="flex items-center justify-between w-full cursor-pointer">
                                                <div class="flex items-center gap-3">
                                                    <p
                                                        class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">
                                                        Tipo</p>
                                                </div>
                                            </div>
                                        </th> --}}
                                        <th class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                            <div class="flex items-center justify-between w-full cursor-pointer">
                                                <div class="flex items-center gap-3">
                                                    <p
                                                        class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">
                                                        Técnico</p>
                                                </div>
                                            </div>
                                        </th>
                                        <th class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                            <div class="flex items-center justify-between w-full cursor-pointer">
                                                <div class="flex items-center gap-3">
                                                    <p
                                                        class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">
                                                        Equipo</p>
                                                </div>
                                            </div>
                                        </th>
                                        <th class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                            <div class="flex items-center justify-between w-full cursor-pointer">
                                                <div class="flex items-center gap-3">
                                                    <p
                                                        class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">
                                                        Agencia</p>
                                                </div>
                                            </div>
                                        </th>
                                        <th class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                            <div class="flex items-center justify-between w-full cursor-pointer">
                                                <div class="flex items-center gap-3">
                                                    <p
                                                        class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">
                                                        Asignado a</p>
                                                </div>
                                            </div>
                                        </th>
                                        <th class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                            <div class="flex items-center justify-between w-full cursor-pointer">
                                                <div class="flex items-center gap-3">
                                                    <p
                                                        class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">
                                                        Creado por</p>
                                                </div>
                                            </div>
                                        </th>
                                        <th class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                            <div class="flex items-center justify-between w-full cursor-pointer">
                                                <div class="flex items-center gap-3">
                                                    <p
                                                        class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">
                                                        Estado</p>
                                                </div>
                                            </div>
                                        </th>
                                        <th class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                            <div class="flex items-center justify-between w-full cursor-pointer">
                                                <div class="flex items-center gap-3">
                                                    <p
                                                        class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">
                                                        Acciones</p>
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($tickets as $ticket)
                                        <tr>
                                            <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                                                <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                                    <a href="{{ route('tickets.show', $ticket->id) }}"
                                                        class="text-blue-500 hover:underline">
                                                        {{ $ticket->codigo_formateado }}
                                                    </a>
                                                </p>
                                            </td>
                                            <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                                                <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                                    @if ($ticket->osticket)
                                                        <a href="http://161.132.75.22/scp/tickets.php?a=search&search-type=typeahead&query={{ $ticket->osticket }}&number={{ $ticket->osticket }}"
                                                            target="_blank" class="text-blue-500 hover:underline">
                                                            {{ $ticket->osticket }}
                                                        </a>
                                                    @else
                                                        <a href="{{ route('tickets.show', $ticket->id) }}"
                                                            class="text-blue-500 hover:underline">
                                                            {{ $ticket->codigo }}
                                                        </a>
                                                    @endif
                                                </p>
                                            </td>
                                            {{-- <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                                            <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                                {{ \Illuminate\Support\Str::limit(
                                                empty($ticket->falla_reportada) ? 'Sin información' :
                                                $ticket->falla_reportada,
                                                30,
                                                ) }}
                                            </p>
                                        </td> --}}
                                            {{-- <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                                            <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                                {{ $ticket->tipo ?? '' }}
                                            </p>
                                        </td> --}}
                                            <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                                                <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                                    {{ $ticket->tecnico_nombres
                                                        ? $ticket->tecnico_nombres . ' ' . $ticket->tecnico_apellidos
                                                        : 'No
                                                                                                    asignado' }}
                                                </p>
                                            </td>
                                            <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                                                <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                                    @if ($ticket->equipo)
                                                        <a href="http://161.132.75.22/system/busqueda_equipo?equipo={{ $ticket->equipo->id_equipo }}"
                                                            target="_blank" class="text-blue-500 hover:underline">
                                                            {{ \Illuminate\Support\Str::limit($ticket->equipo->serie . ' - ' . $ticket->equipo->modelo, 15) }}
                                                        </a>
                                                    @else
                                                        Sin equipo
                                                    @endif
                                                </p>
                                            </td>
                                            <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                                                <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                                    {{ $ticket->agencia->nombre ?? 'No especificada' }}
                                                </p>
                                            </td>
                                            <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                                                <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                                    @if ($ticket->assignedUser)
                                                        <span
                                                            class="text-center">{{ $ticket->assignedUser->name }}</span>
                                                    @else
                                                        <a href="#"
                                                            wire:click="$dispatch('asignarUsuario', { id: {{ $ticket->id }} })"
                                                            class="text-blue-600 hover:underline font-medium">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="lucide lucide-user-plus-icon lucide-user-plus">
                                                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                                                <circle cx="9" cy="7" r="4" />
                                                                <line x1="19" x2="19" y1="8"
                                                                    y2="14" />
                                                                <line x1="22" x2="16" y1="11"
                                                                    y2="11" />
                                                            </svg>
                                                        </a>
                                                    @endif
                                                </p>
                                            </td>
                                            <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">

                                                <div class="flex flex-col gap-1 text-gray-800">
                                                    <div class="flex items-center gap-2">
                                                        {{ $ticket->createdBy->name ?? 'N/A' }}
                                                    </div>
                                                    <span class="text-sm text-gray-500">
                                                        {{ $ticket->created_at?->format('d/m/Y H:i') ?? 'Sin fecha' }}
                                                    </span>
                                                </div>
                                            </td>
                                            @php
                                                $estado = strtolower($ticket->estado->nombre ?? 'sin estado');
                                                $estadoClass = match ($estado) {
                                                    'pendiente' => 'bg-green-100 text-green-700', // Ahora verde
                                                    'cerrado' => 'bg-red-100 text-red-700',
                                                    'derivado' => 'bg-blue-100 text-blue-800',
                                                    'anulado' => 'bg-red-100 text-red-700',
                                                    default => 'bg-gray-100 text-gray-600',
                                                };
                                            @endphp
                                            <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $estadoClass }}">
                                                    {{ $estado === 'pendiente' ? 'En proceso' : ucfirst($ticket->estado->nombre ?? 'Sin estado') }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
    <div class="flex items-center gap-2">

        @if (auth()->user()->role === 'admin')
            <button
                wire:key="anular-ticket-{{ $ticket->id }}"
                wire:click="confirmarAnulacion({{ $ticket->id }})"
                class="text-red-500 hover:text-red-700 disabled:opacity-50 disabled:cursor-not-allowed"
                title="{{ $ticket->estado_id == 4 ? 'Ya está anulado' : 'Anular Ticket' }}"
                @disabled($ticket->estado_id == 4)
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>
            </button>
        @endif

    </div>
</td>


                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div
                            class="border border-t-0 rounded-b-xl border-gray-100 py-4 pl-[18px] pr-4 dark:border-gray-800">
                            <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between">
                                <p
                                    class="pb-3 text-sm font-medium text-center text-gray-500 border-b border-gray-100 dark:border-gray-800 dark:text-gray-400 xl:border-b-0 xl:pb-0 xl:text-left">
                                    Mostrando {{ $tickets->firstItem() }} a {{ $tickets->lastItem() }} de
                                    {{ $tickets->total() }}
                                    registros </p>
                                {{ $tickets->links('vendor.livewire.custom-tailwind') }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <livewire:ticket.ticket-asig-modal wire:key="ticket-asig-modal" />
</div>
@script
<script>
document.addEventListener('livewire:navigated', () => {
    Livewire.on('mostrarSwalAnulacion', (data) => {
        Swal.fire({
            title: '¿Anular este ticket?',
            text: 'Por favor, agrega un comentario sobre la anulación.',
            icon: 'warning',
            input: 'textarea',
            inputPlaceholder: 'Escribe aquí tu comentario...',
            showCancelButton: true,
            confirmButtonText: 'Sí, anular',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6b7280',
            preConfirm: (comentario) => {
                if (!comentario) {
                    Swal.showValidationMessage('Debes ingresar un comentario antes de continuar.');
                    return false;
                }
                return comentario;
            }
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                Livewire.dispatch('anularTicketConComentario', { id: data.id, comentario: result.value });
            }
        });
    });
});
</script>

@endscript
