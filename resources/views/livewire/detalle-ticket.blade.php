<div class="mx-auto max-w-(--breakpoint-2xl) p-4 md:p-6">
    <!-- Breadcrumb Start -->
    <div x-data="{ pageName: `Detalle` }">
        <div class="flex flex-wrap items-center justify-between gap-3 pb-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90" x-text="pageName">Ticket Reply</h2>
            <nav>
            </nav>
        </div>
    </div>

    <!-- Content Start -->
    <div class="overflow-hidden xl:h-[calc(100vh-180px)]">
        <div class="grid h-full grid-cols-1 gap-5 xl:grid-cols-12">
            <!-- Left -->
            <div class="xl:col-span-8 2xl:col-span-9">
                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <!-- Header -->
                    <div
                        class="flex flex-col justify-between gap-5 border-b border-gray-200 px-5 py-4 sm:flex-row sm:items-center dark:border-gray-800">
                        <div>
                            <h3 class="text-lg font-medium text-gray-800 dark:text-white/90">
                                Ticket Soporte #{{ $ticket->id }} - {{ $ticket->comentario }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Mon,&nbsp;3:20 PM&nbsp;(2 days ago)
                            </p>
                        </div>

                    </div>

                    <div class="relative px-6 py-7">

                        <div
                            class="custom-scrollbar h-[calc(58vh-162px)] space-y-7 divide-y divide-gray-200 overflow-y-auto pr-2 dark:divide-gray-800">
                            @forelse($historiales as $item)
                                <article>
                                    <div class="mb-6 flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <span class="mr-3 h-11 w-11 overflow-hidden rounded-full">
                                                <div
                                                    class="flex items-center justify-center w-10 h-10 rounded-full bg-brand-100">
                                                    <span class="text-xs font-semibold text-brand-500">
                                                        {{ $item->usuario->initials() }}
                                                    </span>
                                                </div>
                                            </span>
                                            <div>
                                                <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                                    {{ $item->usuario->name }}
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $item->usuario->email }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-3">
                                            <!-- 🔑 Estado como badge -->
                                            @php
                                                $estadoColor = match ($item->estado?->nombre) {
                                                    'Cerrado'
                                                        => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300',
                                                    'En Progreso' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30
                                        dark:text-blue-300',
                                                    'Pausado' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30
                                        dark:text-yellow-300',
                                                    default
                                                        => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300',
                                                };
                                            @endphp

                                            <span
                                                class="rounded-full px-2 py-0.5 text-xs font-medium {{ $estadoColor }}">
                                                {{ $item->estado?->nombre ?? 'Sin estado' }}
                                            </span>

                                            <!-- Fecha -->
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $item->created_at->format('d/m/Y H:i') }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="pb-6">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            Asignado a {{ $ticket->assignedUser->name }},
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $item->comentario }}
                                        </p>
                                        @if ($item->archivos->isNotEmpty())
                                            <div class="mt-2 flex flex-wrap gap-2">
                                                @foreach ($item->archivos as $file)
                                                    <a href="{{ Storage::url($file->ruta) }}" target="_blank"
                                                        class="inline-flex items-center gap-1 rounded-lg border border-gray-200 bg-gray-50 px-2 py-1 text-xs font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                                                        <!-- Ícono de clip -->
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-3.5 w-3.5 text-gray-500 dark:text-gray-300"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828L18 9.828a4 4 0 10-5.656-5.656L6.343 10.172" />
                                                        </svg>
                                                        {{ $file->nombre_original }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif

                                    </div>
                                </article>
                            @empty
                                <p class="text-sm text-gray-500">No hay historial disponible para este ticket.</p>
                            @endforelse

                        </div>
                        <!-- Fixed Input Wrapper -->
                        @if ($ticket->estado_id == 5)
                            <!-- Ticket cerrado -->
                            <div
                                class="mt-6 p-4 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800">
                                <p class="text-sm font-medium text-red-700 dark:text-red-300">
                                    🚫 Este ticket está cerrado y no se pueden agregar comentarios ni cambiar su estado.
                                </p>
                            </div>
                        @elseif ($ticket->estado_id == 6)
                            <!-- Ticket pausado -->
                            <div
                                class="mt-6 p-4 rounded-xl bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 flex items-center justify-between">
                                <p class="text-sm font-medium text-yellow-700 dark:text-yellow-300">
                                    ⏸ Este ticket está pausado.
                                </p>
                                <button wire:click="reanudarTicket" wire:loading.attr="disabled"
                                    class="bg-green-500 hover:bg-green-600 shadow-theme-xs inline-flex h-9 items-center justify-center rounded-lg px-4 py-3 text-sm font-medium text-white">
                                    ▶ Reanudar
                                </button>
                            </div>
                        @else
                            <!-- Normal: se puede comentar y cambiar estado -->
                            <div class="pt-5">
                                <div
                                    class="mx-auto max-h-[162px] w-full rounded-2xl border border-gray-200 shadow-xs dark:border-gray-800 dark:bg-gray-800">

                                    <!-- Textarea -->
                                    <textarea wire:model="comentario" placeholder="Escribe tu comentario aquí..."
                                        class="h-20 w-full resize-none border-none bg-transparent p-5 font-normal text-gray-800 outline-none placeholder:text-gray-400 focus:ring-0 dark:text-white"></textarea>

                                    <!-- Bottom Section -->
                                    <div class="flex items-center justify-between p-3">
                                        <!-- Adjuntar archivo -->
                                        <div>
                                            <label for="archivo"
                                                class="flex h-9 cursor-pointer items-center gap-1.5 rounded-lg bg-transparent px-2 py-3 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-900 dark:hover:text-gray-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    fill="none">
                                                    <path
                                                        d="M14.4194 11.7679L15.4506 10.7367C17.1591 9.02811 17.1591 6.25802 15.4506 4.54947C13.742 2.84093 10.9719 2.84093 9.2634 4.54947L8.2322 5.58067M11.77 14.4172L10.7365 15.4507C9.02799 17.1592 6.2579 17.1592 4.54935 15.4507C2.84081 13.7422 2.84081 10.9721 4.54935 9.26352L5.58285 8.23002M11.7677 8.23232L8.2322 11.7679"
                                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
                                                </svg>
                                                Adjuntar
                                            </label>
                                            <input id="archivo" type="file" wire:model="archivo" class="hidden" />
                                            @if ($archivo)
                                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                    📎 {{ $archivo->getClientOriginalName() }}
                                                </p>
                                            @endif
                                        </div>

                                        <!-- Botón de enviar -->
                                        <button wire:click="ActualizarTicket" wire:loading.attr="disabled"
                                            wire:target="ActualizarTicket,archivo" x-data
                                            x-on:click="Swal.fire({ 
                        title: 'Actualizando...', 
                        text: 'Por favor espera.', 
                        allowOutsideClick: false, 
                        didOpen: () => { Swal.showLoading() } 
                    })"
                                            class="bg-brand-500 hover:bg-brand-600 shadow-theme-xs inline-flex h-9 items-center justify-center rounded-lg px-4 py-3 text-sm font-medium text-white">
                                            Enviar
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- Estados -->
                            <div class="mt-6 flex flex-wrap items-center gap-4">
                                <span class="text-gray-500 dark:text-gray-400">Estados:</span>
                                <div x-data="{ selected: '{{ $estado_id }}' }" class="flex items-center gap-4">
                                    @foreach ($estados as $estado)
                                        <label for="estado-{{ $estado->id }}"
                                            class="flex cursor-pointer items-center text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                                            <div class="relative">
                                                <input wire:model="estado_id" type="radio"
                                                    id="estado-{{ $estado->id }}" value="{{ $estado->id }}"
                                                    x-model="selected" class="sr-only" name="selected" />
                                                <div :class="parseInt(selected) === {{ $estado->id }} ?
                                                    'border-brand-500 bg-brand-500' :
                                                    'bg-transparent border-gray-300 dark:border-gray-700'"
                                                    class="hover:border-brand-500 dark:hover:border-brand-500 mr-3 flex h-4 w-4 items-center justify-center rounded-full border-[1.25px]">
                                                    <span class="h-1.5 w-1.5 rounded-full"
                                                        :class="parseInt(selected) === {{ $estado->id }} ?
                                                            'bg-white' :
                                                            'bg-white dark:bg-[#171f2e]'">
                                                    </span>
                                                </div>
                                            </div>
                                            {{ $estado->nombre }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Right -->
            <div class="xl:col-span-4 2xl:col-span-3">
                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-white/90">
                            Ticket Details
                        </h3>
                    </div>
                    <ul class="divide-y divide-gray-100 px-6 py-3 dark:divide-gray-800">
                        <li class="grid grid-cols-2 gap-5 py-2.5">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Creado por</span>
                            <span class="text-gray-700 dark:text-gray-400">{{ $ticket->createdBy->name }}</span>
                        </li>
                        <li class="grid grid-cols-2 gap-5 py-2.5">
                            <span class="text-sm text-gray-500 dark:text-gray-400">OSTICKET</span>
                            <span
                                class="text-sm break-words text-gray-700 dark:text-gray-400">{{ $ticket->osticket }}</span>
                        </li>
                        <li class="grid grid-cols-2 gap-5 py-2.5">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Ticket ID
                            </span>
                            <span class="text-sm text-gray-700 dark:text-gray-400">{{ $ticket->id }}</span>
                        </li>
                        <li class="grid grid-cols-2 gap-5 py-2.5">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Tipo de Soporte</span>
                            <span class="text-sm text-gray-700 dark:text-gray-400">{{ $ticket->observacion }}</span>
                        </li>
                        <li class="grid grid-cols-2 gap-5 py-2.5">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Tecnico</span>
                            <span
                                class="text-sm text-gray-700 dark:text-gray-400">{{ $ticket->tecnico_nombres }}</span>
                        </li>
                        <li class="grid grid-cols-2 gap-5 py-2.5">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Creado</span>
                            <span
                                class="text-sm text-gray-700 dark:text-gray-400">{{ $ticket->created_at->format('M d,
                                                                                                                                Y') }}</span>
                        </li>
                        <li class="grid grid-cols-2 gap-5 py-2.5">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Estado</span>
                            <div>
                                @php
                                    $estadoNombre = $ticket->estado?->nombre ?? 'Sin estado';
                                    $estadoColor = match ($estadoNombre) {
                                        'Cerrado' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300',
                                        'En Progreso'
                                            => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300',
                                        'Pausado'
                                            => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300',
                                        'Pendiente'
                                            => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300',
                                        default => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300',
                                    };
                                @endphp

                                <span
                                    class="inline-block rounded-full px-2 py-0.5 text-xs font-medium {{ $estadoColor }}">
                                    {{ $estadoNombre }}
                                </span>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@script
    <script>
        $wire.on("notifyActu", ({
            type,
            message
        }) => {
            Swal.fire({
                icon: type,
                title: 'Ticket',
                text: message,
            });
        });
    </script>

    <script>
        $wire.on("notifyActu", ({
            type,
            message
        }) => {
            Swal.close();
            Swal.fire({
                icon: type,
                title: 'Ticket',
                text: message,
            });
        });
    </script>
@endscript
