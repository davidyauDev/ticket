<div>
    <flux:separator variant="subtle" class="my-4" />

    <div class="flex flex-col lg:flex-row gap-4 lg:gap-6">
        <flux:spacer />
    </div>
    <div class="flex justify-between items-center mb-6 flex-wrap gap-4">
    </div>

    <div class="flex gap-6 mb-6">
        @foreach ($stats as $stat)
        <div class="relative flex-1 rounded-lg px-6 py-4 bg-zinc-50 dark:bg-zinc-700
                {{ $loop->iteration > 1 ? 'max-md:hidden' : '' }}
                {{ $loop->iteration > 3 ? 'max-lg:hidden' : '' }}">

            <flux:subheading>{{ $stat['title'] }}</flux:subheading>

            <flux:heading size="xl" class="mb-2">
                {{ $stat['value'] }}
            </flux:heading>

            <div class="flex items-center gap-1 font-medium text-sm
                    {{ $stat['trendUp'] ? 'text-green-600 dark:text-green-400' : 'text-red-500 dark:text-red-400' }}">

                <flux:icon :icon="$stat['trendUp'] ? 'arrow-trending-up' : 'arrow-trending-down'" variant="micro" />
                {{ $stat['trend'] }}
            </div>

            <div class="absolute top-0 right-0 pr-2 pt-2">
                <flux:button icon="ellipsis-horizontal" variant="subtle" size="sm" />
            </div>
        </div>
        @endforeach
    </div>
    <div class="mb-4 flex justify-between items-center gap-4">
        <flux:input wire:model.live="search" as="text" variant="filled" placeholder="Search..." icon="magnifying-glass" />
        <flux:button icon="plus" variant="primary">Agregar Nuevo Usuario</flux:button>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Email</th>
                    <th scope="col" class="px-6 py-3">Firstname</th>
                    <th scope="col" class="px-6 py-3">Lastname</th>
                    <th scope="col" class="px-6 py-3">DNI</th>
                    <th scope="col" class="px-6 py-3">Created At</th>
                    <th scope="col" class="px-6 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $user->name }}</td>
                    <td class="px-6 py-4">{{ $user->email }}</td>
                    <td class="px-6 py-4">{{ $user->firstname }}</td>
                    <td class="px-6 py-4">{{ $user->lastname }}</td>
                    <td class="px-6 py-4">{{ $user->dni }}</td>
                    <td class="px-6 py-4">{{ $user->created_at }}</td>
                    <td class="px-6 py-4 flex items-center">
                        <flux:icon.pencil class="mr-2" />
                        <flux:icon.trash />
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-5 flex justify-between items-center">
              <!-- Información de items con estilos personalizados -->
              <div class="text-sm ml-3 opacity-50 mb-2">
                Mostrando {{ $users->firstItem() }} a {{ $users->lastItem() }} de {{ $users->total() }} usuarios
            </div>
            <!-- Paginación -->
            <div class="inline-flex rounded-md px-4 py-2 mb-2">
                {{ $users->links('vendor.livewire.custom-tailwind') }}
            </div>
        </div>
        </div>
    </div>
</div>
