<div class="space-y-4 p-2">
    <div class="overflow-x-auto">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-6 py-5">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Gestion de Registros de llamadas de
                    Ticket</h3>
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
                                        <option class="text-gray-500 dark:bg-gray-900 dark:text-gray-400" value="10">10
                                        </option>
                                        <option class="text-gray-500 dark:bg-gray-900 dark:text-gray-400" value="8">8
                                        </option>
                                        <option class="text-gray-500 dark:bg-gray-900 dark:text-gray-400" value="5">5
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
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                                <div class="relative"><button
                                        class="absolute text-gray-500 -translate-y-1/2 left-4 top-1/2 dark:text-gray-400">
                                        <x-icons.search />
                                    </button><input wire:model.live='search' type="text"
                                        placeholder="Buscar..."
                                        class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pl-11 pr-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800 xl:w-[300px]">
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
                                                <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">

                                                    ID</p>
                                            </div>
                                        </div>
                                    </th>
                                    <th class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                        <div class="flex items-center justify-between w-full cursor-pointer">
                                            <div class="flex items-center gap-3">
                                                <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">
                                                    Código</p>
                                            </div>
                                        </div>
                                    </th>
                                    <th class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                        <div class="flex items-center justify-between w-full cursor-pointer">
                                            <div class="flex items-center gap-3">
                                                <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">
                                                    Falla Reportada</p>
                                            </div>
                                        </div>
                                    </th>
                                    <th class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                        <div class="flex items-center justify-between w-full cursor-pointer">
                                            <div class="flex items-center gap-3">
                                                <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">
                                                    Tipo</p>
                                            </div>
                                        </div>
                                    </th>
                                    <th class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                        <div class="flex items-center justify-between w-full cursor-pointer">
                                            <div class="flex items-center gap-3">
                                                <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">
                                                    Técnico</p>
                                            </div>
                                        </div>
                                    </th>
                                    <th class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                        <div class="flex items-center justify-between w-full cursor-pointer">
                                            <div class="flex items-center gap-3">
                                                <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">
                                                    Equipo</p>
                                            </div>
                                        </div>
                                    </th>
                                    <th class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                        <div class="flex items-center justify-between w-full cursor-pointer">
                                            <div class="flex items-center gap-3">
                                                <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">
                                                    Agencia</p>
                                            </div>
                                        </div>
                                    </th>
                                    <th class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                        <div class="flex items-center justify-between w-full cursor-pointer">
                                            <div class="flex items-center gap-3">
                                                <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">
                                                    Asignado a</p>
                                            </div>
                                        </div>
                                    </th>
                                    <th class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                        <div class="flex items-center justify-between w-full cursor-pointer">
                                            <div class="flex items-center gap-3">
                                                <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">
                                                    Creado por</p>
                                            </div>
                                        </div>
                                    </th>
                                    <th class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                        <div class="flex items-center justify-between w-full cursor-pointer">
                                            <div class="flex items-center gap-3">
                                                <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">
                                                    Estado</p>
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
                                                <a href="{{ route('tickets.show', $ticket->id) }}"
                                                    class="text-blue-500 hover:underline">
                                                    {{ $ticket->osticket ?? $ticket->codigo }}
                                                </a>
                                            </p>
                                        </td>
                                        <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                                            <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                                {{ \Illuminate\Support\Str::limit(
                                                    empty($ticket->falla_reportada) ? 'Sin información' : $ticket->falla_reportada,
                                                    30,
                                                ) }}
                                            </p>
                                        </td>
                                        <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                                            <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                                {{ $ticket->tipo ?? '' }}
                                            </p>
                                        </td>
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
                                                    {{ \Illuminate\Support\Str::limit($ticket->equipo->serie . ' - ' . $ticket->equipo->modelo, 15) }}
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
                                                    <span class="text-center">{{ $ticket->assignedUser->name }}</span>
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
