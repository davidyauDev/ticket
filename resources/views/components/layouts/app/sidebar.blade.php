<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
<body class="">
    <div class="flex h-screen overflow-hidden">
        <aside class="fixed left-0 top-0 z-50 flex h-screen w-[290px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 dark:border-gray-800 dark:bg-black lg:static lg:translate-x-0"">
            <!-- Sidebar Header -->
            <div class="flex items-center justify-between gap-2 pt-8 pb-7">
                <a href="{{ auth()->user()?->role === 'admin' ? route('tickets.dashboard') : route('tickets.index') }}" class="flex items-center space-x-2">
            <span class="logo">
                <img src="{{ asset('images/image.png') }}" alt="Logo" class="dark:hidden" />

            </span>
        </a>
                {{-- <button @click="sidebarToggle = !sidebarToggle" class="lg:hidden">
                    <i class="fa-solid fa-bars"></i>
                </button> --}}
            </div>
            <!-- Sidebar Menu -->
            <nav class="flex-1 overflow-y-auto">
                 @if(auth()->user()?->role === 'admin')
                <!-- Estadísticas -->
                <div class="mb-6">
                    <p class="mb-2 text-xs uppercase text-gray-400">Estadísticas</p>
                    <a href="{{ route('tickets.dashboard') }}" wire:navigate
                        class="menu-item group {{ request()->routeIs('tickets.dashboard') ? 'bg-gray-100 dark:bg-zinc-800' : '' }}">
                        <!-- Icono con cambio de color dinámico -->
                        <span
                            class="{{ request()->routeIs('tickets.dashboard') ? 'text-blue-600' : 'text-gray-500 dark:text-gray-400' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                        </span>
                        <!-- Texto con color dinámico -->
                        <span
                            class="menu-item-text ml-2 {{ request()->routeIs('tickets.dashboard') ? 'text-blue-600 font-medium' : 'text-gray-700 dark:text-gray-400' }}">
                            Tickets
                        </span>
                    </a>

                    <a href="{{ route('call-logs.dashboard') }}" wire:navigate
                        class="menu-item group {{ request()->routeIs('call-logs.dashboard') ? 'bg-gray-100 dark:bg-zinc-800' : '' }}">
                        <!-- Icono con cambio de color dinámico -->
                        <span
                            class="{{ request()->routeIs('call-logs.dashboard') ? 'text-blue-600' : 'text-gray-500 dark:text-gray-400' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                        </span>
                        <!-- Texto con color dinámico -->
                        <span
                            class="menu-item-text ml-2 {{ request()->routeIs('call-logs.dashboard') ? 'text-blue-600 font-medium' : 'text-gray-700 dark:text-gray-400' }}">
                            Llamadas
                        </span>
                    </a>
                </div>
              
                @endif
                <!-- Usuarios (Admin) -->
                @if(auth()->user()?->role === 'admin')
                <div class="mb-6">
                    <p class="mb-2 text-xs uppercase text-gray-400">Users</p>
                    <a href="{{ route('users.index') }}" wire:navigate
                        class="menu-item group {{ request()->routeIs('users.index') ? 'bg-gray-100 dark:bg-zinc-800' : '' }}">
                        <!-- Icono con cambio de color dinámico -->
                        <span
                            class="{{ request()->routeIs('users.index') ? 'text-blue-600' : 'text-gray-500 dark:text-gray-400' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-round-icon lucide-users-round"><path d="M18 21a8 8 0 0 0-16 0"/><circle cx="10" cy="8" r="5"/><path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3"/></svg>
                        </span>
                        <!-- Texto con color dinámico -->
                        <span
                            class="menu-item-text ml-2 {{ request()->routeIs('users.index') ? 'text-blue-600 font-medium' : 'text-gray-700 dark:text-gray-400' }}">
                            Usuarios
                        </span>
                    </a>
                </div>
                @endif
                <!-- Tickets -->
                <div class="mb-6">
                    <p class="mb-2 text-xs uppercase text-gray-400">Tickets</p>
                    <a href="{{ route('tickets.index') }}" wire:navigate
                        class="menu-item group {{ request()->routeIs('tickets.index') ? 'bg-gray-100 dark:bg-zinc-800' : '' }}">

                        <!-- Icono con cambio de color dinámico -->
                        <span
                            class="{{ request()->routeIs('tickets.index') ? 'text-blue-600' : 'text-gray-500 dark:text-gray-400' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-tag-icon lucide-tag"><path d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z"/><circle cx="7.5" cy="7.5" r=".5" fill="currentColor"/></svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-phone-outgoing-icon lucide-phone-outgoing"><path d="m16 8 6-6"/><path d="M22 8V2h-6"/><path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"/></svg>
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

                  <!-- Settings -->
                <div class="mb-6">
                    <p class="mb-2 text-xs uppercase text-gray-400">Settings</p>
                    <a href="{{ route('settings.index') }}" wire:navigate
                        class="menu-item group {{ request()->routeIs('settings.index') ? 'bg-gray-100 dark:bg-zinc-800' : '' }}">
                        <span class="{{ request()->routeIs('settings.index') ? 'text-blue-600' : 'text-gray-500 dark:text-gray-400' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-settings"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 8 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 8a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 8 4.6a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09c0 .66.38 1.26 1 1.51a1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 8c.66 0 1.26.38 1.51 1H21a2 2 0 0 1 0 4h-.09c-.13 0-.26.03-.38.08z"/></svg>
                        </span>
                        <span class="menu-item-text ml-2 {{ request()->routeIs('settings.index') ? 'text-blue-600 font-medium' : 'text-gray-700 dark:text-gray-400' }}">
                            Settings
                        </span>
                    </a>
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

