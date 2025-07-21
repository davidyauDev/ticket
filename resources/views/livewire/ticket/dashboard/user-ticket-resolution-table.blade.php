<div>
    <div
        class="overflow-hidden rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex flex-col gap-5 px-6 mb-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Ingenieros</h3>
            </div>
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <div class="flex gap-2 items-center">
                    <label for="fecha_inicio" class="text-sm text-gray-700 dark:text-gray-300">Desde:</label>
                    <input type="date" id="fecha_inicio" wire:model.lazy="fecha_inicio"
                        class="rounded border-gray-300 dark:bg-gray-900 dark:text-white/90 dark:border-gray-700 px-2 py-1"
                        style="max-width: 140px;">
                    <label for="fecha_fin" class="text-sm text-gray-700 dark:text-gray-300">Hasta:</label>
                    <input type="date" id="fecha_fin" wire:model.lazy="fecha_fin"
                        class="rounded border-gray-300 dark:bg-gray-900 dark:text-white/90 dark:border-gray-700 px-2 py-1"
                        style="max-width: 140px;">
                </div>
            </div>
        </div>
        <div class="min-w-full overflow-x-auto custom-scrollbar">
            <table class="min-w-full">
                <thead>
                    <tr class="border-t border-gray-100 bg-gray-50 dark:border-gray-800 dark:bg-gray-900">
                        <th class="px-6 py-3 text-left">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex h-5 w-5 cursor-pointer items-center justify-center rounded-md border-[1.25px] bg-white dark:bg-white/0 border-gray-300 dark:border-gray-700">
                                    <!---->
                                </div><span class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Usuario
                                    ID</span>
                            </div>
                        </th>

                        <th class="px-6 py-3 text-left"><span
                                class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Usuario</span>
                        </th>
                        <th class="px-6 py-3 text-left"><span
                                class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Correo</span>
                        </th>
                        <th class="px-6 py-3 text-left"><span
                                class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Asignados</span>
                        </th>
                        <th class="px-6 py-3 text-left"><span
                                class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Resueltos</span>
                        </th>


                        <th class="px-6 py-3 text-left"><span
                                class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Ver Detalle</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr wire:key="user-{{ $user['id'] }}">
                            <td class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                {{ $user['id'] }}</td>
                            <td class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                {{ $user['name'] }}</td>
                            <td class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                {{ $user['email'] }}</td>
                            <td class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                {{ $user['subarea'] }}</td>
                            <td class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                {{ $user['asignados_count'] }}</td>
                            <td class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                {{ $user['resueltos_count'] }}</td>
                            <td class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                {{ $user['ultima_fecha_resuelto'] ?? '-' }}</td>
                            <td class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                <button wire:click="showUnresolvedTickets({{ $user['id'] }})"
                                    class="text-blue-600 underline">Ver Detalle</button>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">No hay usuarios en subáreas con parent_id = 5.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div>
        <x-modal wire:model="showModal" class="w-full max-w-4xl">
            <div class="bg-white rounded-xl w-full p-5 space-y-6">
                <h2 class="text-lg font-semibold text-gray-800">Detalle de Registros Llamadas de Tickets</h2>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-gray-600">
                        <thead class="bg-gray-100 text-xs font-semibold text-gray-700">
                            <tr>
                                <th class="px-4 py-2">ID</th>
                                <th class="px-4 py-2">Código</th>
                                <th class="px-4 py-2">Fecha Asignación</th>
                                <th class="px-4 py-2">Estado</th>
                                <th class="px-4 py-2">¿Resuelto por él?</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($unresolvedTickets as $ticket)
                                <tr class="border-b">
                                    <td class="px-4 py-2">
                                        <a href="{{ route('tickets.show', $ticket['id']) }}"
                                            class="text-blue-500 hover:underline">
                                            {{ $ticket['id'] }}
                                        </a>
                                    </td>


                                    <td class="px-4 py-2">{{ $ticket['codigo'] }}</td>
                                    <td class="px-4 py-2">{{ $ticket['fecha_asignacion'] }}</td>
                                    <td class="px-4 py-2">{{ $ticket['estado'] }}</td>
                                    <td class="px-4 py-2">
                                        @if ($ticket['resuelto_por'] === 'Sí')
                                            <span class="text-green-600 font-semibold">Sí</span>
                                        @elseif($ticket['resuelto_por'] === 'Otro')
                                            <span class="text-yellow-600 font-semibold">Otro</span>
                                        @else
                                            <span class="text-gray-500">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-gray-500">No hay tickets asignados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-end mt-6">
                    <button wire:click="closeModal" class="mr-2 px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                        Cerrar
                    </button>
                </div>
            </div>
        </x-modal>

    </div>

</div>
