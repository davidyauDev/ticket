<div
    class="rounded-3xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900/70 p-6 shadow-sm hover:shadow-md transition-all duration-300 ease-in-out">

    <!-- ENCABEZADO -->
    <div class="flex items-center justify-between mb-5">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white tracking-tight flex items-center gap-2">
            <span class="inline-block w-1.5 h-6 bg-gradient-to-b from-indigo-500 to-blue-400 rounded-full"></span>
            Top Agencias
        </h3>

        <!-- Selector de Mes -->
        <div
            class="relative flex items-center rounded-xl border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/60 hover:border-blue-500 transition-all duration-200">
            <select wire:model.live="selectedMonth"
                class="appearance-none bg-transparent px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-0 pr-8 cursor-pointer">
                <option value="0">Todos los meses</option>
                @for ($month = 1; $month <= 12; $month++)
                    <option value="{{ $month }}">
                        {{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>
            <svg xmlns="http://www.w3.org/2000/svg"
                class="absolute right-2 w-4 h-4 text-gray-400 pointer-events-none" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6" />
            </svg>
        </div>
    </div>

    <!-- SEPARADOR -->
    <div class="border-t border-gray-200 dark:border-gray-800 mb-5"></div>

    <!-- LISTADO DE AGENCIAS -->
    <div class="space-y-3">
        @forelse ($topAgencias as $index => $agencia)
            @php
                // Paleta visual moderna (coherente y armónica)
                $palettes = [
                    ['bg' => 'bg-blue-100 text-blue-700', 'dot' => 'bg-blue-500'],
                    ['bg' => 'bg-sky-100 text-sky-700', 'dot' => 'bg-sky-500'],
                    ['bg' => 'bg-indigo-100 text-indigo-700', 'dot' => 'bg-indigo-500'],
                    ['bg' => 'bg-teal-100 text-teal-700', 'dot' => 'bg-teal-500'],
                    ['bg' => 'bg-emerald-100 text-emerald-700', 'dot' => 'bg-emerald-500'],
                    ['bg' => 'bg-fuchsia-100 text-fuchsia-700', 'dot' => 'bg-fuchsia-500'],
                ];
                $color = $palettes[$index % count($palettes)];
            @endphp

            <div
                class="flex items-center justify-between p-3 rounded-2xl bg-gray-50/70 dark:bg-gray-800/40 border border-gray-100 dark:border-gray-800 hover:bg-white dark:hover:bg-gray-800 transition-all duration-300 group shadow-sm hover:shadow-md">
                <div class="flex items-center gap-3">
                    <!-- Indicador circular -->
                    <div class="w-2.5 h-2.5 rounded-full {{ $color['dot'] }}"></div>

                    <!-- Nombre de la agencia -->
                    <span class="text-gray-800 dark:text-gray-200 font-medium truncate max-w-[170px]"
                        title="{{ $agencia['name'] }}">
                        {{ $agencia['name'] }}
                    </span>
                </div>

                <!-- Cantidad de tickets -->
                <span
                    class="px-3 py-1.5 rounded-lg text-sm font-semibold {{ $color['bg'] }} dark:opacity-90">
                    {{ $agencia['total_tickets'] }}
                </span>
            </div>
        @empty
            <p class="text-gray-500 text-sm dark:text-gray-400 text-center py-4">
                No hay datos disponibles.
            </p>
        @endforelse
    </div>

    <!-- FOOTER -->
    <div class="flex justify-end mt-5">
        <p class="text-xs text-gray-500 dark:text-gray-400 italic">
            Actualizado al {{ now()->format('d/m/Y H:i') }}
        </p>
    </div>
</div>
