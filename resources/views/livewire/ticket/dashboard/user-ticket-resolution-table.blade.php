<div
    class="bg-white dark:bg-gray-900/70 border border-gray-200 dark:border-gray-800 rounded-3xl p-6 shadow-sm hover:shadow-lg transition-all duration-300 ease-in-out flex flex-col justify-between h-full">

    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <div
                class="w-9 h-9 flex items-center justify-center rounded-full bg-gradient-to-r from-blue-500 to-indigo-500 shadow-sm text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 14c-4.418 0-8 1.79-8 4v2h16v-2c0-2.21-3.582-4-8-4zM12 12a4 4 0 100-8 4 4 0 000 8z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white tracking-tight">
                Ingenieros
            </h3>
        </div>

        <div class="relative w-full max-w-[260px]">
            <input wire:model.live='search' type="text" placeholder="Buscar ingeniero..."
                class="w-full h-10 pl-10 pr-4 rounded-xl text-sm text-gray-700 dark:text-gray-200 border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/60 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-400 placeholder-gray-400 dark:placeholder-gray-500 transition-all duration-200" />
            <svg xmlns="http://www.w3.org/2000/svg"
                class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500 dark:text-gray-400" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z" />
            </svg>
        </div>
    </div>

    <div class="overflow-x-auto rounded-2xl border border-gray-100 dark:border-gray-800 shadow-inner">
        <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-300">
            <thead
                class="bg-gray-50 dark:bg-gray-800/60 text-gray-600 dark:text-gray-400 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Usuario</th>
                    <th class="px-6 py-3">Correo</th>
                    <th class="px-6 py-3 text-center">Asignados</th>
                    <th class="px-6 py-3 text-center">Resueltos</th>
                    <th class="px-6 py-3 text-center">Última resolución</th>
                    <th class="px-6 py-3 text-center">Detalle</th>
                </tr>
            </thead>
            <tbody>
                @forelse($this->users as $user)
                    <tr
                        class="hover:bg-blue-50/50 dark:hover:bg-gray-800/50 transition-colors duration-150 border-t border-gray-100 dark:border-gray-800">
                        <td class="px-6 py-3 font-medium text-gray-600 dark:text-gray-300">
                            #{{ $user['id'] }}
                        </td>
                        <td class="px-6 py-3 font-medium">{{ $user['name'] }}</td>
                        <td class="px-6 py-3 text-gray-500">{{ $user['email'] }}</td>
                        <td class="px-6 py-3 text-center font-semibold text-blue-600">
                            {{ $user['asignados_count'] }}
                        </td>
                        <td class="px-6 py-3 text-center font-semibold text-green-600">
                            {{ $user['resueltos_count'] }}
                        </td>
                        <td class="px-6 py-3 text-center text-sm text-gray-500">
                            {{ $user['ultima_fecha_resuelto'] ?? '-' }}
                        </td>
                        <td class="px-6 py-3 text-center">
                            <button wire:click="openModal({{ $user['id'] }})"
                                class="inline-flex items-center px-3 py-1 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 dark:bg-blue-900/30 dark:hover:bg-blue-900/50 transition-all duration-200">
                                Ver
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-6 text-gray-500 dark:text-gray-400">
                            No hay ingenieros que coincidan con la búsqueda.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación para la tabla principal -->
    <div class="mt-6">
        {{ $this->users->links() }}
    </div>

    @if ($showModal)
        <x-modal wire:model="showModal" class="w-full max-w-4xl">
            <div class=" dark:bg-gray-900 rounded-2xl  p-3 space-y-6">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">

                    Detalle de Tickets —
                    <span class="text-blue-600 dark:text-blue-400 font-bold">
                        {{ $selectedUserName }}
                    </span>
                </h2>


                <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-2">Código</th>
                                <th class="px-4 py-2">Modelo</th>
                                <th class="px-4 py-2">Fecha Asignación</th>
                                <th class="px-4 py-2">Estado</th>
                                <th class="px-4 py-2">¿Resuelto por él?</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($this->unresolvedTickets as $ticket)
                                <tr
                                    class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/60 transition-colors">
                                    <td class="px-4 py-2">
                                        <a href="{{ route('tickets.show', $ticket['id']) }}"
                                            class="text-blue-600 hover:underline font-medium">
                                            TCK-{{ str_pad($ticket['id'], 6, '0', STR_PAD_LEFT) }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-2 text-gray-600 dark:text-gray-400">
                                        {{ $ticket['modelo'] }}
                                    </td>
                                    <td class="px-4 py-2 text-gray-600 dark:text-gray-400">
                                        {{ $ticket['fecha_asignacion'] }}
                                    </td>
                                    <td class="px-4 py-2">
                                        <span
                                            class="px-2 py-1 rounded-md text-xs font-medium
                                            @if ($ticket['estado'] === 'Cerrado') bg-green-100 text-green-700
                                            @elseif($ticket['estado'] === 'Pendiente') bg-yellow-100 text-yellow-700
                                            @else bg-gray-100 text-gray-600 @endif">
                                            {{ $ticket['estado'] }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2">
                                        @if ($ticket['resuelto_por'] === 'Sí')
                                            <span class="text-green-600 font-semibold">Sí</span>
                                        @elseif($ticket['resuelto_por'] === 'Pendiente por Resolver')
                                            <span class="text-gray-400 italic">Pendiente</span>
                                        @else
                                            <span
                                                class="text-yellow-600 font-semibold">{{ $ticket['resuelto_por'] }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-gray-500 dark:text-gray-400">
                                        No hay tickets asignados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $this->unresolvedTickets->links() }}
                </div>

                <div class="flex justify-end pt-4">
                    <button wire:click="closeModal"
                        class="px-4 py-2 bg-gray-200 dark:bg-gray-800 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-700 transition">
                        Cerrar
                    </button>
                </div>
            </div>
        </x-modal>
    @endif
</div>
