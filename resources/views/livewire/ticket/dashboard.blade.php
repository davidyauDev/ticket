<div>
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div class="grid grid-cols-12 gap-4 md:gap-6">
            <div class="col-span-12">
            </div>
              <div class="col-span-12 xl:col-span-6">
                @livewire('ticket.dashboard.lista-tecnicos')

            </div>
            <div class="col-span-12 xl:col-span-6">
                @livewire('ticket.dashboard.tickets-por-area-mesa')

            </div> 
            <div class="col-span-12 xl:col-span-6">
                @livewire('ticket.dashboard.tickets-by-support-type-chart')
            </div>
            <div class="col-span-12 xl:col-span-6">
                @livewire('ticket.dashboard.closed-tickets-chart')
            </div>
            <div class="col-span-12 xl:col-span-12">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-3">
                    @livewire('ticket.dashboard.top-clients-list')
                    @livewire('ticket.dashboard.top-agenciaslist')
                    @livewire('ticket.dashboard.top-equipos-list')
                </div>
            </div>

            <div class="col-span-12">
                @livewire('ticket.dashboard.user-ticket-resolution-table')
            </div>
           
        </div>
    </div>