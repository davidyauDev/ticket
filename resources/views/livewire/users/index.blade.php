<div>
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-muted-foreground mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h4" />
        </svg>
        <a href="{{ route('dashboard') }}" class="hover:underline text-gray-600">Dashboard</a>
        <span class="text-gray-400">›</span>
        <span class="text-black font-medium">Gestión de Usuarios</span>
    </div>

    <flux:separator variant="subtle" class="my-4" />
    <!-- Título y Acción -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Gestión de Usuarios</h1>
       
    </div>
    {{-- Main Card --}}
    <div class="mt-8">
        <div class="mb-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <flux:input wire:model.live="search" as="text" placeholder="Buscar Usuario..." icon="magnifying-glass"
                class="w-full sm:w-auto" />
            <flux:button wire:click="$dispatch('abrirModalCreacionUsuario')" icon="plus" class="!bg-black !text-white">
                Crear Nuevo Usuario
            </flux:button>
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