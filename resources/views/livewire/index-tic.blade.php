<div class="bg-white shadow-md rounded-xl border p-4">
    <div class="p-4">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold mb-1">Sistema de Tickets</h1>
                <p class="text-sm text-gray-600">Gestión de tickets y seguimiento de historial</p>
            </div>

        </div>

    </div>

  <div class="p-4 bg-white  ">
    <div class="flex space-x-2 mb-4">
        <!-- Botón: Mis Tickets -->
        <button wire:click="$set('tab', 'mis')"
            @class([
                'flex items-center px-4 py-1.5 text-sm font-medium border rounded-full',
                'bg-black text-white border-black' => $tab === 'mis',
                'bg-white text-gray-700 border-gray-300 hover:bg-gray-100' => $tab !== 'mis'
            ])>
            <flux:icon.user  variant="micro"/>  
            Mis Tickets
        </button>

        <!-- Botón: Tickets No Asignados -->
        <button wire:click="$set('tab', 'pendientes')"
            @class([
                'flex items-center px-4 py-1.5 text-sm font-medium border rounded-full',
                'bg-black text-white border-black' => $tab === 'pendientes',
                'bg-white text-gray-700 border-gray-300 hover:bg-gray-100' => $tab !== 'pendientes'
            ])>
            <!-- Icono: Usuario con X -->
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-x-icon lucide-user-x"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="17" x2="22" y1="8" y2="13"/><line x1="22" x2="17" y1="8" y2="13"/></svg>
            Tickets No Asignados
        </button>

        <!-- Botón: Todos los Tickets del Área -->
        <button wire:click="$set('tab', 'todos')"
            @class([
                'flex items-center px-4 py-1.5 text-sm font-medium border rounded-full',
                'bg-black text-white border-black' => $tab === 'todos',
                'bg-white text-gray-700 border-gray-300 hover:bg-gray-100' => $tab !== 'todos'
            ])>
            <!-- Icono: Varios usuarios -->
            <flux:icon.users  variant="micro"/>  
            {{-- <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m3-4a4 4 0 100-8 4 4 0 000 8zm6 4a4 4 0 100-8 4 4 0 000 8z" />
            </svg> --}}
            Todos los Tickets del Área
        </button>
    </div>

    <!-- Tabla de Tickets -->
    <livewire:tickets.table :tipo="$tab" wire:key="tickets-table-{{ $tab }}" />
</div>




</div>