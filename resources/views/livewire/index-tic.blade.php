<div class="p-6">
    <header class="mb-12 flex flex-col md:flex-row md:items-end md:justify-between">
        <div>
            <h1 class="mb-1 text-2xl font-medium text-gray-900">Sistema de Tickets</h1>
            <p class="text-sm text-gray-500">Gestión de tickets y seguimiento de historial</p>
        </div>
        <div class="mt-4 flex items-center gap-3 md:mt-0">
            <button class="inline-flex items-center justify-center whitespace-nowrap font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border bg-background hover:text-accent-foreground rounded-md px-3 h-8 gap-1 border-gray-200 text-xs text-gray-600 hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download h-3.5 w-3.5">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" x2="12" y1="15" y2="3"></line>
                </svg>
                <span>Exportar</span>
            </button>
            <button class="inline-flex items-center justify-center whitespace-nowrap font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border bg-background hover:text-accent-foreground rounded-md px-3 h-8 gap-1 border-gray-200 text-xs text-gray-600 hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sliders-horizontal h-3.5 w-3.5">
                    <line x1="21" x2="14" y1="4" y2="4"></line>
                    <line x1="10" x2="3" y1="4" y2="4"></line>
                    <line x1="21" x2="12" y1="12" y2="12"></line>
                    <line x1="8" x2="3" y1="12" y2="12"></line>
                    <line x1="21" x2="16" y1="20" y2="20"></line>
                    <line x1="12" x2="3" y1="20" y2="20"></line>
                    <line x1="14" x2="14" y1="2" y2="6"></line>
                    <line x1="8" x2="8" y1="10" y2="14"></line>
                    <line x1="16" x2="16" y1="18" y2="22"></line>
                </svg>
                <span>Filtros</span>
            </button>
        </div>
    </header>
    <div class="p-4 space-y-4">
        
        
        <div class="mb-12 rounded-xl bg-gray-50 p-6">
            <div class="mb-6 flex flex-col justify-between gap-4 md:flex-row md:items-center">
                <h2 class="text-sm font-medium text-gray-700">Resumen de Tickets</h2>
                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-1.5">
                        <span class="h-2.5 w-2.5 rounded-sm bg-emerald-500"></span>
                        <span class="text-xs text-gray-600">Resueltos</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="h-2.5 w-2.5 rounded-sm bg-blue-500"></span>
                        <span class="text-xs text-gray-600">Derivados</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="h-2.5 w-2.5 rounded-sm bg-amber-500"></span>
                        <span class="text-xs text-gray-600">Pendientes</span>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <div class="overflow-hidden rounded-lg border border-gray-100 bg-white p-5 shadow-sm transition-all hover:shadow-md">
                    <div class="mb-3 flex items-center justify-between">
                        <h3 class="text-sm font-medium text-gray-700">Resueltos</h3>
                        <span class="flex h-6 items-center justify-center rounded-full bg-emerald-50 px-2 text-xs font-medium text-emerald-700">0%</span>
                    </div>
                    <div class="mb-3 flex items-baseline justify-between">
                        <p class="text-3xl font-light tracking-tight text-gray-900">0</p>
                        <div class="flex items-center text-xs text-gray-500">
                            <span>Último mes</span>
                        </div>
                    </div>
                    <div class="h-1.5 w-full overflow-hidden rounded-full bg-gray-100">
                        <div class="h-full w-0 rounded-full bg-emerald-500 transition-all duration-500"></div>
                    </div>
                </div>
                <div class="overflow-hidden rounded-lg border border-gray-100 bg-white p-5 shadow-sm transition-all hover:shadow-md">
                    <div class="mb-3 flex items-center justify-between">
                        <h3 class="text-sm font-medium text-gray-700">Derivados</h3>
                        <span class="flex h-6 items-center justify-center rounded-full bg-blue-50 px-2 text-xs font-medium text-blue-700">0%</span>
                    </div>
                    <div class="mb-3 flex items-baseline justify-between">
                        <p class="text-3xl font-light tracking-tight text-gray-900">0</p>
                        <div class="flex items-center text-xs text-gray-500">
                            <span>Último mes</span>
                        </div>
                    </div>
                    <div class="h-1.5 w-full overflow-hidden rounded-full bg-gray-100">
                        <div class="h-full w-0 rounded-full bg-blue-500 transition-all duration-500"></div>
                    </div>
                </div>
                <div class="overflow-hidden rounded-lg border border-gray-100 bg-white p-5 shadow-sm transition-all hover:shadow-md">
                    <div class="mb-3 flex items-center justify-between">
                        <h3 class="text-sm font-medium text-gray-700">Pendientes</h3>
                        <span class="flex h-6 items-center justify-center rounded-full bg-amber-50 px-2 text-xs font-medium text-amber-700">100%</span>
                    </div>
                    <div class="mb-3 flex items-baseline justify-between">
                        <p class="text-3xl font-light tracking-tight text-gray-900">1</p>
                        <div class="flex items-center text-xs text-gray-500">
                            <span>Último mes</span>
                        </div>
                    </div>
                    <div class="h-1.5 w-full overflow-hidden rounded-full bg-gray-100">
                        <div class="h-full w-full rounded-full bg-amber-500 transition-all duration-500"></div>
                    </div>
                </div>
            </div>
            {{-- <div class="mt-6 rounded-lg border border-gray-100 bg-white p-5 shadow-sm">
                
              
            </div> --}}
            <div class="mt-4 text-center">
                <p class="text-xs text-gray-500">Mis tickets: 1 (100% del total)</p>
            </div>
        </div>

        <div class="border-b border-gray-100 px-6 pt-4">
            <div role="tablist" aria-orientation="horizontal" class="h-10 items-center justify-center rounded-md text-muted-foreground grid w-full grid-cols-2 gap-4 bg-transparent p-0" tabindex="0" data-orientation="horizontal" style="outline: none;">
                <button type="button" role="tab" aria-selected="true" aria-controls="radix-«r0»-content-mis-tickets" data-state="active" id="radix-«r0»-trigger-mis-tickets" class="inline-flex items-center justify-center whitespace-nowrap rounded-sm ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:bg-background data-[state=active]:shadow-sm border-b-2 border-transparent px-0 py-2 text-sm font-normal text-gray-500 hover:text-gray-900 data-[state=active]:border-gray-900 data-[state=active]:text-gray-900" tabindex="0" data-orientation="horizontal" data-radix-collection-item="">Mis Tickets</button>
                <button type="button" role="tab" aria-selected="false" aria-controls="radix-«r0»-content-todos-tickets" data-state="inactive" id="radix-«r0»-trigger-todos-tickets" class="inline-flex items-center justify-center whitespace-nowrap rounded-sm ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:bg-background data-[state=active]:shadow-sm border-b-2 border-transparent px-0 py-2 text-sm font-normal text-gray-500 hover:text-gray-900 data-[state=active]:border-gray-900 data-[state=active]:text-gray-900" tabindex="-1" data-orientation="horizontal" data-radix-collection-item="">Todos los Tickets</button>
            </div>
        </div>

        <div class="rounded-xl border border-gray-100 bg-white shadow-sm">
            
        </div>

     
        <div>
            @if ($tab === 'mis')
                <livewire:tickets.table :tipo="'mis'" />
            @else
                <livewire:tickets.table :tipo="'todos'" />
            @endif
        </div>

    </div>
</div>
