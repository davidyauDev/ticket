<div>
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div class="grid grid-cols-12 gap-4 md:gap-6">
            <div class="col-span-12">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:gap-6 xl:grid-cols-4">
                    <div
                        class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Visitantes únicos</font>
                            </font>
                        </p>
                        <div class="flex items-end justify-between mt-3">
                            <div>
                                <h4 class="text-2xl font-bold text-gray-800 dark:text-white/90">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">24.7 mil</font>
                                    </font>
                                </h4>
                            </div>
                            <div class="flex items-center gap-1"><span
                                    class="flex items-center gap-1 rounded-full bg-success-50 px-2 py-0.5 text-theme-xs font-medium text-success-600 dark:bg-success-500/15 dark:text-success-500">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">+20%</font>
                                    </font>
                                </span><span class="text-gray-500 text-theme-xs dark:text-gray-400">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">Vs el mes pasado</font>
                                    </font>
                                </span></div>
                        </div>
                    </div>
                    <div
                        class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Total de páginas vistas</font>
                            </font>
                        </p>
                        <div class="flex items-end justify-between mt-3">
                            <div>
                                <h4 class="text-2xl font-bold text-gray-800 dark:text-white/90">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">55.9 mil</font>
                                    </font>
                                </h4>
                            </div>
                            <div class="flex items-center gap-1"><span
                                    class="flex items-center gap-1 rounded-full bg-success-50 px-2 py-0.5 text-theme-xs font-medium text-success-600 dark:bg-success-500/15 dark:text-success-500">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">+4%</font>
                                    </font>
                                </span><span class="text-gray-500 text-theme-xs dark:text-gray-400">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">Vs el mes pasado</font>
                                    </font>
                                </span></div>
                        </div>
                    </div>
                    <div
                        class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Tasa de rebote</font>
                            </font>
                        </p>
                        <div class="flex items-end justify-between mt-3">
                            <div>
                                <h4 class="text-2xl font-bold text-gray-800 dark:text-white/90">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">54%</font>
                                    </font>
                                </h4>
                            </div>
                            <div class="flex items-center gap-1"><span
                                    class="flex items-center gap-1 rounded-full bg-error-50 px-2 py-0.5 text-theme-xs font-medium text-error-600 dark:bg-error-500/15 dark:text-error-500">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">-1,59%</font>
                                    </font>
                                </span><span class="text-gray-500 text-theme-xs dark:text-gray-400">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">Vs el mes pasado</font>
                                    </font>
                                </span></div>
                        </div>
                    </div>
                    <div
                        class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Duración de la visita</font>
                            </font>
                        </p>
                        <div class="flex items-end justify-between mt-3">
                            <div>
                                <h4 class="text-2xl font-bold text-gray-800 dark:text-white/90">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">2m 56s</font>
                                    </font>
                                </h4>
                            </div>
                            <div class="flex items-center gap-1"><span
                                    class="flex items-center gap-1 rounded-full bg-success-50 px-2 py-0.5 text-theme-xs font-medium text-success-600 dark:bg-success-500/15 dark:text-success-500">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">+7%</font>
                                    </font>
                                </span><span class="text-gray-500 text-theme-xs dark:text-gray-400">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">Vs el mes pasado</font>
                                    </font>
                                </span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-12 xl:col-span-6">
                @livewire('ticket.dashboard.tickets-by-support-type-chart')
            </div>
            <div class="col-span-6 xl:col-span-6">
            </div>
            <div class="col-span-12 xl:col-span-12">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">
                    @livewire('ticket.dashboard.top-clients-list')
                    @livewire('ticket.dashboard.top-agenciaslist')
                    @livewire('ticket.dashboard.top-equipos-list')
                    @livewire('call-logs.dashboard.top-callers-list')
                </div>
            </div>
        </div>
    </div>