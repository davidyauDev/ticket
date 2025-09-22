<div class="space-y-6 p-5">
    <div class="overflow-x-auto">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-6 py-5">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Gestion de Usuarios</h3>
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
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                                <div class="relative"><button
                                        class="absolute text-gray-500 -translate-y-1/2 left-4 top-1/2 dark:text-gray-400">
                                        <x-icons.search />
                                    </button><input wire:model.live='search' type="text" placeholder="Buscar..."
                                        class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pl-11 pr-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800 xl:w-[300px]">
                                </div>
                                <button wire:click="$dispatch('abrirModalCreacionUsuario')"
                                    class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">Nuevo
                                    Registro <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M9.2502 4.99951C9.2502 4.5853 9.58599 4.24951 10.0002 4.24951C10.4144 4.24951 10.7502 4.5853 10.7502 4.99951V9.24971H15.0006C15.4148 9.24971 15.7506 9.5855 15.7506 9.99971C15.7506 10.4139 15.4148 10.7497 15.0006 10.7497H10.7502V15.0001C10.7502 15.4143 10.4144 15.7501 10.0002 15.7501C9.58599 15.7501 9.2502 15.4143 9.2502 15.0001V10.7497H5C4.58579 10.7497 4.25 10.4139 4.25 9.99971C4.25 9.5855 4.58579 9.24971 5 9.24971H9.2502V4.99951Z"
                                            fill=""></path>
                                    </svg></button>
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
                                                        Nombre(s)</p>
                                                </div>
                                            </div>
                                        </th>


                                        <th class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                            <div class="flex items-center justify-between w-full cursor-pointer">
                                                <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">
                                                    DNI</p>
                                            </div>
                                        </th>
                                         <th class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                            <div class="flex items-center justify-between w-full cursor-pointer">
                                                <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">
                                                    Celular</p>
                                            </div>
                                        </th>
                                        <th class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                            <div class="flex items-center justify-between w-full cursor-pointer">
                                                <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">
                                                    Fecha de creación</p>
                                            </div>
                                        </th>
                                        <th class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                            <div class="flex items-center justify-between w-full cursor-pointer">
                                                <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">
                                                    Área</p>
                                            </div>
                                        </th>
                                        <th class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                            <div class="flex items-center justify-between w-full cursor-pointer">
                                                <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">
                                                    Acciones </p>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                        <tr>
                                            <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                                                <div class="flex gap-3">
                                                    <div>
                                                        <p
                                                            class="block font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                                            {{ $user->name }}</p><span
                                                            class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                                                <div class="flex gap-3">
                                                    <div>
                                                        {{ $user->dni ?? 'Por definir' }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                                                <div class="flex gap-3">
                                                    <div>
                                                        {{ $user->phone ?? 'Por definir' }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                                                <div class="flex gap-3">
                                                    <div>
                                                        {{ $user->created_at }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                                                <div class="flex gap-3">
                                                    <div>
                                                        <span
                                                            class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">
                                                            {{ $user->area->nombre ?? 'Por definir' }}</span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                                                <div class="flex items-center w-full gap-2"><button
                                                        wire:click="$dispatch('editarUsuario', { id: {{ $user->id }} })"
                                                        class="text-gray-500 hover:text-error-500 dark:text-gray-400 dark:hover:text-error-500">
                                                        <x-icons.edit />
                                                    </button><button
                                                        class="text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white/90">
                                                        <x-icons.delete />
                                                    </button></div>
                                            </td>
                                        </tr>

                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-4 py-4 text-center text-gray-500">No se
                                                encontraron
                                                registros.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                         <div
                            class="border border-t-0 rounded-b-xl border-gray-100 py-4 pl-[18px] pr-4 dark:border-gray-800">
                            <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between">
                                <p
                                    class="pb-3 text-sm font-medium text-center text-gray-500 border-b border-gray-100 dark:border-gray-800 dark:text-gray-400 xl:border-b-0 xl:pb-0 xl:text-left">
                                    Mostrando {{ $users->firstItem() }} a {{ $users->lastItem() }} de
                                    {{ $users->total() }}
                                    registros </p>
                                {{ $users->links('vendor.livewire.custom-tailwind') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <livewire:users.create-user wire:key="modal-create-user" />
    <livewire:users.edit-user wire:key="modal-edit-user" />
</div>

@script
    <script>
        $wire.on("user-saved", () => {
            Swal.fire({
                icon: 'success',
                title: 'Usuario',
                text: 'Usuario registrado exitosamente',
            });
        })

        $wire.on("user-updated", () => {
            Swal.fire({
                icon: 'success',
                title: 'Usuario',
                text: 'Usuario actualizado exitosamente',
            });
        })
    </script>
@endscript
