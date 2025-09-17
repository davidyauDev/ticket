<div class="mx-auto max-w-(--breakpoint-2xl) p-4 md:p-6">
    <!-- Breadcrumb Start -->
    <div x-data="{ pageName: `Ticket Reply` }">
        <div class="flex flex-wrap items-center justify-between gap-3 pb-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90" x-text="pageName">Ticket Reply</h2>
            <nav>
                <ol class="flex items-center gap-1.5">
                    <li>
                        <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
                            href="index.html">
                            Home
                            <svg class="stroke-current" width="17" height="16" viewBox="0 0 17 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke="" stroke-width="1.2"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </a>
                    </li>
                    <li class="text-sm text-gray-800 dark:text-white/90" x-text="pageName">Ticket Reply</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Breadcrumb End -->

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
                                Ticket Soporte #{{ $ticket->id }} - {{$ticket->comentario}}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Mon,&nbsp;3:20 PM&nbsp;(2 days ago)
                            </p>
                        </div>
                        <div class="flex items-center gap-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                4 of 120
                            </p>
                            <div class="flex items-center gap-2">
                                <button
                                    class="flex h-8 w-8 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 hover:bg-gray-50 dark:border-gray-800 dark:bg-white/[0.03] dark:text-gray-400 dark:hover:bg-gray-900 dark:hover:text-white/90">
                                    <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12.7083 5L7.5 10.2083L12.7083 15.4167" stroke="" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </button>
                                <button
                                    class="flex h-8 w-8 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 hover:bg-gray-50 dark:border-gray-800 dark:bg-white/[0.03] dark:text-gray-400 dark:hover:bg-gray-900 dark:hover:text-white/90">
                                    <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.29167 15.8335L12.5 10.6252L7.29167 5.41683" stroke=""
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="relative px-6 py-7">

                        <div
                            class="custom-scrollbar h-[calc(58vh-162px)] space-y-7 divide-y divide-gray-200 overflow-y-auto pr-2 dark:divide-gray-800">
                            @forelse($historiales as $item)
                            {{-- {{$item}} --}}
                            <article>
                                <div class="mb-6 flex items-center justify-between">
                                    <div class="flex items-center gap-3">

                                        <span class="mr-3 h-11 w-11 overflow-hidden rounded-full">
                                            <div
                                                class="flex items-center justify-center w-10 h-10 rounded-full bg-brand-100">
                                                <span class="text-xs font-semibold text-brand-500">{{
                                                    $item->usuario->initials() }}</span>
                                            </div>
                                        </span>


                                        <div>
                                            <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                                {{ $item->usuario->name}}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $item->usuario->email}}
                                            </p>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $item->created_at->format('d/m/Y H:i') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="pb-6">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Asignado a {{ $ticket->assignedUser->name}},
                                    </p>
                                    {{-- <p class="mb-5 text-sm text-gray-500 dark:text-gray-400">
                                        I hope you're doing well.
                                    </p> --}}
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{$item->comentario}}
                                    </p>
                                </div>
                            </article>
                            @empty
                            <p class="text-sm text-gray-500">No hay historial disponible para este ticket.</p>
                            @endforelse
                        </div>

                        <!-- Fixed Input Wrapper -->
                        <div class="pt-5">
                            <!-- Container with max width -->
                            <div
                                class="mx-auto max-h-[162px] w-full rounded-2xl border border-gray-200 shadow-xs dark:border-gray-800 dark:bg-gray-800">
                                <!-- Textarea -->
                                <textarea wire:model="comentario" placeholder="Escribe tu comentario aquí..."
                                    class="h-20 w-full resize-none border-none bg-transparent p-5 font-normal text-gray-800 outline-none placeholder:text-gray-400 focus:ring-0 dark:text-white"></textarea>

                                <!-- Bottom Section -->
                                <div class="flex items-center justify-between p-3">
                                    <button
                                        class="flex h-9 items-center gap-1.5 rounded-lg bg-transparent px-2 py-3 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-900 dark:hover:text-gray-300">
                                        <!-- Attach Icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none">
                                            <path
                                                d="M14.4194 11.7679L15.4506 10.7367C17.1591 9.02811 17.1591 6.25802 15.4506 4.54947C13.742 2.84093 10.9719 2.84093 9.2634 4.54947L8.2322 5.58067M11.77 14.4172L10.7365 15.4507C9.02799 17.1592 6.2579 17.1592 4.54935 15.4507C2.84081 13.7422 2.84081 10.9721 4.54935 9.26352L5.58285 8.23002M11.7677 8.23232L8.2322 11.7679"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round"></path>
                                        </svg>
                                        Attach
                                    </button>
                                    <!-- Send Button -->
                                    <button  wire:click="ActualizarTicket" wire:loading.attr="disabled" wire:target="ActualizarTicket" x-data x-on:click="Swal.fire({ 
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

                        <!-- Status -->
                        <div class="mt-6 flex flex-wrap items-center gap-4">
                            <span class="text-gray-500 dark:text-gray-400">Estados:</span>
                            <div x-data="{ selected: 'in-progress' }" class="flex items-center gap-4">
                                <!-- In-Progress -->
                               @foreach($estados as $estado)
    <label for="estado-{{ $estado->id }}" 
           class="flex cursor-pointer items-center text-sm font-medium text-gray-700 select-none dark:text-gray-400">
        <div class="relative">
            <input type="radio" 
                   id="estado-{{ $estado->id }}" 
                   value="{{ $estado->id }}" 
                   x-model="selected" 
                   class="sr-only" 
                   name="selected">
            <div :class="parseInt(selected) === {{ $estado->id }} 
                        ? 'border-brand-500 bg-brand-500' 
                        : 'bg-transparent border-gray-300 dark:border-gray-700'"
                 class="hover:border-brand-500 dark:hover:border-brand-500 mr-3 flex h-4 w-4 items-center justify-center rounded-full border-[1.25px]">
                <span class="h-1.5 w-1.5 rounded-full"
                      :class="parseInt(selected) === {{ $estado->id }} 
                                ? 'bg-white' 
                                : 'bg-white dark:bg-[#171f2e]'"></span>
            </div>
        </div>
        {{ $estado->nombre }}
    </label>
@endforeach

                            </div>
                        </div>
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
                            <span class="text-sm break-words text-gray-700 dark:text-gray-400">{{ $ticket->osticket
                                }}</span>
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
                            <span class="text-sm text-gray-700 dark:text-gray-400">{{ $ticket->tecnico_nombres }}</span>
                        </li>
                        <li class="grid grid-cols-2 gap-5 py-2.5">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Creado</span>
                            <span class="text-sm text-gray-700 dark:text-gray-400">{{ $ticket->created_at->format('M d,
                                Y') }}</span>
                        </li>
                        <li class="grid grid-cols-2 gap-5 py-2.5">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Estado</span>
                            <div>
                                <span
                                    class="bg-blue-light-50 dark:bg-blue-light-500/15 dark:text-blue-light-500 text-theme-xs text-blue-light-500 inline-block rounded-full px-2 py-0.5 font-medium">En
                                    Progreso</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Content End -->
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
            Swal.close(); // Cierra el loader
            Swal.fire({
                icon: type,
                title: 'Ticket',
                text: message,
            });
        });
</script>
@endscript