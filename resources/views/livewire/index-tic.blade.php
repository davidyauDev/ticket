<div>
    <div class="p-6 bg-white rounded-lg shadow">
        <!-- Título -->
        <h1 class="text-xl font-bold mb-1">Sistema de Tickets</h1>
        <p class="text-sm text-gray-600 mb-4">Gestión de tickets y seguimiento de historial</p>
        <!-- Tabs con íconos -->
        <div class="flex space-x-2 mb-4">
            <!-- Botón: Mis Tickets -->
            <button wire:click="$set('tab', 'mis')"
                @class([ 'flex items-center px-4 py-1.5 text-sm font-medium border rounded-full'
                , 'bg-black text-white border-black'=> $tab === 'mis',
                'bg-white text-gray-700 border-gray-300 hover:bg-gray-100' => $tab !== 'mis'
                ])>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Mis Tickets
            </button>

            <!-- Botón: Todos los Tickets -->
            <button wire:click="$set('tab', 'todos')"
                @class([ 'flex items-center px-4 py-1.5 text-sm font-medium border rounded-full'
                , 'bg-black text-white border-black'=> $tab === 'todos',
                'bg-white text-gray-700 border-gray-300 hover:bg-gray-100' => $tab !== 'todos'
                ])>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h4" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7h1a1 1 0 011 1v2h-4v1" />
                </svg>
                Todos los Tickets del Area
            </button>
        </div>
         <livewire:tickets.table :tipo="$tab" wire:key="tickets-table-{{ $tab }}" />
    </div>


</div>