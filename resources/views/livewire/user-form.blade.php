<div>
    <flux:modal name="edit-profile" class="md:w-250" wire:model="showModal">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Registrar Usuarios</flux:heading>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <flux:input label="First name" placeholder="River" wire:model="name" />

                <flux:input label="Last name" placeholder="Porzio" />
            </div>
            <div class="grid grid-cols-2 gap-4">
                <flux:field placeholder="email">
                    <flux:label badge="Required">Email</flux:label>
                    <flux:input type="email" required wire:model="email" />
                    <flux:error name="email" />
                </flux:field>
                <flux:input type="password" label="Password" wire:model="password" />
            </div>S
            <div class="grid grid-cols-2 gap-4">
                <flux:input label="Direccion" badge="Optional" placeholder="Your direccion" class="flex-1" />
                <flux:input label="Phone" placeholder="Your phone" class="flex-1" />
            </div>
            <div class="grid grid-cols-2 gap-4">
                <flux:spacer />
                <flux:button type="submit" variant="primary" wire:click="save">Guardar Cambios</flux:button>
            </div>
        </div>
    </flux:modal>
</div>

<script>
    window.addEventListener('user-saved', () => {
        alert('¡Usuario guardado correctamente!');
    });
</script>



