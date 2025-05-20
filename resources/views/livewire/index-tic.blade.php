<div>
    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-sm text-muted-foreground mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h4" />
        </svg>

        <a href="{{ route('dashboard') }}" class="hover:underline text-sm text-gray-600">Dashboard</a>
        <span class="text-gray-400">›</span>
        <span class="text-sm text-black font-medium">Gestión de Tickets</span>
    </div>

    <div class="bg-white  rounded-xl border p-4">


        <div class="p-4">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold mb-1">Sistema de Tickets</h1>
                    <p class="text-sm text-gray-600">Gestión de tickets y seguimiento de historial</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div
                        class="bg-gray-100 text-gray-700 text-sm px-4 py-1.5 rounded-full flex items-center gap-2 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A9 9 0 1112 21a9 9 0 01-6.879-3.196zM15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="font-semibold">David Yauri</span>
                        <span class="text-xs bg-black text-white px-2 py-0.5 rounded">Area Sistemas y TI</span>
                    </div>
                    <button class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C8.67 6.165 8 7.388 8 8.75V14.158c0 .538-.214 1.055-.595 1.437L6 17h9z" />
                        </svg>
                       
                    </button>
                </div>
            </div>
        </div>

        <div class="flex items-center space-x-2 mb-4 bg-gray-100 p-2 rounded-lg w-fit">
            <!-- Tab: Mis Tickets -->
            <button wire:click="$set('tab', 'mis')"
                @class([ 'flex items-center px-3 py-1.5 text-sm font-medium rounded-md transition'
                , 'bg-black text-white'=>
                $tab === 'mis',
                'text-gray-700 hover:bg-gray-200' => $tab !== 'mis',
                ])>
                <flux:icon.user variant="micro" class="mr-1.5" />
                Mis Tickets
                <span class="ml-2 text-xs bg-white text-black px-1.5 py-0.5 rounded-full font-semibold"></span>
            </button>

            <!-- Tab: Tickets No Asignados -->
            <button wire:click="$set('tab', 'pendientes')"
                @class([ 'flex items-center px-3 py-1.5 text-sm font-medium rounded-md transition'
                , 'bg-black text-white'=>
                $tab === 'pendientes',
                'text-gray-700 hover:bg-gray-200' => $tab !== 'pendientes',
                ])>
                <flux:icon.users variant="micro" class="mr-1.5" />
                No Asignados
                <span class="ml-2 text-xs bg-white text-black px-1.5 py-0.5 rounded-full font-semibold"></span>
            </button>

            <!-- Tab: Todos los Tickets del Área -->
            <button wire:click="$set('tab', 'todos')"
                @class([ 'flex items-center px-3 py-1.5 text-sm font-medium rounded-md transition'
                , 'bg-black text-white'=>
                $tab === 'todos',
                'text-gray-700 hover:bg-gray-200' => $tab !== 'todos',
                ])>
                <flux:icon.users variant="micro" class="mr-1.5" />
                Todos del Área
            </button>
        </div>
        <!-- Tabla de Tickets -->
        <livewire:tickets.table :tipo="$tab" wire:key="tickets-table-{{ $tab }}" />
    </div>
</div>
</div>