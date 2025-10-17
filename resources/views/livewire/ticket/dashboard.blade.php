<div x-data="{ activeTab: @entangle('activeTab') }" class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
    <div class="flex items-center gap-3 border-b border-gray-200 dark:border-gray-800 mb-6">
        <button @click="activeTab = 'resumen'"
            :class="activeTab === 'resumen'
                ?
                'bg-blue-50 text-blue-600 border-b-2 border-blue-500 dark:bg-blue-900/20 dark:text-blue-300' :
                'text-gray-500 hover:text-blue-600 hover:bg-gray-50 dark:hover:bg-gray-800/50'"
            class="py-2 px-4 text-sm font-medium rounded-t-lg transition-all duration-200">
            Resumen General
        </button>
        <button @click="activeTab = 'grafica-dia'; $nextTick(() => $dispatch('init-flatpickr'))"
            :class="activeTab === 'grafica-dia'
                ?
                'bg-blue-50 text-blue-600 border-b-2 border-blue-500 dark:bg-blue-900/20 dark:text-blue-300' :
                'text-gray-500 hover:text-blue-600 hover:bg-gray-50 dark:hover:bg-gray-800/50'"
            class="py-2 px-4 text-sm font-medium rounded-t-lg transition-all duration-200">
            Gráfica por Día
        </button>

    </div>
    <div x-data="{ showModal: false, tipoExport: null, mes: '' }" class="flex justify-end gap-3 mb-6">
        <button @click="showModal = true; tipoExport = 'pdf'"
            class="px-5 py-2 bg-red-500 text-white text-sm font-medium rounded-lg hover:bg-red-600 transition-all duration-200">
            Generar PDF
        </button>

        <button @click="showModal = true; tipoExport = 'excel'"
            class="px-5 py-2 bg-green-500 text-white text-sm font-medium rounded-lg hover:bg-green-600 transition-all duration-200">
            Generar Excel
        </button>

        <!-- Modal -->
        <div x-show="showModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
            <div class="bg-white rounded-lg p-6 w-80 shadow-lg">
                <h2 class="text-lg font-semibold mb-4 text-gray-700">Seleccionar Mes</h2>

                <select x-model="mes"
                    class="w-full border border-gray-300 rounded-lg text-sm px-3 py-2 mb-4 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Todos los meses</option>
                    <option value="1">Enero</option>
                    <option value="2">Febrero</option>
                    <option value="3">Marzo</option>
                    <option value="4">Abril</option>
                    <option value="5">Mayo</option>
                    <option value="6">Junio</option>
                    <option value="7">Julio</option>
                    <option value="8">Agosto</option>
                    <option value="9">Septiembre</option>
                    <option value="10">Octubre</option>
                    <option value="11">Noviembre</option>
                    <option value="12">Diciembre</option>
                </select>


                <div class="flex justify-end gap-2">
                    <button @click="showModal = false"
                        class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800">Cancelar</button>
                    <button
                        @click="
                        showModal = false;
                        if (tipoExport === 'pdf') {
                            $wire.exportarPDF(mes);
                        } else {
                            $wire.exportarExcel(mes);
                        }
                    "
                        class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
                        Exportar
                    </button>
                </div>
            </div>
        </div>
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

        <div class="col-span-12">
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 auto-rows-fr">
        @livewire('ticket.dashboard.top-clients-list', key('top-clients'))
        @livewire('ticket.dashboard.top-agenciaslist', key('top-agencias'))
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
