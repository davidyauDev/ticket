<div>
    <flux:modal name="edit-profile" class="md:w-250" wire:model="showModal">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $message }}</flux:heading>
            </div>
            <form wire:submit.prevent="save" class="space-y-6">
                <div class="grid grid-cols-2 gap-4">
                    <flux:input label="Nombres" placeholder="Nombres" wire:model="name" />
                    <flux:error name="name" />

                    <flux:input label="Apellidos" placeholder="Apellidos" wire:model="lastname" />
                    <flux:error name="lastname" />
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <flux:field placeholder="email">
                        <flux:label badge="Requerido">Email</flux:label>
                        <flux:input type="email" required wire:model="email" />
                        <flux:error name="email" />
                    </flux:field>
                    <flux:input type="password" label="Password" wire:model="password" placeholder="********" />
                    <flux:error name="password" />
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <flux:input label="Direccion" badge="Opcional" placeholder="Direccion" wire:model="direccion" class="flex-1" />
                    <flux:input label="Numero celular" placeholder="Numero celular" wire:model="phone" class="flex-1" />
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <flux:input label="DNI" placeholder="DNI" wire:model="dni" type='number' />
                    <flux:error name="dni" />
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <flux:spacer />
                    <flux:button type="submit" variant="primary">Guardar Cambios</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('user-saved', function () {
            Swal.fire({
                title: '¡Registro exitoso!',
                text: 'El usuario ha sido guardado correctamente.',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        });

        Livewire.on('errorRegistro', function (message) {
            Swal.fire({
                title: 'Error',
                text: message,
                icon: 'error',
                confirmButtonText: 'Cerrar'
            });
        });
    });
</script>