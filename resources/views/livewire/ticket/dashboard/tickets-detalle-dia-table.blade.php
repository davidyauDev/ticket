<div
    class="bg-white dark:bg-gray-900/70 border border-gray-200 dark:border-gray-800 rounded-3xl p-6 shadow-sm hover:shadow-lg transition-all duration-300 ease-in-out">

    <!-- 🔹 ENCABEZADO -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white tracking-tight flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12h6m-6 4h6m2 6H7a2 2 0 01-2-2V4a2 2 0 012-2h8l6 6v14a2 2 0 01-2 2z" />
            </svg>
            Detalle de Tickets del Día
        </h2>

        <!-- 🔸 FILTRO DE FECHA -->
       <div class="flex items-center gap-2">
    <input id="datepicker" type="text" readonly wire:model.live="fecha"
        class="border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/60 
               text-sm text-gray-700 dark:text-gray-200 rounded-full px-4 py-2 
               focus:outline-none focus:ring-2 focus:ring-blue-500 
               focus:border-blue-400 transition-all duration-200 cursor-pointer 
               shadow-sm hover:shadow focus:ring-offset-1 w-36 text-center" />

    <span class="inline-block px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded-full">
        {{ \Carbon\Carbon::parse($fecha)->format('d M Y') }}
    </span>
</div>

    </div>

    <!-- 🔹 TABLA -->
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left border-collapse">
            <thead>
                <tr
                    class="bg-gray-100 dark:bg-gray-800/50 text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-700">
                    <th class="px-4 py-3 font-medium">#</th>
                    <th class="px-4 py-3 font-medium">Cliente</th>
                    <th class="px-4 py-3 font-medium">Modelo</th>
                    <th class="px-4 py-3 font-medium">Técnico</th>
                    <th class="px-4 py-3 font-medium">Estado</th>
                    <th class="px-4 py-3 font-medium">Fecha</th>
                    <th class="px-4 py-3 font-medium text-center">Historial</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach ($tickets as $ticket)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-all duration-150">
                        <td class="px-4 py-3">{{ $ticket->id }}</td>
                        <td class="px-4 py-3">{{ $ticket->agencia_nombre }}</td>
                        <td class="px-4 py-3">{{ $ticket->modelo_nombre }}</td>
                        <td class="px-4 py-3">{{ $ticket->tecnico_nombres }}</td>
                        <td class="px-4 py-3">
                            <span @class([
                                'inline-block px-2 py-1 text-xs font-semibold rounded-full',
                                'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' =>
                                    $ticket->estado_nombre === 'Cerrado',
                                'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' =>
                                    $ticket->estado_nombre === 'Pausado',
                                'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' =>
                                    $ticket->estado_nombre === 'Derivado',
                                'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' =>
                                    $ticket->estado_nombre === 'Anulado',
                                'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200' => !in_array(
                                    $ticket->estado_nombre,
                                    ['Cerrado', 'Pausado', 'Derivado', 'Anulado']),
                            ])>
                                {{ $ticket->estado_nombre }}
                            </span>

                        </td>

                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($ticket->created_at)->format('Y-m-d') }}</td>
                        <td class="px-4 py-3 text-center">
                            @if (($historiales[$ticket->id] ?? collect())->isNotEmpty())
                                <button wire:click="$toggle('showHistorial.{{ $ticket->id }}')"
                                    class="inline-flex items-center text-blue-500 hover:underline transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-4 h-4 mr-1 transform transition-transform duration-200 {{ !empty($showHistorial[$ticket->id]) ? 'rotate-90' : '' }}"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                    Ver historial
                                </button>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                    </tr>

                    @if (!empty($showHistorial[$ticket->id]))
                        <tr>
                            <td colspan="7"
                                class="p-4 bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-400 dark:border-blue-600 text-sm">
                                <ul class="space-y-2">
                                    @foreach ($historiales[$ticket->id] as $h)
                                        <li>
                                            <p class="font-medium text-blue-700 dark:text-blue-300">{{ $h->accion }}
                                            </p>
                                            <p class="text-gray-600 dark:text-gray-300">
                                                <span class="font-semibold">{{ $h->usuario_nombre ?? 'N/A' }}</span>
                                                ({{ $h->from_area ?? '-' }} → {{ $h->to_area ?? '-' }})
                                                | Estado: <span
                                                    class="text-gray-800 dark:text-gray-200">{{ $h->estado_nombre ?? '-' }}</span>
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ $h->started_at }} - {{ $h->ended_at ?? 'Actual' }}
                                            </p>
                                            @if ($h->comentario)
                                                <p class="italic text-gray-500 mt-1">"{{ $h->comentario }}"</p>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="flex justify-between items-center mt-4 text-xs text-gray-500 dark:text-gray-400">
        <p>Total de Tickets: {{ $tickets->count() }}</p>
        <p>Última actualización: {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</div>

<script>
    function initFlatpickr() {
    flatpickr("#datepicker", {
        dateFormat: "Y-m-d",
        defaultDate: @json($fecha), // Livewire binding
        onChange: function (selectedDates, dateStr, instance) {
            @this.set('fecha', dateStr);
        }
    });
}


   document.addEventListener('livewire:load', function () {
    initFlatpickr();
    Livewire.hook('message.processed', () => {
        initFlatpickr();
    });
});


    document.addEventListener('init-flatpickr', () => {
        initFlatpickr();
    });
</script>
