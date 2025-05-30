<div>
    <x-modal wire:model="showModal" class="w-full max-w-xl">
        <div class="p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-1">Editar Usuario</h2>
            <p class="text-sm text-gray-500 mb-4">Modifica los datos del usuario seleccionado</p>
            <hr class="mb-6">
            <div class="space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombres</label>
                        <input wire:model="nombres" type="text" placeholder="Ingresa los nombres"
                            class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-black" />
                        @error('nombres') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Apellidos</label>
                        <input wire:model="apellidos" type="text" placeholder="Ingresa los apellidos"
                            class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-black" />
                        @error('apellidos') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email <span
                            class="text-red-500">*</span></label>
                    <input wire:model="email" type="email" placeholder="usuario@ejemplo.com"
                        class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-black" />
                    @error('email') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                    <input wire:model="password" type="password"
                        class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-black" />
                    @error('password') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dirección <span
                            class="text-gray-400 text-xs">(Opcional)</span></label>
                    <input wire:model="direccion" type="text" placeholder="Ingresa la dirección"
                        class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-black" />
                    @error('direccion') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Número celular</label>
                        <input wire:model="celular" type="text" placeholder="+51 999 999 999"
                            class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-black" />
                        @error('celular') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">DNI</label>
                        <input wire:model="dni" type="text" placeholder="12345678"
                            class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-black" />
                        @error('dni') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                </div>

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