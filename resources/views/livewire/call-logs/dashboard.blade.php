<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
    <div class="grid grid-cols-12 gap-4 md:gap-6">
        <div class="col-span-12">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:gap-6 xl:grid-cols-3">
                @livewire('call-logs.dashboard.daily-revenue-calls-card')
                @livewire('call-logs.dashboard.monthly-active-calls-card')
                @livewire('call-logs.dashboard.yearly-closed-calls-card')
            </div>
        </div>

        <div class="col-span-12 xl:col-span-12">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-3">
                @livewire('call-logs.dashboard.most-called-technicians-card')
                @livewire('call-logs.dashboard.top-callers-list')
                @livewire('call-logs.dashboard.call-types-donut-chart')
            </div>
        </div>

        <div class="col-span-12">
            @livewire('call-logs.dashboard.calls-per-day-bar-chart')
        </div>
    </div>
</div>