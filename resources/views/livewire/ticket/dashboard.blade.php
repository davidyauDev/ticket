<div x-data="{ activeTab: @entangle('activeTab') }" class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
    <div class="flex items-center gap-3 border-b border-gray-200 dark:border-gray-800 mb-6">
        <button @click="activeTab = 'resumen'" :class="activeTab === 'resumen'
                ?
                'bg-blue-50 text-blue-600 border-b-2 border-blue-500 dark:bg-blue-900/20 dark:text-blue-300' :
                'text-gray-500 hover:text-blue-600 hover:bg-gray-50 dark:hover:bg-gray-800/50'"
            class="py-2 px-4 text-sm font-medium rounded-t-lg transition-all duration-200">
            Resumen General
        </button>
        <button @click="activeTab = 'grafica-dia'" :class="activeTab === 'grafica-dia'
                ?
                'bg-blue-50 text-blue-600 border-b-2 border-blue-500 dark:bg-blue-900/20 dark:text-blue-300' :
                'text-gray-500 hover:text-blue-600 hover:bg-gray-50 dark:hover:bg-gray-800/50'"
            class="py-2 px-4 text-sm font-medium rounded-t-lg transition-all duration-200">
            Gráfica por Día
        </button>
    </div>

    <div x-show="activeTab === 'resumen'" x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        class="grid grid-cols-12 gap-4 md:gap-6" wire:key="tab-resumen">
        <div class="col-span-12 xl:col-span-6">
            @livewire('ticket.dashboard.lista-tecnicos', key('lista-tecnicos'))
        </div>

        <div class="col-span-12 xl:col-span-6">
            @livewire('ticket.dashboard.tickets-por-area-mesa', key('tickets-area'))
        </div>

        <div class="col-span-12 xl:col-span-6">
            @livewire('ticket.dashboard.tickets-by-support-type-chart', key('support-type'))
        </div>

        <div class="col-span-12 xl:col-span-6">
            @livewire('ticket.dashboard.closed-tickets-chart', key('closed-tickets'))
        </div>

        <div class="col-span-12 xl:col-span-12">
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 auto-rows-fr">
                @livewire('ticket.dashboard.top-clients-list', key('top-clients'))
                @livewire('ticket.dashboard.top-agenciaslist', key('top-agencias'))
                @livewire('ticket.dashboard.top-equipos-list', key('top-equipos'))
                @livewire('ticket.dashboard.top-list-modelos', key('top-modelos'))
            </div>
        </div>

        <div class="col-span-12">
            @livewire('ticket.dashboard.user-ticket-resolution-table', key('user-tickets'))
        </div>
    </div>

    <div x-show="activeTab === 'grafica-dia'" x-cloak x-transition:enter="transition ease-out       duration-300"
        x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        class="grid grid-cols-12 gap-6" x-on:transitionend.window="$dispatch('resize')" wire:key="tab-grafica-dia">

        <div class="col-span-12">
            @livewire('ticket.dashboard.tickets-derivados-chart', key('derivados-dia'))
            <div class="mt-6">
                @livewire('ticket.dashboard.tickets-detalle-dia-table', key('detalle-dia'))
            </div>
        </div>
    </div>
</div>