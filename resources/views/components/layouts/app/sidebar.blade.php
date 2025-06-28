<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="">
    <div class="flex h-screen overflow-hidden">
        <aside x-data="{ sidebarToggle: false, selected: '' }"
            :class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full lg:translate-x-0'"
            class="fixed left-0 top-0 z-50 flex h-screen w-[290px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 dark:border-gray-800 dark:bg-black lg:static lg:translate-x-0">
            <!-- Sidebar Header -->
            <div :class="sidebarToggle ? 'justify-center' : 'justify-between'"
                class="flex items-center gap-2 pt-8 pb-7">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                    <span class="logo" :class="sidebarToggle ? 'hidden' : ''">
                        <img src="{{ asset('storage/images/image.png') }}" alt="Logo" class="dark:hidden" />
                    </span>
                </a>
                <button @click="sidebarToggle = !sidebarToggle" class="lg:hidden">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
            <!-- Sidebar Menu -->
            <nav class="flex-1 overflow-y-auto">
                <!-- Estadísticas -->
                <div class="mb-6">
                    <p class="mb-4 text-xs uppercase text-gray-400">Estadísticas</p>
                    <a href="{{ route('tickets.estadisticas') }}"
                        class="flex items-center p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-zinc-800 {{ request()->routeIs('tickets.estadisticas') ? 'bg-gray-100 dark:bg-zinc-800' : '' }}"
                        wire:navigate>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-chart-no-axes-column-increasing-icon lucide-chart-no-axes-column-increasing">
                            <line x1="12" x2="12" y1="20" y2="10" />
                            <line x1="18" x2="18" y1="20" y2="4" />
                            <line x1="6" x2="6" y1="20" y2="16" />
                        </svg>
                        <span class="ml-2" :class="sidebarToggle ? 'hidden lg:block' : ''">Estadísticas de
                            Tickets</span>
                    </a>
                </div>
                <div class="mb-4">
                    <a href="{{ route('call-logs.dashboard') }}"
                        class="flex items-center p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-zinc-800 {{ request()->routeIs('call-logs.dashboard') ? 'bg-gray-100 dark:bg-zinc-800' : '' }}"
                        wire:navigate>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-chart-no-axes-column-increasing-icon lucide-chart-no-axes-column-increasing">
                            <line x1="12" x2="12" y1="20" y2="10" />
                            <line x1="18" x2="18" y1="20" y2="4" />
                            <line x1="6" x2="6" y1="20" y2="16" />
                        </svg>
                        <span class="ml-2" :class="sidebarToggle ? 'hidden lg:block' : ''">Estadísticas de
                            Llamadas</span>
                    </a>
                </div>
                <!-- Usuarios (Admin) -->
                @if(auth()->user()?->role === 'admin')
                <div class="mb-6">
                    <p class="mb-4 text-xs uppercase text-gray-400">Users</p>
                    <a href="{{ route('users.index') }}"
                        class="flex items-center p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-zinc-800 {{ request()->routeIs('users.*') ? 'bg-gray-100 dark:bg-zinc-800' : '' }}"
                        wire:navigate>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-users-round-icon lucide-users-round">
                            <path d="M18 21a8 8 0 0 0-16 0" />
                            <circle cx="10" cy="8" r="5" />
                            <path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3" />
                        </svg>
                        <i class="fa-solid fa-users mr-2"></i>
                        <span :class="sidebarToggle ? 'hidden lg:block' : ''">Users</span>
                    </a>
                </div>
                @endif
                <!-- Tickets -->
                <div class="mb-6">
                    <p class="mb-4 text-xs uppercase text-gray-400">Tickets</p>
                    <a href="{{ route('tickets.index') }}"
                        class="flex items-center p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-zinc-800 {{ request()->routeIs('tickets.index') ? 'bg-gray-100 dark:bg-zinc-800' : '' }}"
                        wire:navigate>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-clipboard-minus-icon lucide-clipboard-minus">
                            <rect width="8" height="4" x="8" y="2" rx="1" ry="1" />
                            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                            <path d="M9 14h6" />
                        </svg>
                        <i class="fa-solid fa-ticket mr-2"></i>
                        <span class="ml-2" :class="sidebarToggle ? 'hidden lg:block' : ''">Tickets</span>
                    </a>

                    <a href="{{ route('call-logs.index') }}"
                        class="flex items-center p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-zinc-800 {{ request()->routeIs('call-logs.index') ? 'bg-gray-100 dark:bg-zinc-800' : '' }}"
                        wire:navigate>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-phone-icon lucide-phone">
                            <path
                                d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384" />
                        </svg>
                        <i class="fa-solid fa-phone mr-2"></i>
                        <span class="ml-2" :class="sidebarToggle ? 'hidden lg:block' : ''">Llamadas</span>
                    </a>
                </div>
            </nav>
        </aside>
        <!-- Main Content -->
        <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
            <main>
                <div class="  ">
                    <div >
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>

    </div>
    <!-- Sidebar -->


    @fluxScripts
</body>

</html>