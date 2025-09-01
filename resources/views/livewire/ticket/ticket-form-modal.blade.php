<div>
    <x-modal wire:model="showModal" class="w-full max-w-4xl">
        <div class="p-6">
            <!-- Encabezado -->
            <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2 mb-1">
                <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Crear Nuevo Ticket de Llamada
            </h2>
            <p class="text-sm text-gray-500 mb-4">Completa los datos para registrar el ticket.</p>
            <hr class="mb-6">
            @if ($errors->any())
                <div class="p-3 mb-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- Formulario -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Columna 1 -->
                <div class="bg-white border rounded-lg shadow p-4 space-y-4">
                    <p class="text-sm font-semibold text-gray-600">Información general</p>
                    <!-- Tipo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                        <flux:select wire:model.live="tipoTicket" placeholder="Seleccionar tipo">
                            <flux:select.option value="ticket">Ticket</flux:select.option>
                            <flux:select.option value="consulta">Consulta</flux:select.option>
                        </flux:select>
                        @error('tipoTicket')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    @if ($tipoTicket == 'ticket')
                        <!-- Código -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Código del ticket</label>
                            <div class="grid grid-cols-3 gap-2">
                                <input wire:model="codigoInput"
                                    class="col-span-2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black"
                                    placeholder="Código">
                                <button wire:click="buscarTicket" wire:loading.attr="disabled"
                                    class="col-span-1 px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800 flex justify-center items-center gap-1">
                                    <span>Buscar</span>
                                </button>
                            </div>
                            @error('codigoInput')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                            @error('ticketError')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                    <!-- Datos del ticket -->
                    @if ($ticketData)
                        <div class="bg-gray-100 p-3 rounded-lg shadow text-sm text-gray-800">
                            <h3 class="text-base font-semibold mb-2">Ticket {{ $ticketData['number'] ?? '' }}</h3>
                            <p><strong>Asunto:</strong> {{ $ticketData['subject'] ?? '' }}</p>
                            <p><strong>Falla reportada:</strong> {{ $ticketData['falla_reportada'] ?? '' }}</p>
                            <p><strong>Equipo:</strong> {{ $ticketData['serie'] ?? '' }} - {{ $ticketData['modelo'] ?? '' }}</p>
                            <p><strong>Usuario:</strong> {{ $ticketData['nombres'] ?? '' }} {{ $ticketData['apellidos'] ?? '' }}
                            </p>
                            <p><strong>Agencia:</strong> {{ $ticketData['agencia'] ?? '' }}</p>
                            <p><strong>Cliente:</strong> {{ $ticketData['cliente'] ?? '' }}</p>
                            <p><strong>Empresa:</strong> {{ $ticketData['empresa'] ?? '' }}</p>
                        </div>
                    @endif
                </div>
                <!-- Columna 2 -->
                <div class="bg-white border rounded-lg shadow p-4 space-y-4">
                    <p class="text-sm font-semibold text-gray-600">Detalles del Ticket</p>
                    <!-- Estado -->
                    <div>
                        {{-- <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                        <flux:select wire:model.live="estado_id" placeholder="Seleccionar estado">
                            @foreach ($estados as $estado)
                            <flux:select.option value="{{ $estado->id }}">{{ $estado->nombre }}</flux:select.option>
                            @endforeach
                        </flux:select> --}}
                        @error('estado_id')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    @if ($estado_id == 2)
                        <!-- Área principal -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Área</label>
                            <flux:select wire:model.live="selectedArea" placeholder="Seleccione un área...">
                                @foreach ($areas as $area)
                                    <flux:select.option value="{{ $area['id'] }}">{{ $area['nombre'] }}
                                    </flux:select.option>
                                @endforeach
                            </flux:select>
                            @error('selectedArea')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Subárea (solo si hay área seleccionada) -->
                        @if (!empty($subareas))
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Subárea</label>
                                <flux:select wire:model.live="selectedSubarea" placeholder="Seleccione una subárea...">
                                    @foreach ($subareas as $sub)
                                        <flux:select.option value="{{ $sub['id'] }}">{{ $sub['nombre'] }}
                                        </flux:select.option>
                                    @endforeach
                                </flux:select>
                                @error('selectedSubarea')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif
                    @endif
                    <!-- Observación -->
                    @if ($tipoTicket == 'ticket')
                        {{-- <div x-data="{
                        open: false,
                        search: '',
                        filtered() {
                            return @js($observaciones).filter(obs =>
                                obs.descripcion.toLowerCase().includes(this.search.toLowerCase())
                            );
                        },
                        select(obs) {
                            this.search = obs.descripcion;
                            this.open = false;
                            $wire.set('observacion', obs.id);
                        }
                    }" class="relative">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Observación</label>

                        <input type="text" x-model="search" @focus="open = true" @click.away="open = false"
                            placeholder="Buscar observación..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black" />
                        <!-- Lista de sugerencias -->
                        <div x-show="open && filtered().length > 0"
                            class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-auto">
                            <template x-for="obs in filtered()" :key="obs.id">
                                <div @click="select(obs)" class="cursor-pointer px-4 py-2 hover:bg-gray-100">
                                    <span x-text="obs.descripcion"></span>
                                </div>
                            </template>
                        </div>
                        @error('observacion') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div> --}}
                    @else
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Observación</label>
                            <textarea wire:model="observacion"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black"
                                placeholder="Escribe una observación..."></textarea>
                            @error('observacion')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                    <!-- Derivar -->
                    <div class="flex items-center mt-4 space-x-2">
                        <input type="checkbox" id="derivar" wire:model.live="derivar"
                            class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500"  />
                        <label for="derivar" class="text-sm text-gray-700">
                            Derivar este ticket
                        </label>
                    </div>

                    @if ($derivar)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Motivo de derivación</label>
                            <select wire:model="motivo_derivacion"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black">
                                <option value="">Seleccione un motivo</option>
                                @foreach ($motivosDerivacion as $motivo)
                                    <option value="{{ $motivo }}">{{ $motivo }}</option>
                                @endforeach
                            </select>
                            @error('motivo_derivacion')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif

                    <!-- Soporte -->
                    @if (!$derivar)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Soporte</label>
                            <select wire:model="tipoSoporte"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black">
                                <option value="">Seleccione un tipo de soporte</option>
                                @foreach ($soporte as $tipo)
                                    <option value="{{ $tipo['id'] }}">{{ $tipo['nombre'] }}</option>
                                @endforeach
                            </select>
                            @error('tipoSoporte')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif

                    <!-- Comentario -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Comentario</label>
                        <textarea rows="4" wire:model="comentario"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black"
                            placeholder="Detalles adicionales..."></textarea rows="4">
                        @error('comentario')
    <span class="text-red-600 text-sm">{{ $message }}</span>
