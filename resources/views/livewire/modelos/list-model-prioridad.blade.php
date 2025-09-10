<div class="space-y-6 p-5">
  <div class="overflow-x-auto">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Gestión de Responsables por Modelo</h3>
      </div>

      <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-5">
          <div class="overflow-hidden">
            <!-- Toolbar -->
            <div class="flex flex-col gap-2 px-4 py-4 border border-b-0 border-gray-200 rounded-b-none rounded-xl dark:border-gray-800 sm:flex-row sm:items-center sm:justify-between">
              <div class="flex items-center gap-3">
                <span class="text-gray-500 dark:text-gray-400">Mostrar</span>

                <div class="relative z-20 bg-transparent">
                  <select wire:model.live="perPage"
                          class="w-full py-2 pl-3 pr-8 text-sm text-gray-800 bg-transparent border border-gray-300 rounded-lg appearance-none dark:bg-dark-900 h-9 bg-none shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800 text-gray-500 dark:text-gray-400">
                    <option class="text-gray-500 dark:bg-gray-900 dark:text-gray-400" value="10">10</option>
                    <option class="text-gray-500 dark:bg-gray-900 dark:text-gray-400" value="8">8</option>
                    <option class="text-gray-500 dark:bg-gray-900 dark:text-gray-400" value="5">5</option>
                  </select>
                  <span class="absolute z-30 text-gray-500 -translate-y-1/2 pointer-events-none right-2 top-1/2 dark:text-gray-400">
                    <svg class="stroke-current" width="16" height="16" viewBox="0 0 16 16" fill="none">
                      <path d="M3.8335 5.9165L8.00016 10.0832L12.1668 5.9165" stroke="" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                  </span>
                </div>

                <span class="text-gray-500 dark:text-gray-400">registros</span>
              </div>

              <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <div class="relative">
                  <button class="absolute text-gray-500 -translate-y-1/2 left-4 top-1/2 dark:text-gray-400">
                    <x-icons.search />
                  </button>
                  <input wire:model.live="search" type="text" placeholder="Buscar modelo..."
                         class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pl-11 pr-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800 xl:w-[300px]">
                </div>

                <button wire:click="$refresh"
                        class="flex w-full items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-[11px] text-sm font-medium text-gray-700 shadow-theme-xs dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 sm:w-auto">
                  Actualizar
                </button>
              </div>
            </div>

            <!-- Tabla -->
            <div class="max-w-full overflow-x-auto">
              <table class="w-full min-w-full">
                <thead>
                  <tr>
                    <th class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                      <div class="flex items-center justify-between w-full cursor-pointer">
                        <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">Equipo</p>
                      </div>
                    </th>
                    <th class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                      <div class="flex items-center justify-between w-full cursor-pointer">
                        <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">Ing. a cargo</p>
                      </div>
                    </th>
                    <th class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                      <div class="flex items-center justify-between w-full cursor-pointer">
                        <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">Asistente 1</p>
                      </div>
                    </th>
                    <th class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                      <div class="flex items-center justify-between w-full cursor-pointer">
                        <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">Asistente 2</p>
                      </div>
                    </th>
                    <th class="px-4 py-3 text-left border border-gray-100 dark:border-gray-800">
                      <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">Acción</p>
                    </th>
                  </tr>
                </thead>

                <tbody>
                  @forelse ($rows as $r)
                    <tr>
                      <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                        <p class="text-gray-700 text-theme-sm dark:text-gray-400">{{ $r->modelo }}</p>
                      </td>
                      <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                        <p class="text-gray-700 text-theme-sm dark:text-gray-400">{{ $r->ing_a_cargo ?? '—' }}</p>
                      </td>
                      <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                        <p class="text-gray-700 text-theme-sm dark:text-gray-400">{{ $r->asistente_1 ?? '—' }}</p>
                      </td>
                      <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                        <p class="text-gray-700 text-theme-sm dark:text-gray-400">{{ $r->asistente_2 ?? '—' }}</p>
                      </td>
                      <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                        <div class="flex items-center w-full gap-2">
                          <button wire:click="edit({{ $r->id }})"
                                  class="text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white/90">
                            <x-icons.edit />
                          </button>
                        </div>
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

            <!-- Footer paginado -->
            <div class="border border-t-0 rounded-b-xl border-gray-100 py-4 pl-[18px] pr-4 dark:border-gray-800">
              <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between">
                <p class="pb-3 text-sm font-medium text-center text-gray-500 border-b border-gray-100 dark:border-gray-800 dark:text-gray-400 xl:border-b-0 xl:pb-0 xl:text-left">
                  Mostrando {{ $rows->firstItem() }} a {{ $rows->lastItem() }} de {{ $rows->total() }} registros
                </p>
                {{ $rows->links('vendor.livewire.custom-tailwind') }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <x-modal wire:model="showModal" class="w-full max-w-lg mx-auto">
    <div class="bg-white rounded-lg p-6 w-full space-y-4">
      <h3 class="text-lg font-semibold">Asignar Responsables</h3>

      <div>
        <label class="block text-sm font-medium mb-1">Ing. a cargo</label>
        <select wire:model.defer="form.ing_a_cargo" class="w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-black">
          <option value="">Seleccione</option>
          @foreach ($users as $u)
            <option value="{{ $u->id }}">{{ $u->name }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium mb-1">Asistente 1</label>
        <select wire:model.defer="form.asistente_1" class="w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-black">
          <option value="">Seleccione</option>
          @foreach ($users as $u)
            <option value="{{ $u->id }}">{{ $u->name }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium mb-1">Asistente 2</label>
        <select wire:model.defer="form.asistente_2" class="w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-black">
          <option value="">Seleccione</option>
          @foreach ($users as $u)
            <option value="{{ $u->id }}">{{ $u->name }}</option>
          @endforeach
        </select>
      </div>

      <div class="flex justify-end gap-3 pt-4">
        <button wire:click="$set('showModal', false)" class="px-5 py-2.5 rounded-md bg-gray-100 text-gray-800 hover:bg-gray-200 transition">Cancelar</button>
        <button wire:click="update" wire:loading.attr="disabled" class="px-5 py-2.5 rounded-md bg-black text-white hover:bg-gray-800 transition">Guardar</button>
      </div>
    </div>
  </x-modal>
</div>

@script
<script>
  $wire.on("saved", () => {
    Swal.fire({ icon: 'success', title: 'Responsables', text: 'Asignación guardada' });
  });
</script>
@endscript
