<div>
   <div class="overflow-auto">
    <table class="w-full text-sm text-left border-gray-100 mt-4">
        <thead class="bg-gray-50 text-gray-700">
            <tr>
                <th class="px-3 py-2">ID</th>
                <th class="px-3 py-2">Código</th>
                <th class="px-3 py-2">Falla Reportada</th>
                <th class="px-3 py-2">Tipo</th>
                <th class="px-3 py-2">Técnico</th>
                <th class="px-3 py-2">Equipo</th>
                <th class="px-3 py-2">Agencia</th>
                <th class="px-3 py-2">Asignado a</th>
                <th class="px-3 py-2">Creado por</th>
                <th class="px-3 py-2">Estado</th>
                <th class="px-3 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody class="text-gray-800 font-medium">
            @foreach ($tickets as $ticket)
                <tr class="border-t">
                    <td class="p-4 align-middle font-medium">
                        <a href="{{ route('tickets.show', $ticket->id) }}" class="text-blue-500 hover:underline">
                            {{ $ticket->id }}
                        </a>
                    </td>
                    <td class="p-4 align-middle font-medium">
                        <a href="{{ route('tickets.show', $ticket->id) }}" class="text-blue-500 hover:underline">
                            {{ $ticket->codigo ?? $ticket->id }}
                        </a>
                    </td>
                    <td class="py-3 px-4">
                        {{ \Illuminate\Support\Str::limit(empty($ticket->falla_reportada) ? 'Sin información' : $ticket->falla_reportada, 30) }}
                    </td>
                    <td class="py-3 px-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $ticket->tipo === 'ticket' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                            {{ ucfirst($ticket->tipo) }}
                        </span>
                    </td>
                    <td class="py-3 px-4">
                        {{ $ticket->tecnico_nombres ? $ticket->tecnico_nombres . ' ' . $ticket->tecnico_apellidos : 'No asignado' }}
                    </td>
                    <td class="py-3 px-4">
                        @if ($ticket->equipo)
                            {{ \Illuminate\Support\Str::limit($ticket->equipo->serie . ' - ' . $ticket->equipo->modelo, 15) }}
                        @else
                            Sin equipo
                        @endif
                    </td>
                    <td class="py-3 px-4 text-gray-400 italic">
                        {{ $ticket->agencia->nombre ?? 'No especificada' }}
                    </td>
                    <td class="py-3 px-4">
                        {{ $ticket->assignedUser->name ?? 'Asignarme' }}
                    </td>
                    <td class="py-3 px-4">
                        <div class="flex flex-col gap-1 text-gray-800">
                            <div class="flex items-center gap-2">
                                {{ $ticket->createdBy->name ?? 'N/A' }}
                            </div>
                            <span class="text-sm text-gray-500">
                                {{ $ticket->created_at?->format('d/m/Y H:i') ?? 'Sin fecha' }}
                            </span>
                        </div>
                    </td>
                    <td class="py-3 px-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-600">
                            {{ ucfirst($ticket->estado->nombre ?? 'Sin estado') }}
                        </span>
                    </td>
                    <td class="py-3 px-4">
                        <button wire:click="$emit('confirmarAnulacion', {{ $ticket->id }})" class="text-red-500 hover:underline">
                            Anular
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="flex justify-between items-center mt-4">
    <div class="text-sm opacity-50">
        Mostrando {{ $tickets->firstItem() }} a {{ $tickets->lastItem() }} de {{ $tickets->total() }} tickets
    </div>
    <div class="inline-flex rounded-md px-4 py-2">
        {{ $tickets->links('vendor.livewire.custom-tailwind') }}
    </div>
</div>

</div>