@enderror
                    </div>
                  
                     @if (!$derivar)
<div class="flex items-center mt-4 space-x-2">
                        <input type="checkbox" id="resuelto" wire:model="resueltoAlCrear"
                            class="form-checkbox h-5 w-5 text-green-600 rounded border-gray-300 focus:ring-green-500" />
                        <label for="resuelto" class="text-sm text-gray-700">
                            Registrar llamada como resuelta
                        </label>
                    </div>
@endif
                    <!-- Archivo adjunto -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Archivo adjunto</label>
                        <label for="archivo"
                            class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-lg cursor-pointer bg-gray-50 border-gray-300 hover:bg-gray-100 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400 mb-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828L18 9.828a4 4 0 10-5.656-5.656l-8.486 8.486a6 6 0 108.486 8.486l7.07-7.07" />
                            </svg>
                            <span class="text-sm text-gray-600 font-medium">Arrastra o haz clic para subir
                                archivo</span>
                            <span class="text-xs text-gray-400">{{ $archivoNombre ?: 'Ningún archivo seleccionado' }}</span>
                            <input id="archivo" type="file" wire:model="archivo" class="hidden" />
                        </label>
                        @error('archivo')
    <span class="text-red-600 text-sm">{{ $message }}</span>
@enderror
                        <div wire:loading wire:target="archivo" class="text-sm text-gray-500 mt-1">Subiendo archivo...
                        </div>
                    </div>
                </div>
            </div>
            <!-- Botones -->
            <div class="flex justify-end gap-2 mt-6">
                <button wire:click="$set('showModal', false)"
                    class="px-5 py-2.5 bg-gray-100 text-gray-800 rounded-md hover:bg-gray-200">
                    Cancelar
                </button>
                <button wire:click="registrarTicket" wire:loading.attr="disabled"
                    class="px-5 py-2.5 bg-black text-white rounded-md hover:bg-gray-900">
                    Guardar Llamada
                </button>
            </div>
        </div>
    </x-modal>
</div>

