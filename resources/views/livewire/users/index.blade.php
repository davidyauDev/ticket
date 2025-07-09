<div class="p-5 space-x-6">
    {{-- Breadcrumb --}}
    <!-- Título y Acción -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Gestión de Usuarios</h1>
    </div>
    {{-- Main Card --}}
    <div class="mt-8">
        <div class="mb-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="relative w-full sm:w-auto">
                <input type="text" wire:model.live="search" placeholder="Buscar Usuario..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-auto" />
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" /></svg>
                </span>
            </div>
            <button wire:click="$dispatch('abrirModalCreacionUsuario')" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white shadow hover:bg-blue-700 transition">
                Crear Nuevo Usuario
                <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M9.2502 4.99951C9.2502 4.5853 9.58599 4.24951 10.0002 4.24951C10.4144 4.24951 10.7502 4.5853 10.7502 4.99951V9.24971H15.0006C15.4148 9.24971 15.7506 9.5855 15.7506 9.99971C15.7506 10.4139 15.4148 10.7497 15.0006 10.7497H10.7502V15.0001C10.7502 15.4143 10.4144 15.7501 10.0002 15.7501C9.58599 15.7501 9.2502 15.4143 9.2502 15.0001V10.7497H5C4.58579 10.7497 4.25 10.4139 4.25 9.99971C4.25 9.5855 4.58579 9.24971 5 9.24971H9.2502V4.99951Z" fill=""></path></svg>
            </button>
        </div>
        {{-- Table --}}
        <div class="mt-6 border rounded-md overflow-x-auto">
            <table class="w-full min-w-[600px] text-sm">
                <thead class="bg-muted/50 text-muted-foreground font-medium text-left">
                    <tr class="[&>th]:py-3 [&>th]:px-4 border-b">
                        <th>Nombres</th>
                        <th>Correo</th>
                        <th>Apellidos</th>
                        <th>DNI</th>
                        <th>Fecha de Creación</th>
                        <th>Áreas y Subárea</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr class="border-b">
                        <td class="py-3 px-4">{{ $user->name }}</td>
                        <td class="py-3 px-4">{{ $user->email }}</td>
                        <td class="py-3 px-4">{{ $user->lastname }}</td>
                        <td class="py-3 px-4">{{ $user->dni }}</td>
                        <td class="py-3 px-4">{{ $user->created_at }}</td>
                        <td class="py-3 px-4">
                                 <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">
                                    {{ $user->area->parent->nombre ?? 'Por definir' }}</span>
                                </span> -
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">
                                    {{ $user->area->nombre ?? 'Por definir' }}</span>
                                </span>
                        </td>
                        <td class="py-3 px-4">
                            <flux:dropdown position="bottom" offset="-15">
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom" />
                                <flux:menu>
                                    <flux:menu.item wire:click="$dispatch('editarUsuario', { id: {{ $user->id }} })"
                                        icon="user">
                                        Editar Usuario
                                    </flux:menu.item>
                                    <flux:menu.item icon="trash">Eliminar Usuario</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- Pagination --}}
        <div class="mt-5 flex flex-col sm:flex-row justify-between items-start sm:items-center ml-2 text-sm opacity-70">
            <div class="mb-2 sm:mb-0">
                Mostrando {{ $users->firstItem() }} a {{ $users->lastItem() }} de {{ $users->total() }} usuarios
            </div>
            <div class="inline-flex rounded-md px-4 py-2">
                {{ $users->links('vendor.livewire.custom-tailwind') }}
            </div>
        </div>
    </div>
    <livewire:users.create-user wire:key="modal-create-user" />
    <livewire:users.edit-user wire:key="modal-edit-user" />
</div>

@script
<script>
    $wire.on("user-saved", () =>{
        Swal.fire({
        icon: 'success',
        title: 'Usuario',
        text: 'Usuario registrado exitosamente',
        });
   })

   $wire.on("user-updated", () =>{
       Swal.fire({
           icon: 'success',
           title: 'Usuario',
           text: 'Usuario actualizado exitosamente',
       });
   })

</script>
@endscript