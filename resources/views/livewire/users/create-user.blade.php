<div>
    <x-app-modal wire:model="showModal" wire:ignore.self class="w-full max-w-xl">
        <div class="p-6 space-y-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Crear Nuevo Usuario</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                Completa la información para registrar un nuevo usuario.
            </p>

            {{-- Grid con 2 columnas --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="col-span-1">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Nombres
                    </label>
                    <input type="text" wire:model.defer="nombres" placeholder="Musharof"
                        class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent 
                                  px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs 
                                  placeholder:text-gray-400 
                                  focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 
                                  dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 
                                  dark:placeholder:text-white/30 dark:focus:border-brand-800">
                    @error('nombres')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-1">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Apellidos
                    </label>
                    <input type="text" wire:model.defer="apellidos" placeholder="Hossain"
                        class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent 
                                  px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs 
                                  placeholder:text-gray-400 
                                  focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 
                                  dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 
                                  dark:placeholder:text-white/30 dark:focus:border-brand-800">
                    @error('apellidos')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Input email --}}
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Email
                </label>
                <input type="email" wire:model.defer="email" placeholder="usuario@ejemplo.com"
                    class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent 
                              px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs 
                              placeholder:text-gray-400 
                              focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 
                              dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 
                              dark:placeholder:text-white/30 dark:focus:border-brand-800">
                @error('email')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            {{-- Input contraseña --}}
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Contraseña
                </label>
                <input type="password" wire:model.defer="password"
                    class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent 
                              px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs 
                              placeholder:text-gray-400 
                              focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 
                              dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 
                              dark:placeholder:text-white/30 dark:focus:border-brand-800">
                @error('password')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            {{-- Input dirección (col-span 2) --}}
            <div class="col-span-2">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Dirección <span class="text-gray-400 text-xs">(Opcional)</span>
                </label>
                <input type="text" wire:model.defer="direccion" placeholder="Av. Siempre Viva 123"
                    class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent 
                              px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs 
                              placeholder:text-gray-400 
                              focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 
                              dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 
                              dark:placeholder:text-white/30 dark:focus:border-brand-800">
                @error('direccion')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
           

            {{-- Select Área --}}
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Área
                </label>
                <select wire:model="areaSeleccionada" wire:change="actualizarSubareas"
                    class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent 
               px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs 
               focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 
               dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:focus:border-brand-800">
                    <option value="" class="text-gray-700 dark:text-white">Seleccione un área</option>
                    @foreach ($areas as $area)
                        <option value="{{ $area->id }}" class="text-gray-700 dark:text-white">
                            {{ $area->nombre }}
                        </option>
                    @endforeach
                </select>

                @error('areaSeleccionada')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            {{-- Select Subárea --}}
            {{-- <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Subárea
                </label>
                <select wire:model="subareaSeleccionada"
                    class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent 
                   px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs 
                   focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 
                   dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 
                   dark:focus:border-brand-800">
                    <option value="">Seleccione una subárea</option>
                    @foreach ($subareas as $subarea)
                        <option value="{{ $subarea->id }}">{{ $subarea->nombre }}</option>
                    @endforeach
                </select>
                @error('subareaSeleccionada')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div> --}}


            {{-- Acciones --}}
            <div class="flex justify-end gap-3 pt-4">
                <button wire:click="$set('showModal', false)"
                    class="px-5 py-2.5 rounded-md bg-gray-100 text-gray-800 hover:bg-gray-200 transition">
                    Cancelar
                </button>
                <button wire:click="crearUsuario" wire:loading.attr="disabled"
                    class="px-5 py-2.5 rounded-md bg-black text-white hover:bg-gray-800 transition">
                    Crear Usuario
                </button>
            </div>
        </div>
    </x-app-modal>
</div>
