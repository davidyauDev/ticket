<div>
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold mb-1">Sistema de Tickets</h1>
                <p class="text-sm text-gray-600">Gestión de tickets y seguimiento de historial</p>
            </div>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Tickets Asignados --}}
            <div class="bg-gray-50 border rounded-lg p-4 shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-700">Tickets Asignados</h3>
                    <div class="bg-blue-100 text-blue-600 p-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-3-3h-4a3 3 0 00-3 3v2h5zM9 20H4v-2a3 3 0 013-3h4a3 3 0 013 3v2zM15 11a3 3 0 11-6 0 3 3 0 016 0zM9 11a3 3 0 016 0" />
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-gray-900">12</div>
                <div class="text-sm text-gray-500 mt-1">Asignados a técnicos</div>
            </div>

            {{-- Tickets Resueltos --}}
            <div class="bg-gray-50 border rounded-lg p-4 shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-700">Tickets Resueltos</h3>
                    <div class="bg-green-100 text-green-600 p-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-gray-900">5</div>
                <div class="text-sm text-gray-500 mt-1">Completados y cerrados</div>
            </div>

            {{-- Sin Asignar --}}
            <div class="bg-gray-50 border rounded-lg p-4 shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-700">Sin Asignar</h3>
                    <div class="bg-yellow-100 text-yellow-600 p-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-gray-900">3</div>
                <div class="text-sm text-gray-500 mt-1">Pendientes de asignación</div>
            </div>
        </div>
    </div>

  <div class="p-6 bg-white rounded-lg shadow">
    <div class="flex space-x-2 mb-4">
        <!-- Botón: Mis Tickets -->
        <button wire:click="$set('tab', 'mis')"
            @class([
                'flex items-center px-4 py-1.5 text-sm font-medium border rounded-full',
                'bg-black text-white border-black' => $tab === 'mis',
                'bg-white text-gray-700 border-gray-300 hover:bg-gray-100' => $tab !== 'mis'
            ])>
            <flux:icon.user  variant="micro"/>  
            <!-- Icono: Usuario -->
            {{-- <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5.121 17.804A9.953 9.953 0 0112 15c2.21 0 4.244.722 5.879 1.938M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg> --}}
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