<div>
    <!-- Cards de métricas principales -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total de Tickets -->
        <a href="{{ route('tickets.index') }}" 
           class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white cursor-pointer hover:shadow-xl transition-all duration-300 transform hover:scale-105 block">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total General</p>
                    <h3 class="text-3xl font-bold">{{ number_format($totalTickets) }}</h3>
                    <p class="text-blue-100 text-xs mt-2">Tickets del año {{ date('Y') }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M7 4V2C7 1.45 7.45 1 8 1H16C16.55 1 17 1.45 17 2V4H20C20.55 4 21 4.45 21 5S20.55 6 20 6H19V19C19 20.1 18.1 21 17 21H7C5.9 21 5 20.1 5 19V6H4C3.45 6 3 5.55 3 5S3.45 4 4 4H7ZM9 3V4H15V3H9ZM7 6V19H17V6H7Z"/>
                    </svg>
                </div>
            </div>
        </a>

        <!-- Tickets Cerrados -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white cursor-pointer hover:shadow-xl transition-all duration-300 transform hover:scale-105"
             wire:click="mostrarTicketsCerrados">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Cerrados</p>
                    <h3 class="text-3xl font-bold">{{ number_format($ticketsCerrados) }}</h3>
                    <p class="text-green-100 text-xs mt-2">
                        {{ $totalTickets > 0 ? round(($ticketsCerrados / $totalTickets) * 100, 1) : 0 }}% del total
                    </p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M11,16.5L18,9.5L16.59,8.09L11,13.67L7.91,10.59L6.5,12L11,16.5Z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Tickets Pendientes (Faltan por cerrar) -->
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white cursor-pointer hover:shadow-xl transition-all duration-300 transform hover:scale-105"
             wire:click="mostrarTicketsPendientes">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-medium">Faltan por Cerrar</p>
                    <h3 class="text-3xl font-bold">{{ number_format($ticketsPendientes) }}</h3>
                    <p class="text-orange-100 text-xs mt-2">
                        {{ $totalTickets > 0 ? round(($ticketsPendientes / $totalTickets) * 100, 1) : 0 }}% del total
                    </p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M12,6A1,1 0 0,0 11,7V12A1,1 0 0,0 11.5,12.87L15.71,15.29A1,1 0 0,0 17.12,13.88L13.5,12.13V7A1,1 0 0,0 12,6Z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Tickets Cerrados -->
    @if($showModalCerrados)
    <div class="fixed inset-0 z-50 overflow-y-auto" wire:key="modal-cerrados">
        
        <!-- Overlay -->
        <div class="fixed inset-0 bg-black/50 transition-opacity"
             wire:click="cerrarModalCerrados"></div>
        
        <!-- Modal Content -->
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative w-full max-w-6xl bg-white dark:bg-gray-900 rounded-lg shadow-xl">
                
                <!-- Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                        Tickets Cerrados - {{ count($this->ticketsCerradosDetalle) }} tickets
                    </h2>
                    <button wire:click="cerrarModalCerrados" 
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-150">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Content -->
                <div class="p-6 space-y-6">
                    <!-- Buscador -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input wire:model.live="searchCerrados" type="text" placeholder="Buscar tickets cerrados..."
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 shadow-sm hover:shadow-md">
                    </div>

                    <!-- Lista de Tickets Cerrados -->
                    <div class="max-h-[500px] overflow-y-auto space-y-3">
                        @forelse ($this->ticketsCerradosDetalle as $ticket)
                            <div wire:key="cerrado-{{ $ticket->id }}" 
                                 class="bg-gray-50 dark:bg-gray-800/30 p-4 rounded-xl border border-gray-200 dark:border-gray-700 hover:shadow-md transition-all duration-200">
                                
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('tickets.show', $ticket->id) }}" 
                                           class="text-sm font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors duration-200">
                                            TCK-{{ str_pad($ticket->id, 7, '0', STR_PAD_LEFT) }}
                                        </a>
                                        <span class="text-xs px-2 py-1 rounded-full font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                            {{ $ticket->estado->nombre ?? 'Cerrado' }}
                                        </span>
                                    </div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $ticket->created_at->format('d/m/Y') }}
                                    </span>
                                </div>

                                <div class="space-y-2 text-sm">
                                    <div class="flex items-center gap-2">
                                        <span class="font-medium text-gray-600 dark:text-gray-300">Cliente:</span>
                                        <span class="text-gray-800 dark:text-gray-200">
                                            {{ $ticket->cliente->nombre ?? 'Sin cliente' }}
                                        </span>
                                    </div>
                                    
                                    <div class="flex items-center gap-2">
                                        <span class="font-medium text-gray-600 dark:text-gray-300">User</span>
                                        <span class="text-gray-800 dark:text-gray-200">
                                            {{ $ticket->user->firstname }}
                                            {{ $ticket->user->lastname }}
                                        </span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <span class="font-medium text-gray-600 dark:text-gray-300">Modelo:</span>
                                        <span class="text-gray-800 dark:text-gray-200">
                                            {{ $ticket->equipo->modelo ?? 'Sin modelo' }}
                                        </span>
                                    </div>

                                    
                                    <div class="flex items-center gap-2">
                                        <span class="font-medium text-gray-600 dark:text-gray-300">Comentario</span>
                                        <span class="text-gray-800 dark:text-gray-200">
                                            {{ $ticket->comentario ?? 'Sin comentario' }}
                                        </span>
                                    </div>


                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">
                                    @if($searchCerrados)
                                        No se encontraron tickets cerrados que coincidan con "{{ $searchCerrados }}".
                                    @else
                                        No hay tickets cerrados.
                                    @endif
                                </p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Footer -->
                    <div class="flex justify-end pt-6 border-t border-gray-200 dark:border-gray-700">
                        <button wire:click="cerrarModalCerrados"
                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-100 rounded-lg transition-all duration-150">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Modal de Tickets Pendientes -->
    @if($showModalPendientes)
    <div class="fixed inset-0 z-50 overflow-y-auto" wire:key="modal-pendientes">
        
        <!-- Overlay -->
        <div class="fixed inset-0 bg-black/50 transition-opacity"
             wire:click="cerrarModalPendientes"></div>
        
        <!-- Modal Content -->
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative w-full max-w-6xl bg-white dark:bg-gray-900 rounded-lg shadow-xl">
                
                <!-- Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                        Tickets Pendientes - {{ count($this->ticketsPendientesDetalle) }} tickets
                    </h2>
                    <button wire:click="cerrarModalPendientes" 
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-150">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Content -->
                <div class="p-6 space-y-6">
                    <!-- Buscador -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input wire:model.live="searchPendientes" type="text" placeholder="Buscar tickets pendientes..."
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 shadow-sm hover:shadow-md">
                    </div>

                    <!-- Lista de Tickets Pendientes -->
                    <div class="max-h-[500px] overflow-y-auto space-y-3">
                        @forelse ($this->ticketsPendientesDetalle as $ticket)
                            <div wire:key="pendiente-{{ $ticket->id }}" 
                                 class="bg-gray-50 dark:bg-gray-800/30 p-4 rounded-xl border border-gray-200 dark:border-gray-700 hover:shadow-md transition-all duration-200">
                                
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('tickets.show', $ticket->id) }}" 
                                           class="text-sm font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors duration-200">
                                            TCK-{{ str_pad($ticket->id, 7, '0', STR_PAD_LEFT) }}
                                        </a>
                                        <span class="text-xs px-2 py-1 rounded-full font-medium
                                            @if($ticket->estado_id == 1) 
                                                bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                            @elseif($ticket->estado_id == 3) 
                                                bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                            @else 
                                                bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300
                                            @endif">
                                            {{ $ticket->estado->nombre ?? 'Pendiente' }}
                                        </span>
                                    </div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $ticket->created_at->format('d/m/Y') }}
                                    </span>
                                </div>

                                <div class="space-y-2 text-sm">
                                    <div class="flex items-center gap-2">
                                        <span class="font-medium text-gray-600 dark:text-gray-300">Cliente:</span>
                                        <span class="text-gray-800 dark:text-gray-200">
                                            {{ $ticket->cliente->nombre ?? 'Sin cliente' }}
                                        </span>
                                    </div>
                                    
                                    <div class="flex items-center gap-2">
                                        <span class="font-medium text-gray-600 dark:text-gray-300">Usuario</span>
                                        <span class="text-gray-800 dark:text-gray-200">
                                            {{ $ticket->user->firstname }}
                                            {{ $ticket->user->lastname }}
                                            
                                        </span>
                                    </div>


                                     <div class="flex items-center gap-2">
                                        <span class="font-medium text-gray-600 dark:text-gray-300">Comentario</span>
                                        <span class="text-gray-800 dark:text-gray-200">
                                            {{ $ticket->comentario }}
                                        </span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <span class="font-medium text-gray-600 dark:text-gray-300">Modelo</span>
                                        <span class="text-gray-800 dark:text-gray-200">
                                            {{ $ticket->equipo->modelo ?? 'N/A' }}
                                        </span>
                                    </div>
                                    
                                    
                                  
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">
                                    @if($searchPendientes)
                                        No se encontraron tickets pendientes que coincidan con "{{ $searchPendientes }}".
                                    @else
                                        No hay tickets pendientes.
                                    @endif
                                </p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Footer -->
                    <div class="flex justify-end pt-6 border-t border-gray-200 dark:border-gray-700">
                        <button wire:click="cerrarModalPendientes"
                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-100 rounded-lg transition-all duration-150">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
