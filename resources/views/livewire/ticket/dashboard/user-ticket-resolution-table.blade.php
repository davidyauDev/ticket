<div>
    <div
        class="overflow-hidden rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex flex-col gap-5 px-6 mb-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Recent Orders</h3>
            </div>
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <div class="flex gap-2 items-center">
                    <label for="fecha_inicio" class="text-sm text-gray-700 dark:text-gray-300">Desde:</label>
                    <input type="date" id="fecha_inicio" wire:model.lazy="fecha_inicio" class="rounded border-gray-300 dark:bg-gray-900 dark:text-white/90 dark:border-gray-700 px-2 py-1" style="max-width: 140px;">
                    <label for="fecha_fin" class="text-sm text-gray-700 dark:text-gray-300">Hasta:</label>
                    <input type="date" id="fecha_fin" wire:model.lazy="fecha_fin" class="rounded border-gray-300 dark:bg-gray-900 dark:text-white/90 dark:border-gray-700 px-2 py-1" style="max-width: 140px;">
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
                                    <!----></div><span
                                    class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Deal ID</span>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left"><span
                                class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Customer</span></th>
                        <th class="px-6 py-3 text-left"><span
                                class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Subárea</span>
                        </th>
                        <th class="px-6 py-3 text-left"><span
                                class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Asignados</span>
                        </th>
                        <th class="px-6 py-3 text-left"><span
                                class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Resueltos</span>
                        </th>
                        <th class="px-6 py-3 text-left"><span
                                class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Última Fecha Resuelto</span>
                        </th>
                        <th class="px-6 py-3 text-left"><span
                                class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">No Resueltos</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                @forelse($users as $user)
                    <tr class="border-t border-gray-100 dark:border-gray-800">
                        <td class="px-6 py-3.5 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <span class="font-medium text-gray-700 text-theme-sm dark:text-gray-400">{{ $user->id }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-3.5 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-brand-100">
                                    <span class="text-xs font-semibold text-brand-500">{{ $user->initials() }}</span>
                                </div>
                                <div>
                                    <span class="mb-0.5 block text-theme-sm font-medium text-gray-700 dark:text-gray-400">{{ $user->name }}</span>
                                    <span class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $user->email }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-3.5 whitespace-nowrap">
                            <span class="text-gray-700 text-theme-sm dark:text-gray-400">{{ $user->subarea->nombre ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-3.5 whitespace-nowrap">
                            <span class="text-gray-700 text-theme-sm dark:text-gray-400">{{ $user->asignados_count }}</span>
                        </td>
                        <td class="px-6 py-3.5 whitespace-nowrap">
                            <span class="text-gray-700 text-theme-sm dark:text-gray-400">{{ $user->resueltos_count }}</span>
                        </td>
                        <td class="px-6 py-3.5 whitespace-nowrap">
                            <span class="text-gray-700 text-theme-sm dark:text-gray-400">
                                {{ $user->ultima_fecha_resuelto ? \Carbon\Carbon::parse($user->ultima_fecha_resuelto)->format('Y-m-d H:i') : '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-3.5 whitespace-nowrap">
                            <span class="text-gray-700 text-theme-sm dark:text-gray-400">{{ $user->no_resueltos_count }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">No hay usuarios en subáreas con parent_id = 5.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
