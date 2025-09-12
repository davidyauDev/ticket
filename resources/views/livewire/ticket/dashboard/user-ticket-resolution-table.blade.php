<div>
    <!-- Filtro por usuario -->
    <div
        class="overflow-hidden rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex flex-col gap-5 px-6 mb-4 sm:flex-row sm:items-center sm:justify-between">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Ingenieros</h3>

            <!-- Buscador -->
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <div class="relative"><button
                        class="absolute text-gray-500 -translate-y-1/2 left-4 top-1/2 dark:text-gray-400">
                        <x-icons.search />
                    </button><input wire:model.live='search' type="text" placeholder="Buscar Usuario..."
                        class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pl-11 pr-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800 xl:w-[300px]">
                </div>

            </div>
        </div>

        <!-- Tabla de usuarios -->
        <div class="min-w-full overflow-x-auto custom-scrollbar">
            <table class="min-w-full text-sm text-left">
                <thead>
                    <tr class="border-t border-gray-100 bg-gray-50 dark:border-gray-800 dark:bg-gray-900">
                        <th class="px-6 py-3">Usuario ID</th>
                        <th class="px-6 py-3">Usuario</th>
                        <th class="px-6 py-3">Correo</th>
                        <th class="px-6 py-3">Asignados</th>
                        <th class="px-6 py-3">Resueltos</th>
                        <th class="px-6 py-3">Última resolución</th>
                        <th class="px-6 py-3">Ver Detalle</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr wire:key="user-{{ $user['id'] }}">
                            <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">{{ $user['id'] }}</td>
                            <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">{{ $user['name'] }}</td>
                            <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">{{ $user['email'] }}</td>
                            <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                                {{ $user['asignados_count'] }}</td>
                            <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                                {{ $user['resueltos_count'] }}</td>
                            <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                                {{ $user['ultima_fecha_resuelto'] ?? '-' }}</td>
                            <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                                <button wire:click="openModal({{ $user['id'] }})"
                                    class="text-blue-600 hover:text-blue-800 underline">
                                    Ver Detalle
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-gray-500">
                                No hay usuarios que coincidan con la búsqueda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal igual que antes -->
    @if ($showModal)
        <x-modal wire:model="showModal" class="w-full max-w-4xl">
            <div class="bg-white rounded-xl w-full p-5 space-y-6">
                <h2 class="text-lg font-semibold text-gray-800">Detalle de Registros de Llamadas de Tickets</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-gray-600">
                        <thead class="bg-gray-100 text-xs font-semibold text-gray-700">
                            <tr>
                                <th class="px-4 py-2">Código</th>
                                <th class="px-4 py-2">Fecha Asignación</th>
                                <th class="px-4 py-2">Estado</th>
                                <th class="px-4 py-2">¿Resuelto por él?</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($this->unresolvedTickets as $ticket)
                                <tr class="border-b">  <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
    <p class="text-gray-700 text-theme-sm dark:text-gray-400">
        <a href="{{ route('tickets.show', $ticket['id']) }}"
           class="text-blue-500 hover:underline">
            TCK-{{ str_pad($ticket['id'], 11, '0', STR_PAD_LEFT) }}
        </a>
    </p>
</td>
                                    
                                    <td class="px-4 py-2">{{ $ticket['fecha_asignacion'] }}</td>
                                    <td class="px-4 py-2">{{ $ticket['estado'] }}</td>
                                    <td class="px-4 py-2">
                                        @if ($ticket['resuelto_por'] === 'Sí')
                                            <span class="text-green-600 font-semibold">Sí</span>
                                        @elseif($ticket['resuelto_por'] === 'Otro')
                                            <span class="text-yellow-600 font-semibold">Otro</span>
                                        @else
                                            <span class="text-gray-500">Pendiente por Resolver</span>
                                        @endif
                                    </td>
                            </tr> @empty <tr>
                                    <td colspan="5" class="text-center py-4 text-gray-500"> No hay tickets asignados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4"> {{ $this->unresolvedTickets->links() }} </div>
                <div class="flex justify-end mt-6"> <button wire:click="closeModal"
                        class="mr-2 px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 transition"> Cerrar </button> </div>
            </div>
        </x-modal>
    @endif
</div>
