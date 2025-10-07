<div class="space-y-6 p-5">
    <livewire:ticket.ticket-list :tipo="$tab" wire:key="tickets-table-{{ $tab }}" />
    <livewire:ticket.ticket-form-modal wire:key="ticket-form-modal" />
</div>
@script
    <script>
        $wire.on("user-saved", () => {
            Swal.fire({
                icon: 'success',
                title: 'Ticket',
                text: 'Ticket registrado exitosamente'
            });
        })
        $wire.on("notify1", () => {
            Swal.fire({
                icon: 'success',
                title: 'Ticket',
                text: 'Ticket asignado exitosamente'
            });
        })
       
        $wire.on("notifyError", () => {
            Swal.fire({
                icon: 'error',
                title: 'Ticket',
                text: 'Error al registrar el ticket'
            });
        })
        $wire.on("anular", () => {
            Swal.fire({
                icon: 'success',
                title: 'Ticket',
                text: 'Anulado exitosamente'
            });
        })
        
    </script>
@endscript
