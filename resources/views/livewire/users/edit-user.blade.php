<div>
    <x-modal wire:model="showModal" wire:ignore.self class="w-full max-w-xl">
        <div class="p-6 space-y-6">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-1">Editar Usuario</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                Modifica los datos del usuario seleccionado
            </p>
            <hr class="mb-6">

            <div class="space-y-5">
                {{-- Nombres y Apellidos --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombres</label>
                        <input wire:model.defer="nombres" type="text" placeholder="Ingresa los nombres"
                            class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-black" />
                        @error('nombres')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Apellidos</label>
                        <input wire:model.defer="apellidos" type="text" placeholder="Ingresa los apellidos"
                            class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-black" />
                        @error('apellidos')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input wire:model.defer="email" type="email" placeholder="usuario@ejemplo.com"
                        class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-black" />
                    @error('email')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Contraseña --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                    <input wire:model.defer="password" type="password"
                        class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-black" />
                    @error('password')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Dirección --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Dirección <span class="text-gray-400 text-xs">(Opcional)</span>
                    </label>
                    <input wire:model.defer="direccion" type="text" placeholder="Ingresa la dirección"
                        class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-black" />
                    @error('direccion')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Celular y DNI --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Número celular</label>
                        <input wire:model.defer="phone" type="text" placeholder="+51 999 999 999"
                            class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-black" />
                        @error('phone')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">DNI</label>
                        <input wire:model.defer="dni" type="text" placeholder="12345678"
                            class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-black" />
                        @error('dni')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Área y Subárea --}}
                <div ">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Área</label>
                        <select wire:model="areaSeleccionada" 
                            class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-black">
                            <option value="">Selecciona un área</option>
                            @foreach ($areas as $area)
                                <option value="{{ $area->id }}">{{ $area->nombre }}</option>
                            @endforeach
                        </select>
                        @error('areaSeleccionada')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                   
                </div>

                {{-- Switch Supervisor --}}
                <div class="flex items-center space-x-3">
                    <label for="toggle-supervisor-edit" class="relative inline-flex items-center cursor-pointer select-none">
                        <input type="checkbox" id="toggle-supervisor-edit" class="sr-only peer" wire:model="esSupervisor" />
                        <div class="w-11 h-6 rounded-full bg-gray-400 transition-colors peer-checked:bg-blue-600"></div>
                        <div class="absolute left-0.5 top-0.5 w-5 h-5 rounded-full bg-white transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></div>
                        <span class="ml-3 text-sm text-gray-800 dark:text-white transition-colors peer-checked:text-green-600">
                            Supervisor
                        </span>
                    </label>
                </div>

                {{-- Botones --}}
                <div class="flex justify-end gap-3 pt-4">
                    <button wire:click="$set('showModal', false)"
                        class="px-5 py-2.5 rounded-md bg-gray-100 text-gray-800 hover:bg-gray-200 transition">
                        Cancelar
                    </button>
                    <button wire:click="actualizarUsuario" wire:loading.attr="disabled"
                        class="px-5 py-2.5 rounded-md bg-black text-white hover:bg-gray-800 transition">
                        Actualizar Usuario
                    </button>
                </div>
            </div>
        </div>
    </x-modal>
</div>
