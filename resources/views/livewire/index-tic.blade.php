<div>
    <div class="p-4 space-y-4">
        <h1 class="text-2xl font-bold text-center">Sistema de Tickets</h1>
        <p class="text-center text-gray-400">Gestión de tickets y seguimiento de historial</p>
         <livewire:tickets.stats />
       {{-- Tabs --}}
    <div class="flex items-center bg-gray-100 rounded-md overflow-hidden mb-4">
        <button
            wire:click="delete('mis')"
            class="flex items-center px-4 py-2 w-1/2 justify-center text-sm font-medium transition-all duration-200
                {{ $tab === 'mis' ? 'bg-white text-black shadow-sm' : 'text-gray-500' }}">
            🧍 Mis Tickets
        </button>
        <button
            wire:click="delete('todos')"
            class="flex items-center px-4 py-2 w-1/2 justify-center text-sm font-medium transition-all duration-200
                {{ $tab === 'todos' ? 'bg-white text-black shadow-sm' : 'text-gray-500' }}">
            📋 Todos los Tickets
        </button>
    </div>

        {{-- Contenido dinámico según tab --}}
    <div>
        @if ($tab === 'mis')
            <livewire:tickets.table :tipo="'mis'" />
        @else
            <livewire:tickets.table :tipo="'todos'" />
        @endif
    </div>

    </div>
</div>
