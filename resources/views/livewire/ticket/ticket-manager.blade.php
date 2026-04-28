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

        $wire.on("Errorwsp", () => {
            Swal.fire({
                icon: 'success',
                title: 'Ticket',
                text: 'Error en el envío automático. Por favor, escriba por WhatsApp de manera manual. Ignore este mensaje si el envío se realizó automáticamente.',
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#3085d6'
            });
        });

        $wire.on("whatsapp-fallback", (event) => {
            const url = event?.url ?? event?.detail?.url ?? null;

            if (url) {
                window.open(url, '_blank', 'noopener');
            }

            Swal.fire({
                icon: 'warning',
                title: 'WhatsApp API no disponible',
                text: 'Se abrió WhatsApp Web con el mensaje listo para enviar.',
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#3085d6'
            });
        });
    </script>
@endscript
