<div class="space-y-6 p-5">
    <div class="overflow-x-auto">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-6 py-5">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Gestion de Llamadas</h3>
                <!---->
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
                                </div><button
                                    class="flex w-full items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-[11px] text-sm font-medium text-gray-700 shadow-theme-xs dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 sm:w-auto">
                                    Download <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M10.0018 14.083C9.7866 14.083 9.59255 13.9924 9.45578 13.8472L5.61586 10.0097C5.32288 9.71688 5.32272 9.242 5.61552 8.94902C5.90832 8.65603 6.3832 8.65588 6.67618 8.94868L9.25182 11.5227L9.25182 3.33301C9.25182 2.91879 9.5876 2.58301 10.0018 2.58301C10.416 2.58301 10.7518 2.91879 10.7518 3.33301L10.7518 11.5193L13.3242 8.94866C13.6172 8.65587 14.0921 8.65604 14.3849 8.94903C14.6777 9.24203 14.6775 9.7169 14.3845 10.0097L10.5761 13.8154C10.4385 13.979 10.2323 14.083 10.0018 14.083ZM4.0835 13.333C4.0835 12.9188 3.74771 12.583 3.3335 12.583C2.91928 12.583 2.5835 12.9188 2.5835 13.333V15.1663C2.5835 16.409 3.59086 17.4163 4.8335 17.4163H15.1676C16.4102 17.4163 17.4176 16.409 17.4176 15.1663V13.333C17.4176 12.9188 17.0818 12.583 16.6676 12.583C16.2533 12.583 15.9176 12.9188 15.9176 13.333V15.1663C15.9176 15.5806 15.5818 15.9163 15.1676 15.9163H4.8335C4.41928 15.9163 4.0835 15.5806 4.0835 15.1663V13.333Z"
                                            fill=""></path>
                                    </svg></button>
                                <button wire:click="create"
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
                                                        Usuario</p>
                                                </div>
                                            </div>
                                        </th>
                                        <th class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                            <div class="flex items-center justify-between w-full cursor-pointer">
                                                <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">
                                                    Motivo</p>
                                            </div>
                                        </th>
                                        <th class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                            <div class="flex items-center justify-between w-full cursor-pointer">
                                                <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">
                                                    Consulta</p>
                                            </div>
                                        </th>
                                        <th class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                            <div class="flex items-center justify-between w-full cursor-pointer">
                                                <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">
                                                    Técnico</p>
                                            </div>
                                        </th>
                                        <th class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                            <div class="flex items-center justify-between w-full cursor-pointer">
                                                <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">
                                                    Fecha y Hora</p>
                                            </div>
                                        </th>
                                        <th class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                            <div class="flex items-center justify-between w-full cursor-pointer">
                                                <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">
                                                    Tipo</p>
                                            </div>
                                        </th>
                                        <th class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                                            <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">
                                                Action</p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($callLogs as $log)
                                    <tr class="">
                                        <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                                            <div class="flex gap-3">
                                                <div>
                                                    <p
                                                        class="block font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                                        {{ $log->user->name }}</p><span
                                                        class="text-sm text-gray-500 dark:text-gray-400">demoemail@gmail.com</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                                            <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                                {{ $log->option->label ?? '' }}
                                            </p>
                                        </td>
                                        <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                                            <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                                {{ $log->description }}</p>
                                        </td>
                                        <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                                            <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                                {{ $log->tecnico->lastname ?? '' }}
                                                {{ $log->tecnico->firstname ?? '' }}
                                            </p>
                                        </td>
                                        <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                                            <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                                {{ $log->created_at->format('d/m/Y, H:i:s') }}</p>
                                        </td>
                                        <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                                            @if ($log->type === 'Soporte')
                                            <span
                                                class="bg-blue-50 dark:bg-blue-500/15 text-blue-700 dark:text-blue-500 rounded-full px-2 py-0.5 text-theme-xs font-medium">
                                                Soporte
                                            </span>
                                            @elseif($log->type === 'Consulta')
                                            <span
                                                class="bg-yellow-50 dark:bg-yellow-500/15 text-yellow-700 dark:text-yellow-500 rounded-full px-2 py-0.5 text-theme-xs font-medium">
                                                Consulta
                                            </span>
                                            @elseif($log->type === 'Reclamo')
                                            <span
                                                class="bg-red-50 dark:bg-red-500/15 text-red-700 dark:text-red-500 rounded-full px-2 py-0.5 text-theme-xs font-medium">
                                                Reclamo
                                            </span>
                                            @else
                                            <span
                                                class="bg-gray-200 text-gray-700 rounded-full px-2 py-0.5 text-theme-xs font-medium">
                                                N/A
                                            </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                                            <div class="flex items-center w-full gap-2"><button
                                                    wire:click="delete({{ $log->id }})"
                                                    class="text-gray-500 hover:text-error-500 dark:text-gray-400 dark:hover:text-error-500">
                                                    <x-icons.edit />
                                                </button><button wire:click="edit({{ $log->id }})"
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
                                    Mostrando {{ $callLogs->firstItem() }} a {{ $callLogs->lastItem() }} de
                                    {{ $callLogs->total() }}
                                    registros </p>
                                {{ $callLogs->links('vendor.livewire.custom-tailwind') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <x-modal wire:model="showModal" class="w-full max-w-lg mx-auto">
        <div class="bg-white rounded-lg p-6 w-full space-y-4">
            <h3 class="text-lg font-semibold">Registrar Nueva Llamada</h3>
            <!-- Tipo -->
            <div>
                <label class="block text-sm font-medium mb-1">Tipo de Llamada</label>
                <select wire:model.defer="form.type"
                    class="w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-black">
                    <option value="Consulta">Consulta</option>
                    <option value="Reclamo">Reclamo</option>
                    <option value="Soporte">Soporte</option>
                </select>
            </div>
            <!-- Tipo -->
            <div>
                <label class="block text-sm font-medium mb-1">Motivo</label>
                <select wire:model.defer="form.option_id"
                    class="w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-black">
                    <option value="">Seleccione un motivo</option>
                    @foreach ($seguimientoOpciones as $opcion)
                    <option value="{{ $opcion->id }}">{{ $opcion->label }}</option>
                    @endforeach
                </select>
                @error('form.option_id')
                <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>


            <!-- Técnico con búsqueda -->
            <div class="relative w-full">
                <label class="block text-sm font-medium text-gray-700 mb-1">Técnico</label>

                <input type="text" wire:model.live="searchTecnico" placeholder="Buscar técnico..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black" />

                @if (!empty($tecnicoList))
                <div
                    class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-auto">
                    @foreach ($tecnicoList as $user)
                    <div wire:click="selectTecnico({{ $user['id'] }})"
                        class="px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm">
                        {{ $user['lastname'] }} {{ $user['firstname'] }}
                    </div>
                    @endforeach
                </div>
                @endif

                @error('form.tecnico_id')
                <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <!-- Descripción -->
            <div>
                <label class="block text-sm font-medium mb-1">Detalle de la Consulta</label>
                <textarea wire:model.defer="form.description"
                    class="w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-black"
                    rows="3"></textarea>
                @error('form.description')
                <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Acciones -->
            <div class="flex justify-end gap-3 pt-4">
                <button wire:click="$set('showModal', false)"
                    class="px-5 py-2.5 rounded-md bg-gray-100 text-gray-800 hover:bg-gray-200 transition">
                    Cancelar
                </button>
                <button wire:click="store" wire:loading.attr="disabled"
                    class="px-5 py-2.5 rounded-md bg-black text-white hover:bg-gray-800 transition">
                    Guardar
                </button>
            </div>
        </div>
    </x-modal>
</div>

@script
<script>
    $wire.on("saved", () => {
            Swal.fire({
                icon: 'success',
                title: 'Llamada',
                text: 'Registrado exitosamente'
            });
        });

        Livewire.on('reset-tecnico', () => {});
</script>
@endscript