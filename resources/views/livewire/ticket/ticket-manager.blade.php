<div class="space-y-6">
    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-sm text-muted-foreground">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h4" />
        </svg>
        <a href="{{ route('dashboard') }}" class="hover:underline text-gray-600">Dashboard</a>
        <span class="text-gray-400">›</span>
        <span class="text-black font-medium">Gestión de Tickets</span>
    </div>

    <!-- Título y Acción -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Gestión de Tickets</h1>
       @if(auth()->user()?->area?->parent_id === 1)
    <flux:button icon="plus" class="bg-black" variant="primary" wire:click="$dispatch('abrirModalCreacionTicket')">
        Crear Nuevo Ticket
    </flux:button>
@else
    <span class="text-sm ">
        Solo las áreas bajo <strong>Mesa de Ayuda</strong> pueden crear tickets.
    </span>
@endif

    </div>

    <!-- Estadísticas -->
    {{-- <div class=" grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="p-4 rounded-lg bg-white border ">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-600">Total Tickets</p>
                    <x-icon name="ticket" class="w-5 h-5 text-blue-500" />
                </div>
                <p class="text-2xl font-semibold text-gray-800 mt-2">{{ $total }}</p>
            </div>
            <div class="p-4 rounded-lg bg-white border ">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-600">Pendientes</p>
                    <x-icon name="clock" class="w-5 h-5 text-yellow-500" />
                </div>
                <p class="text-2xl font-semibold text-gray-800 mt-2">{{ $pendientes }}</p>
            </div>
            <div class="p-4 rounded-lg bg-white border ">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-600">En Proceso</p>
                    <x-icon name="chart-bar" class="w-5 h-5 text-purple-500" />
                </div>
                <p class="text-2xl font-semibold text-gray-800 mt-2">{{ $enProceso }}</p>
            </div>
            <div class="p-4 rounded-lg bg-white border ">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-600">Derivados</p>
                    <x-icon name="users" class="w-5 h-5 text-orange-500" />
                </div>
                <p class="text-2xl font-semibold text-gray-800 mt-2">{{ $derivados }}</p>
            </div>
    </div> --}}
    <!-- Tabs y Búsqueda -->
    <!-- Tabs y Búsqueda agrupados visualmente -->
    <div class="p-4 mt-4 border rounded-xl bg-white ">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <!-- Tabs -->
            <div class="flex bg-gray-100 p-1 rounded-lg">
                <button wire:click="switchTab('mis')" @class([ 'px-4 py-1.5 text-sm font-medium rounded-md'
                    , 'bg-black text-white'=> $tab === 'mis',
                    'text-gray-700 hover:bg-gray-200' => $tab !== 'mis',
                    ])>
                    Mis Tickets
                </button>
                <button wire:click="switchTab('todos')" @class([ 'px-4 py-1.5 text-sm font-medium rounded-md'
                    , 'bg-black text-white'=> $tab === 'todos',
                    'text-gray-700 hover:bg-gray-200' => $tab !== 'todos',
                    ])>
                    Todos del Área
                </button>
            </div>

            <!-- Buscador + Filtro -->
            <div class="flex gap-2 items-center w-full md:w-auto">
                {{--
                <flux:input wire:model.live="search" as="text" placeholder="Buscar por ID, técnico, equipo..."
                    icon="magnifying-glass" class="w-full md:w-72" /> --}}
                <flux:button variant="outline" icon="users">
                    Filtros
                </flux:button>
            </div>
        </div>
    </div>

    <!-- Tabla y Modal -->
    <livewire:ticket.ticket-list :tipo="$tab" wire:key="tickets-table-{{ $tab }}" />
    <livewire:ticket.ticket-form-modal wire:key="ticket-form-modal" />

</div>
@script
<script>
    $wire.on("user-saved", () => {
        Swal.fire({ icon: 'success', title: 'Ticket', text: 'Ticket registrado exitosamente' });
    })
    $wire.on("notify1", () => {
        Swal.fire({ icon: 'success', title: 'Ticket', text: 'Ticket asignado exitosamente' });
    })
    $wire.on("notifyError", () => {
        Swal.fire({ icon: 'error', title: 'Ticket', text: 'Error al registrar el ticket' });
    })
    $wire.on("anular", () => {
        Swal.fire({ icon: 'success', title: 'Ticket', text: 'Anulado exitosamente' });
    })
</script>
@endscript