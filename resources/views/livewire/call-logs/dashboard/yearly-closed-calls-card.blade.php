<div>
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
        <!-- Valor Principal -->
        <h4 class="font-bold text-gray-800 text-title-sm dark:text-white/90">
            {{ number_format($currentYearCalls) }}
        </h4>
        <!-- Detalle -->
        <div class="flex items-end justify-between mt-4 sm:mt-5">
            <div>
                <p class="text-gray-700 text-theme-sm dark:text-gray-400">Llamadas Este Año</p>
            </div>
            <div class="flex items-center gap-1">
                <span class="flex items-center gap-1 rounded-full {{ $percentageChange >= 0 ? 'bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500' : 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500' }} px-2 py-0.5 text-theme-xs font-medium">
                    {{ $percentageChange >= 0 ? '+' : '' }}{{ number_format($percentageChange, 1) }}%
                </span>
                <span class="text-gray-500 text-theme-xs dark:text-gray-400">
                    Respecto al año anterior
                </span>
            </div>
        </div>
    </div>
</div>
