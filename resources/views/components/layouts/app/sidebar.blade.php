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
                        <span class="ml-2" :class="sidebarToggle ? 'hidden lg:block' : ''">
                            Tickets</span>
                    </a>

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
                        <span class="ml-2" :class="sidebarToggle ? 'hidden lg:block' : ''">
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

                    <a href="{{ route('tickets.index') }}" wire:navigate
                        class="menu-item group {{ request()->routeIs('tickets.index') ? 'bg-gray-100 dark:bg-zinc-800' : '' }}">

                        <!-- Icono con cambio de color dinámico -->
                        <span
                            class="{{ request()->routeIs('tickets.index') ? 'text-blue-600' : 'text-gray-500 dark:text-gray-400' }}">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M3 7C3 5.89543 3.89543 5 5 5H19C20.1046 5 21 5.89543 21 7V9.5C20.1716 9.5 19.5 10.1716 19.5 11C19.5 11.8284 20.1716 12.5 21 12.5V15C21 16.1046 20.1046 17 19 17H5C3.89543 17 3 16.1046 3 15V12.5C3.82843 12.5 4.5 11.8284 4.5 11C4.5 10.1716 3.82843 9.5 3 9.5V7ZM5 6.5C4.72386 6.5 4.5 6.72386 4.5 7V8.37868C5.58789 8.88338 6.25 9.87971 6.25 11C6.25 12.1203 5.58789 13.1166 4.5 13.6213V15C4.5 15.2761 4.72386 15.5 5 15.5H19C19.2761 15.5 19.5 15.2761 19.5 15V13.6213C18.4121 13.1166 17.75 12.1203 17.75 11C17.75 9.87971 18.4121 8.88338 19.5 8.37868V7C19.5 6.72386 19.2761 6.5 19 6.5H5ZM9 9.75C9.41421 9.75 9.75 10.0858 9.75 10.5V11.5C9.75 11.9142 9.41421 12.25 9 12.25C8.58579 12.25 8.25 11.9142 8.25 11.5V10.5C8.25 10.0858 8.58579 9.75 9 9.75ZM12 9.75C12.4142 9.75 12.75 10.0858 12.75 10.5V11.5C12.75 11.9142 12.4142 12.25 12 12.25C11.5858 12.25 11.25 11.9142 11.25 11.5V10.5C11.25 10.0858 11.5858 9.75 12 9.75ZM15 9.75C15.4142 9.75 15.75 10.0858 15.75 10.5V11.5C15.75 11.9142 15.4142 12.25 15 12.25C14.5858 12.25 14.25 11.9142 14.25 11.5V10.5C14.25 10.0858 14.5858 9.75 15 9.75Z"
                                    fill="currentColor">
                                </path>
                            </svg>
                        </span>

                        <!-- Texto con color dinámico -->
                        <span
                            class="menu-item-text ml-2 {{ request()->routeIs('tickets.index') ? 'text-blue-600 font-medium' : 'text-gray-700 dark:text-gray-400' }}">
                            Tickets
                        </span>
                    </a>

                    <div style="display: none;">
                        <ul class="mt-2 space-y-1 ml-9"></ul>
                    </div>
                    <a href="{{ route('call-logs.index') }}" wire:navigate
                        class="menu-item group {{ request()->routeIs('call-logs.index') ? 'bg-blue-100 dark:bg-zinc-800' : '' }}">

                        <!-- Icono -->
                        <span
                            class="{{ request()->routeIs('call-logs.index') ? 'text-blue-600' : 'text-gray-500 dark:text-gray-400' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M7 2.75C7 1.7835 7.7835 1 8.75 1H15.25C16.2165 1 17 1.7835 17 2.75V21.25C17 22.2165 16.2165 23 15.25 23H8.75C7.7835 23 7 22.2165 7 21.25V2.75ZM8.75 2.5C8.6119 2.5 8.5 2.6119 8.5 2.75V21.25C8.5 21.3881 8.6119 21.5 8.75 21.5H15.25C15.3881 21.5 15.5 21.3881 15.5 21.25V2.75C15.5 2.6119 15.3881 2.5 15.25 2.5H8.75ZM12 19.5C11.5858 19.5 11.25 19.8358 11.25 20.25C11.25 20.6642 11.5858 21 12 21C12.4142 21 12.75 20.6642 12.75 20.25C12.75 19.8358 12.4142 19.5 12 19.5Z"
                                    fill="currentColor">
                                </path>
                            </svg>
                        </span>

                        <!-- Texto -->
                        <span
                            class="menu-item-text ml-2 {{ request()->routeIs('call-logs.index') ? 'text-blue-600 font-medium' : 'text-gray-700 dark:text-gray-400' }}">
                            Llamadas
                        </span>
                    </a>


                    <div style="display: none;">
                        <ul class="mt-2 space-y-1 ml-9"></ul>
                    </div>
                </div>
            </nav>
        </aside>
        <!-- Main Content -->
        <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
            <main>
                <div class="  ">
                    <div>
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