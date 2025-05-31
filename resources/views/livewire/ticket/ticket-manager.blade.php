<div>
    <div class="flex items-center gap-2 text-sm text-muted-foreground mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h4" />
        </svg>
        <a href="{{ route('dashboard') }}" class="hover:underline text-gray-600">Dashboard</a>
        <span class="text-gray-400">›</span>
        <span class="text-black font-medium">Gestión de Tickets</span>
    </div>
    <flux:separator variant="subtle" class="my-4" />
    <div class="mb-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <flux:input wire:model.live="search" as="text" placeholder="Buscar Ticket por ID" icon="magnifying-glass"
        class="w-full sm:w-auto" />
    
    <flux:button icon="plus" class="w-full sm:w-auto bg-black" variant="primary"
        wire:click="$dispatch('abrirModalCreacionTicket')">
        Crear Nuevo Ticket
    </flux:button>
</div>
    <!-- Tabs -->
    <div class="flex items-center space-x-2 mb-4 bg-gray-100 p-2 rounded-lg w-fit">
        <button wire:click="switchTab('mis')"
            @class([ 'flex items-center px-3 py-1.5 text-sm font-medium rounded-md transition' , 'bg-black text-white'=>
            $tab === 'mis',
            'text-gray-700 hover:bg-gray-200' => $tab !== 'mis',
            ])>
            Mis Tickets
        </button>

        
        <button wire:click="switchTab('todos')"
            @class([ 'flex items-center px-3 py-1.5 text-sm font-medium rounded-md transition' , 'bg-black text-white'=>
            $tab === 'todos',
            'text-gray-700 hover:bg-gray-200' => $tab !== 'todos',
            ])>
            Todos del Área
        </button>
    </div>
    <livewire:ticket.ticket-list :tipo="$tab"  wire:key="tickets-table-{{ $tab }}"/>
    <livewire:ticket.ticket-form-modal  wire:key="ticket-form-modal" />
</div>

@script
<script>
    $wire.on("user-saved", () =>{
        Swal.fire({
        icon: 'success',
        title: 'Ticket',
        text: 'Ticket registrado exitosamente',
        });
   })
   $wire.on("notify1", () =>{
        Swal.fire({
        icon: 'success',
        title: 'Ticket',
        text: 'Ticket asignado exitosamente',
        });
   })
   $wire.on("notifyError", () =>{
     Swal.fire({
     icon: 'error',
     title: 'Ticket',
     text: 'Error al registrar el ticket',
     });
    }) 
    
    $wire.on("anular", () =>{
     Swal.fire({
     icon: 'success',
     title: 'Ticket',
     text: 'Anulado exitosamente',
     });
    })
</script>
@endscript