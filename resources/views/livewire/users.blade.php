<div>
    <flux:separator variant="subtle" class="my-4" />

    <div class="flex flex-col lg:flex-row gap-4 lg:gap-6">
        <flux:spacer />
    </div>
    <div class="flex justify-between items-center mb-6 flex-wrap gap-4">
        <!-- Selects de rango de fechas -->
        <div class="flex items-center flex-wrap gap-2">
            <select class="text-sm px-3 py-1.5 rounded border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800">
                <option>Last 7 days</option>
                <option>Last 14 days</option>
                <option selected>Last 30 days</option>
                <option>Last 60 days</option>
                <option>Last 90 days</option>
            </select>

            <span class="text-sm text-zinc-600 dark:text-zinc-300 max-md:hidden whitespace-nowrap">compared to</span>

            <select
                class="text-sm px-3 py-1.5 rounded border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 max-md:hidden">
                <option selected>Previous period</option>
                <option>Same period last year</option>
                <option>Last month</option>
                <option>Last quarter</option>
                <option>Last 6 months</option>
                <option>Last 12 months</option>
            </select>
            <!-- Separador -->
            <div class="h-6 w-px bg-zinc-300 dark:bg-zinc-600 mx-2 my-1 max-lg:hidden"></div>
            <!-- Filtros -->
            <div class="flex items-center gap-2 max-lg:hidden">
                <span class="text-sm text-zinc-600 dark:text-zinc-300 whitespace-nowrap">Filter by:</span>

                <button class="flex items-center gap-1 px-3 py-1 rounded-full bg-zinc-100 dark:bg-zinc-700 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor">
                        <!-- icon plus -->
                    </svg>
                    Amount
                </button>

                <button
                    class="flex items-center gap-1 px-3 py-1 rounded-full bg-zinc-100 dark:bg-zinc-700 text-sm max-md:hidden">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor">
                        <!-- icon plus -->
                    </svg>
                    Status
                </button>

                <button class="flex items-center gap-1 px-3 py-1 rounded-full bg-zinc-100 dark:bg-zinc-700 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor">
                        <!-- icon plus -->
                    </svg>
                    More filters...
                </button>
            </div>
        </div>

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

    <div class="mb-4">
        <input type="text" wire:model="search" placeholder="Search by name..." 
               class="text-sm px-3 py-1.5 rounded border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 w-full" />
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
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-6 flex justify-center">
            <div class="inline-flex rounded-md shadow px-4 py-2">
                {{ $users->links() }}
            </div>
        </div>


    </div>
</div>
