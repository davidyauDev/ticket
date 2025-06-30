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
                                        class="absolute text-gray-500 -translate-y-1/2 left-4 top-1/2 dark:text-gray-400"><svg
                                            class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M3.04199 9.37363C3.04199 5.87693 5.87735 3.04199 9.37533 3.04199C12.8733 3.04199 15.7087 5.87693 15.7087 9.37363C15.7087 12.8703 12.8733 15.7053 9.37533 15.7053C5.87735 15.7053 3.04199 12.8703 3.04199 9.37363ZM9.37533 1.54199C5.04926 1.54199 1.54199 5.04817 1.54199 9.37363C1.54199 13.6991 5.04926 17.2053 9.37533 17.2053C11.2676 17.2053 13.0032 16.5344 14.3572 15.4176L17.1773 18.238C17.4702 18.5309 17.945 18.5309 18.2379 18.238C18.5308 17.9451 18.5309 17.4703 18.238 17.1773L15.4182 14.3573C16.5367 13.0033 17.2087 11.2669 17.2087 9.37363C17.2087 5.04817 13.7014 1.54199 9.37533 1.54199Z"
                                                fill=""></path>
                                        </svg></button><input type="text" placeholder="Buscar..."
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
                                            <p class="text-gray-700 text-theme-sm dark:text-gray-400">{{
                                                $log->option->label ?? '' }}
                                            </p>
                                        </td>
                                        <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                                            <p class="text-gray-700 text-theme-sm dark:text-gray-400">{{
                                                $log->description }}</p>
                                        </td>
                                        <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                                            <p class="text-gray-700 text-theme-sm dark:text-gray-400">{{
                                                $log->tecnico->lastname ?? '' }} {{ $log->tecnico->firstname ?? '' }}
                                            </p>
                                        </td>
                                        <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                                            <p class="text-gray-700 text-theme-sm dark:text-gray-400">{{
                                                $log->created_at->format('d/m/Y, H:i:s') }}</p>
                                        </td>
                                        <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                                            @if($log->type === 'Soporte')
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
                                                    class="text-gray-500 hover:text-error-500 dark:text-gray-400 dark:hover:text-error-500"><svg
                                                        class="fill-current" width="21" height="21" viewBox="0 0 21 21"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M7.04142 4.29199C7.04142 3.04935 8.04878 2.04199 9.29142 2.04199H11.7081C12.9507 2.04199 13.9581 3.04935 13.9581 4.29199V4.54199H16.1252H17.166C17.5802 4.54199 17.916 4.87778 17.916 5.29199C17.916 5.70621 17.5802 6.04199 17.166 6.04199H16.8752V8.74687V13.7469V16.7087C16.8752 17.9513 15.8678 18.9587 14.6252 18.9587H6.37516C5.13252 18.9587 4.12516 17.9513 4.12516 16.7087V13.7469V8.74687V6.04199H3.8335C3.41928 6.04199 3.0835 5.70621 3.0835 5.29199C3.0835 4.87778 3.41928 4.54199 3.8335 4.54199H4.87516H7.04142V4.29199ZM15.3752 13.7469V8.74687V6.04199H13.9581H13.2081H7.79142H7.04142H5.62516V8.74687V13.7469V16.7087C5.62516 17.1229 5.96095 17.4587 6.37516 17.4587H14.6252C15.0394 17.4587 15.3752 17.1229 15.3752 16.7087V13.7469ZM8.54142 4.54199H12.4581V4.29199C12.4581 3.87778 12.1223 3.54199 11.7081 3.54199H9.29142C8.87721 3.54199 8.54142 3.87778 8.54142 4.29199V4.54199ZM8.8335 8.50033C9.24771 8.50033 9.5835 8.83611 9.5835 9.25033V14.2503C9.5835 14.6645 9.24771 15.0003 8.8335 15.0003C8.41928 15.0003 8.0835 14.6645 8.0835 14.2503V9.25033C8.0835 8.83611 8.41928 8.50033 8.8335 8.50033ZM12.9168 9.25033C12.9168 8.83611 12.581 8.50033 12.1668 8.50033C11.7526 8.50033 11.4168 8.83611 11.4168 9.25033V14.2503C11.4168 14.6645 11.7526 15.0003 12.1668 15.0003C12.581 15.0003 12.9168 14.6645 12.9168 14.2503V9.25033Z"
                                                            fill=""></path>
                                                    </svg></button><button wire:click="edit({{ $log->id }})"
                                                    class="text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white/90"><svg
                                                        class="fill-current" width="21" height="21" viewBox="0 0 21 21"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M17.0911 3.53206C16.2124 2.65338 14.7878 2.65338 13.9091 3.53206L5.6074 11.8337C5.29899 12.1421 5.08687 12.5335 4.99684 12.9603L4.26177 16.445C4.20943 16.6931 4.286 16.9508 4.46529 17.1301C4.64458 17.3094 4.90232 17.3859 5.15042 17.3336L8.63507 16.5985C9.06184 16.5085 9.45324 16.2964 9.76165 15.988L18.0633 7.68631C18.942 6.80763 18.942 5.38301 18.0633 4.50433L17.0911 3.53206ZM14.9697 4.59272C15.2626 4.29982 15.7375 4.29982 16.0304 4.59272L17.0027 5.56499C17.2956 5.85788 17.2956 6.33276 17.0027 6.62565L16.1043 7.52402L14.0714 5.49109L14.9697 4.59272ZM13.0107 6.55175L6.66806 12.8944C6.56526 12.9972 6.49455 13.1277 6.46454 13.2699L5.96704 15.6283L8.32547 15.1308C8.46772 15.1008 8.59819 15.0301 8.70099 14.9273L15.0436 8.58468L13.0107 6.55175Z"
                                                            fill=""></path>
                                                    </svg></button></div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-4 text-center text-gray-500">No se encontraron
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
                                    Mostrando {{ $callLogs->firstItem() }} a {{ $callLogs->lastItem() }} de {{
                                    $callLogs->total() }}
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
    <x-modal wire:model="showModal" class="w-full">
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