<div>
    <div class="flex items-center gap-2 text-sm text-muted-foreground mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h4" />
        </svg>
        <a href="{{ route('dashboard') }}" class="hover:underline text-sm text-gray-600">Dashboard</a>
        <span class="text-gray-400">›</span>
        <span class="text-sm text-black font-medium">Gestión de Usuarios</span>
    </div>
    <flux:separator variant="subtle" class="my-4" />
    <div class="grid gap-4 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm border-l-4 border-l-green-500">
            <div
                class="p-6 flex flex-col md:flex-row items-start md:items-center justify-between pb-2 space-y-2 md:space-y-0">
                <h3 class="tracking-tight text-sm font-medium text-muted-foreground">Cantidad de Usuarios</h3>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-users w-6 h-6 text-green-500">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <div class="p-6 pt-0">
                <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-2 sm:space-y-0 sm:space-x-2">
                    <div class="text-2xl font-bold">550</div>
                    <span class="text-xs font-medium text-green-500 bg-green-100 px-2 py-0.5 rounded-full">+12% este
                        mes</span>
                </div>
                <p class="text-xs text-muted-foreground mt-2">171 usuarios registrados en total</p>
            </div>
        </div>
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm border-l-4 border-l-purple-500">
            <div
                class="p-6 flex flex-col md:flex-row items-start md:items-center justify-between pb-2 space-y-2 md:space-y-0">
                <h3 class="tracking-tight text-sm font-medium text-muted-foreground">Usuarios Online</h3>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-user-check w-6 h-6 text-purple-500">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <polyline points="16 11 18 13 22 9"></polyline>
                </svg>
            </div>
            <div class="p-6 pt-0">
                <div class="flex items-center space-x-2">
                    <div class="text-2xl font-bold">428</div>
                    <span class="text-xs font-medium text-purple-500 bg-purple-100 px-2 py-0.5 rounded-full">78%
                        activos</span>
                </div>
                <div class="w-full h-1.5 bg-gray-100 rounded-full mt-3">
                    <div class="h-1.5 bg-purple-500 rounded-full" style="width: 78%;"></div>
                </div>
            </div>
        </div>
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
            <div
                class="p-6 flex flex-col md:flex-row items-start md:items-center justify-between pb-2 space-y-2 md:space-y-0">
                <h3 class="tracking-tight text-sm font-medium text-muted-foreground">Nuevos Usuarios</h3>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-trending-up w-6 h-6 text-blue-500">
                    <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
                    <polyline points="16 7 22 7 22 13"></polyline>
                </svg>
            </div>
            <div class="p-6 pt-0">
                <div class="text-2xl font-bold">24</div>
                <p class="text-xs text-muted-foreground mt-2">Registrados en las últimas 24 horas</p>
            </div>
        </div>
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
            <div
                class="p-6 flex flex-col md:flex-row items-start md:items-center justify-between pb-2 space-y-2 md:space-y-0">
                <h3 class="tracking-tight text-sm font-medium text-muted-foreground">Actividad</h3>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-activity w-6 h-6 text-orange-500">
                    <path
                        d="M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36a.25.25 0 0 1-.48 0L9.24 2.18a.25.25 0 0 0-.48 0l-2.35 8.36A2 2 0 0 1 4.49 12H2">
                    </path>
                </svg>
            </div>
            <div class="p-6 pt-0">
                <div class="text-2xl font-bold">87%</div>
                <p class="text-xs text-muted-foreground mt-2">Tasa de retención de usuarios</p>
            </div>
        </div>
    </div>
    <div class="rounded-lg  bg-card text-card-foreground  mt-4 p-5">
        <div class="mb-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <flux:input wire:model.live="search" as="text" placeholder="Buscar Usuario..." icon="magnifying-glass"
                class="w-full sm:w-auto" />
            <flux:button wire:click="openModal" icon="plus" class="bg-black text-white">
                Crear Nuevo Usuario
            </flux:button>
        </div>
        <div class="mt-4 border rounded-md overflow-x-auto">
            <table class="w-full min-w-[600px]">
                <thead>
                    <tr class="border-b bg-muted/50">
                        <th class="py-3 px-4 text-left text-sm font-medium text-muted-foreground">Nombres</th>
                        <th class="py-3 px-4 text-left text-sm font-medium text-muted-foreground">Correo</th>
                        <th class="py-3 px-4 text-left text-sm font-medium text-muted-foreground">Apellidos</th>
                        <th class="py-3 px-4 text-left text-sm font-medium text-muted-foreground">DNI</th>
                        <th class="py-3 px-4 text-left text-sm font-medium text-muted-foreground">Fecha de Creación</th>
                        <th class="py-3 px-4 text-left text-sm font-medium text-muted-foreground">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr class="border-b ">
                        <td class="py-3 px-4 text-sm">{{ $user->name }}</td>
                        <td class="py-3 px-4 text-sm">{{ $user->email }}</td>
                        <td class="py-3 px-4 text-sm">{{ $user->lastname }}</td>
                        <td class="py-3 px-4 text-sm">{{ $user->dni }}</td>
                        <td class="py-3 px-4 text-sm">{{ $user->created_at }}</td>
                        <td class="py-3 px-4">
                            <flux:dropdown position="bottom" offset="-15">
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom">
                                </flux:button>
                                <flux:menu>
                                    <flux:modal.trigger name="edit-profile">
                                        <flux:menu.item wire:click="editarUsuario({{$user->id}})" icon="user">Editar
                                            Usuario</flux:menu.item>
                                    </flux:modal.trigger>
                                    <flux:menu.item icon="trash">Eliminar Usuario</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
        <div class="mt-5 flex flex-col sm:flex-row justify-between items-start sm:items-center ml-2">
            <div class="text-sm opacity-50 mb-2 sm:mb-0">
                Mostrando {{ $users->firstItem() }} a {{ $users->lastItem() }} de {{ $users->total() }} usuarios
            </div>
            <div class="inline-flex rounded-md px-4 py-2">
                {{ $users->links('vendor.livewire.custom-tailwind') }}
            </div>
        </div>
    </div>

    {{--
    <livewire:user-form /> --}}

    <x-modal wire:model="showModal" class="w-full max-w-xl">

        <div class="p-6">
            <!-- Encabezado -->
            <h2 class="text-xl font-bold text-gray-800 mb-1">Crear Nuevo Usuario</h2>
            <p class="text-sm text-gray-500 mb-4">Completa la información para crear un nuevo usuario en el sistema</p>
            <hr class="mb-6">

            @if ($errors->any())
            <div class="p-3 mb-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombres</label>
                        <input wire:model="nombres" type="text" placeholder="Ingresa los nombres"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black">
                        @error('nombres') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Apellidos</label>
                        <input wire:model="apellidos" type="text" placeholder="Ingresa los apellidos"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black">
                        @error('apellidos') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email <span
                            class="text-red-500">*</span></label>
                    <input wire:model="email" type="email" placeholder="usuario@ejemplo.com"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black">
                    @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                    <input wire:model="password" type="password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black">
                    @error('password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dirección <span
                            class="text-gray-400 text-xs">(Opcional)</span></label>
                    <input wire:model="direccion" type="text" placeholder="Ingresa la dirección"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black">
                    @error('direccion') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Número celular</label>
                        <input wire:model="celular" type="text" placeholder="+51 999 999 999"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black">
                        @error('celular') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">DNI</label>
                        <input wire:model="dni" type="text" placeholder="12345678"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black">
                        @error('dni') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <button wire:click="$set('showModal', false)"
                        class="px-5 py-2.5 bg-gray-100 text-gray-800 rounded-md hover:bg-gray-200">
                        Cancelar
                    </button>
                    <button wire:click="crearUsuario" wire:loading.attr="disabled"
                        class="px-5 py-2.5 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Crear Usuario
                    </button>
                </div>
            </div>
        </div>
    </x-modal>

</div>