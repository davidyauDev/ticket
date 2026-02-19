<div class="space-y-6 p-5">
    <div class="overflow-x-auto">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-6 py-5">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Disponibilidad de agentes</h3>
            </div>
            <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
                <div class="max-w-full overflow-x-auto">
                    <table class="w-full min-w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                    <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">Nombre</p>
                                </th>
                                <th class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                    <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">Email</p>
                                </th>
                                <th class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                    <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">Disponible</p>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $index => $user)
                                <tr>
                                    <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                                        <p class="text-gray-800 text-theme-sm dark:text-white/90">{{ $user['name'] }}</p>
                                    </td>
                                    <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                                        <p class="text-gray-600 text-theme-sm dark:text-gray-400">{{ $user['email'] ?? 'Por definir' }}</p>
                                    </td>
                                    <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                                        <label for="toggle-available-{{ $user['id'] }}"
                                            class="relative inline-flex items-center cursor-pointer select-none">
                                            <input type="checkbox"
                                                id="toggle-available-{{ $user['id'] }}"
                                                class="sr-only peer"
                                                wire:model.live="users.{{ $index }}.available"
                                                wire:change="updateAvailability({{ $user['id'] }}, $event.target.checked)" />
                                            <div class="w-11 h-6 rounded-full bg-gray-400 transition-colors peer-checked:bg-green-600"></div>
                                            <div
                                                class="absolute left-0.5 top-0.5 w-5 h-5 rounded-full bg-white transition-transform duration-200 ease-in-out peer-checked:translate-x-full">
                                            </div>
                                            <span class="ml-3 text-sm {{ $user['available'] ? 'text-green-600' : 'text-gray-500' }}">
                                                {{ $user['available'] ? 'Disponible' : 'No disponible' }}
                                            </span>
                                        </label>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-4 text-center text-gray-500">No se encontraron registros.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@script
    <script>
        $wire.on("availability-updated", () => {
            Swal.fire({
                icon: 'success',
                title: 'Registro',
                text: 'Registro exitoso',
            });
        })
    </script>
@endscript
