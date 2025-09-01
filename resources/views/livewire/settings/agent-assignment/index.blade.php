<div class="p-6">
    <div class="flex border-b mb-4">
        @foreach($this->availableTabs as $tabKey)
            <button wire:click="switchTab('{{ $tabKey }}')"
                class="px-4 py-2 font-semibold focus:outline-none {{ $tab === $tabKey ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-500' }}">
                @if($tabKey === 'agentes') Cima
                @elseif($tabKey === 'asignaciones') Monedas
                @elseif($tabKey === 'historial') Maquinas Chicas
                @else {{ ucfirst($tabKey) }}
                @endif
            </button>
        @endforeach
    </div>

    @if(session()->has('error'))
    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
        {{ session('error') }}
    </div>
    @endif

    @if(session()->has('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
        {{ session('success') }}
    </div>
    @endif
    <ul class="space-y-3">
        @forelse($users as $index => $user)
        <li wire:key="{{ $tab }}-{{ $user['id'] }}" class="p-4 bg-gray-50 rounded-lg flex justify-between items-center">
            <div class="flex items-center gap-4">
                <span class="font-semibold">{{ $user['name'] }}</span>

                <label for="toggle{{ $tab }}{{ $index }}"
                    class="flex cursor-pointer select-none items-center gap-3 text-sm font-medium text-gray-700 dark:text-gray-400 relative">
                    <input type="checkbox" id="toggle{{ $tab }}{{ $index }}" class="sr-only"
                        wire:model.defer="usersByTab.{{ $tab }}.{{ $index }}.available" {{ $user['available']
                        ? 'checked' : '' }}>
                    <div
                        class="toggle-bg block h-6 w-11 rounded-full bg-gray-400 dark:bg-gray-600 transition-colors duration-300 ease-in-out">
                    </div>
                    <div
                        class="dot absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white shadow-theme-sm transition-transform duration-300 ease-in-out">
                    </div>
                    <span>{{ $user['available'] ? 'Disponible' : 'No disponible' }}</span>
                </label>
            </div>

            <div>
                <label class="text-sm mr-2">Prioridad:</label>
                <select wire:model.defer="usersByTab.{{ $tab }}.{{ $index }}.priority"
                    class="border rounded px-2 py-1 text-sm">
                    <option value="">Seleccionar</option>
                    <option value="1">Primero</option>
                    <option value="2">Segundo</option>
                    <option value="3">Tercero</option>
                </select>
            </div>
        </li>
        @empty
        <li class="p-3 bg-gray-50 rounded">
            No hay agentes en esta área.
        </li>
        @endforelse
    </ul>

    <div class="mt-6">
        <button wire:click="saveUsers" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Guardar Cambios
        </button>
    </div>
    <style>
        input:checked+.toggle-bg {
            background-color: #4ade80;
            /* Verde activado */
        }

        input:checked+.toggle-bg+.dot {
            transform: translateX(100%);
            /* Mueve el círculo */
        }
        .dot {
            transition: transform 0.3s ease;
        }
    </style>
</div>