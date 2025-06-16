<div class="space-y-6">
    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-sm text-muted-foreground">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h4" />
        </svg>
        <a href="{{ route('dashboard') }}" class="hover:underline text-gray-600">Dashboard</a>
        <span class="text-gray-400">›</span>
        <span class="text-black font-medium">Gestión de Tickets</span>
    </div>

    <!-- Título -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Gestión de Tickets</h1>
    </div>

    <!-- Filtros y botón -->
    <div class="mb-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex gap-2 w-full sm:w-auto">
            <input type="text" placeholder="Buscar por consulta..."
                class="w-full sm:w-64 px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-black"
                wire:model.debounce.500ms="search">

            <select wire:model="typeFilter"
                class="appearance-none border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-black">
                <option value="">Filtrar por tipo</option>
                <option value="Consulta">Consulta</option>
                <option value="Reclamo">Reclamo</option>
                <option value="Soporte">Soporte</option>
            </select>

            <button wire:click="create"
                class="bg-black text-white px-4 py-2 rounded-md text-sm font-medium flex items-center gap-1 hover:bg-gray-800">
                <span class="text-lg leading-none">+</span> Nueva Llamada
            </button>
        </div>
    </div>

    <!-- Tabla -->
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm border">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-2 font-semibold">Motivo</th>
                    <th class="px-4 py-2 font-semibold">Consulta</th>
                    <th class="px-4 py-2 font-semibold">Usuario</th>
                    <th class="px-4 py-2 font-semibold">Técnico</th>
                    <th class="px-4 py-2 font-semibold">Fecha y Hora</th>
                    <th class="px-4 py-2 font-semibold">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($callLogs as $log)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $log->option->label ?? '' }}</td>
                    <td class="px-4 py-2">{{ $log->description }}</td>
                    <td class="px-4 py-2">{{ $log->user->name }}</td>
                    <td class="px-4 py-2">{{ $log->tecnico->lastname ?? '' }} {{ $log->tecnico->firstname ?? '' }}</td>
                    <td class="px-4 py-2">{{ $log->created_at->format('d/m/Y, H:i:s') }}</td>
                    <td class="px-4 py-2 flex gap-2">
                        <button wire:click="edit({{ $log->id }})" class="text-black-500 hover:text-black-700">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-user-round-pen-icon lucide-user-round-pen">
                                <path d="M2 21a8 8 0 0 1 10.821-7.487" />
                                <path
                                    d="M21.378 16.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z" />
                                <circle cx="10" cy="8" r="5" />
                            </svg>
                        </button>
                        {{-- <button wire:click="delete({{ $log->id }})" class="text-red-500 hover:text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-user-x-icon lucide-user-x">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <line x1="17" x2="22" y1="8" y2="13" />
                                <line x1="22" x2="17" y1="8" y2="13" />
                            </svg>
                        </button> --}}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-4 text-center text-gray-500">No se encontraron registros.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-5 flex flex-col sm:flex-row justify-between items-start sm:items-center ml-2 text-sm opacity-70">
            <div class="mb-2 sm:mb-0">
                Mostrando {{ $callLogs->firstItem() }} a {{ $callLogs->lastItem() }} de {{ $callLogs->total() }}
                registros
            </div>
            <div class="inline-flex rounded-md px-4 py-2">
                {{ $callLogs->links('vendor.livewire.custom-tailwind') }}
            </div>
        </div>
    </div>



    <!-- Modal -->
    <x-modal wire:model="showModal" class="w-full">
        <div class="bg-white rounded-lg p-6 w-full space-y-4">
            <h3 class="text-lg font-semibold">Registrar Nueva Llamada</h3>

            <!-- Tipo -->
            <div>
                <label class="block text-sm font-medium mb-1">Motivo</label>
                <select wire:model.defer="form.option_id"
                    class="w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-black">
                    <option value="">Seleccione un motivo</option>
                    @foreach ($seguimientoOpciones as $opcion)
                    <option value="{{ $opcion->id }}">{{ $opcion->label }}</option>
                    @endforeach
                </select>
                @error('form.option_id') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>


            <!-- Técnico con búsqueda -->
            <div x-data="{
                search: '',
                open: false,
                select(user) {
                    this.search = `${user.lastname} ${user.firstname}`;
                    this.open = false;
                    $wire.set('form.tecnico_id', user.id);
                },
                filtered() {
                    return @js($tecnicos).filter(user =>
                        (`${user.lastname} ${user.firstname}`).toLowerCase().includes(this.search.toLowerCase())
                    );
                },
                reset() { this.search = ''; },
                init() {
                    Livewire.on('reset-tecnico', () => this.reset());
                    this.search = @js($form['tecnico_id'] ? optional($tecnicos->firstWhere('id', $form['tecnico_id']))->lastname . ' ' . optional($tecnicos->firstWhere('id', $form['tecnico_id']))->firstname : '');
                }
            }" x-init="init" class="relative w-full">
                <label class="block text-sm font-medium text-gray-700 mb-1">Técnico</label>
                <input type="text" x-model="search" @focus="open = true" @click.away="open = false"
                    placeholder="Buscar técnico..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black" />

                <div x-show="open && filtered().length > 0"
                    class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-auto">
                    <template x-for="user in filtered()" :key="user.id">
                        <div @click="select(user)" class="px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm">
                            <span x-text="user.lastname"></span>
                            <span x-text="' ' + user.firstname"></span>
                        </div>
                    </template>
                </div>

                @error('form.tecnico_id') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <!-- Descripción -->
            <div>
                <label class="block text-sm font-medium mb-1">Detalle de la Consulta</label>
                <textarea wire:model.defer="form.description"
                    class="w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-black"
                    rows="3"></textarea>
                @error('form.description') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <!-- Acciones -->
            <div class="flex justify-end gap-3 pt-4">
                <button wire:click="$set('showModal', false)"
                    class="px-5 py-2.5 rounded-md bg-gray-100 text-gray-800 hover:bg-gray-200 transition">
                    Cancelar
                </button>
                <button wire:click="store" wire:loading.attr="disabled"
                    class="px-5 py-2.5 rounded-md bg-black text-white hover:bg-gray-800 transition">
                    Guardar
                </button>
            </div>
        </div>
    </x-modal>
</div>

@script
<script>
    $wire.on("saved", () => {
        Swal.fire({ icon: 'success', title: 'Llamada', text: 'Registrado exitosamente' });
    });
</script>
@endscript