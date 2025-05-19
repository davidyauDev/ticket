<div>
  <div class="rounded-lg border bg-white text-gray-800 shadow-sm p-6">
    <div class="mb-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="text-xl font-semibold">Registro de Llamadas</h2>
        <div class="flex gap-2 w-full sm:w-auto">
            <input type="text" placeholder="Buscar por consulta..."
                class="w-full sm:w-64 px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-black"
                wire:model.debounce.500ms="search">
            <div class="relative">
                <select wire:model="typeFilter"
                    class="appearance-none border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-black">
                    <option value="">Filtrar por tipo</option>
                    <option value="Consulta">Consulta</option>
                    <option value="Reclamo">Reclamo</option>
                    <option value="Soporte">Soporte</option>
                </select>
            </div>
            <button wire:click="create"
                class="bg-black text-white px-4 py-2 rounded-md text-sm font-medium flex items-center gap-1">
                <span class="text-lg leading-none">+</span> Nueva Llamada
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-2 font-semibold">Tipo</th>
                    <th class="px-4 py-2 font-semibold">Consulta</th>
                    <th class="px-4 py-2 font-semibold">Usuario</th>
                    <th class="px-4 py-2 font-semibold">Fecha y Hora</th>
                    <th class="px-4 py-2 font-semibold">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($callLogs as $log)
                    <tr class="border-t">
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                {{
                                    $log->type === 'Consulta' ? 'bg-black text-white' :
                                    ($log->type === 'Reclamo' ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-800')
                                }}">
                                {{ $log->type }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $log->description }}</td>
                        <td class="px-4 py-2">{{ $log->user->name }}</td>
                        <td class="px-4 py-2">{{ $log->created_at->format('d/m/Y, H:i:s') }}</td>
                        <td class="px-4 py-2 flex gap-2">
                            <button wire:click="edit({{ $log->id }})"
                                class="text-blue-500 hover:text-blue-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13l6-6 3 3-6 6H9v-3z" />
                                </svg>
                            </button>
                            <button wire:click="delete({{ $log->id }})"
                                class="text-red-500 hover:text-red-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-gray-500">No se encontraron registros.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
@if ($showModal)
    <div class="fixed inset-0 flex items-center justify-center z-50 bg-black opacity-75">
        
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold mb-4">Registrar Nueva Llamada</h3>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Tipo de Llamada</label>
                    <select wire:model.defer="form.type"
                        class="w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-black">
                        <option value="Consulta">Consulta</option>
                        <option value="Reclamo">Reclamo</option>
                        <option value="Soporte">Soporte</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Usuario que Registra</label>
                    <select wire:model.defer="form.user_id"
                        class="w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-black">
                        <option value="">Selecciona un usuario</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Detalle de la Consulta</label>
                    <textarea wire:model.defer="form.description"
                        class="w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-black"
                        rows="3"></textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-2">
                <button wire:click="$set('showModal', false)"
                    class="px-4 py-2 text-sm rounded-md border border-gray-300">Cancelar</button>
                <button wire:click="store"
                    class="px-4 py-2 text-sm rounded-md bg-black text-white font-medium">Guardar</button>
            </div>
        </div>
    </div>
@endif

</div>
