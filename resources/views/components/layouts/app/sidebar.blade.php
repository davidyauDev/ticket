<div>
    <aside
  :class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
  class="sidebar fixed left-0 top-0 z-9999 flex h-screen w-[290px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 dark:border-gray-800 dark:bg-black lg:static lg:translate-x-0"
>
        <!-- SIDEBAR HEADER -->
 <div class="sidebar-header flex items-center gap-2 pb-7 pt-8"
            :class="sidebarToggle ? 'justify-center' : 'justify-between'">
            <a href="{{ route('tickets.index') }}">
                {{-- Logo completo (modo claro) --}}
                <span class="logo" :class="sidebarToggle ? 'hidden' : 'block'">
                    <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="block dark:hidden h-10 w-auto" />
                    <img src="{{ asset('images/logo-dark.svg') }}" alt="Logo" class="hidden dark:block h-10 w-auto" />
                </span>

                {{-- Logo reducido (ícono) cuando sidebarToggle = true --}}
                <img src="{{ asset('images/logo-icon.svg') }}" alt="Logo reducido" class="logo-icon h-10 w-auto"
                    :class="sidebarToggle ? 'block' : 'hidden'" />
            </a>
        </div>
        <div class="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear">
        </div>
        <!-- Sidebar Menu -->
        <nav class="flex-1 overflow-y-auto">
            @if (auth()->user()?->role === 'admin')
            <!-- Estadísticas -->
            <div class="mb-6">
                <p class="mb-2 text-xs uppercase text-gray-400">Estadísticas</p>
                <a href="{{ route('tickets.dashboard') }}" wire:navigate
                    class="menu-item group {{ request()->routeIs('tickets.dashboard') ? 'bg-gray-100 dark:bg-zinc-800' : '' }}">
                    <!-- Icono con cambio de color dinámico -->
                    <span
                        class="{{ request()->routeIs('tickets.dashboard') ? 'text-blue-600' : 'text-gray-500 dark:text-gray-400' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard">
                            <rect width="7" height="9" x="3" y="3" rx="1" />
                            <rect width="7" height="5" x="14" y="3" rx="1" />
                            <rect width="7" height="9" x="14" y="12" rx="1" />
                            <rect width="7" height="5" x="3" y="16" rx="1" />
                        </svg>
                    </span>
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard">
                            <rect width="7" height="9" x="3" y="3" rx="1" />
                            <rect width="7" height="5" x="14" y="3" rx="1" />
                            <rect width="7" height="9" x="14" y="12" rx="1" />
                            <rect width="7" height="5" x="3" y="16" rx="1" />
                        </svg>
                    </span>
                    <!-- Texto con color dinámico -->
                    <span
                        class="menu-item-text ml-2 {{ request()->routeIs('call-logs.dashboard') ? 'text-blue-600 font-medium' : 'text-gray-700 dark:text-gray-400' }}">
                        Llamadas
                    </span>
                </a>
                
            </div>
            @endif
            @if (auth()->user()?->role === 'admin')
            <div class="mb-6">
                <p class="mb-2 text-xs uppercase text-gray-400">Users</p>
                <a href="{{ route('users.index') }}" wire:navigate
                    class="menu-item group {{ request()->routeIs('users.index') ? 'bg-gray-100 dark:bg-zinc-800' : '' }}">
                    <!-- Icono con cambio de color dinámico -->
                    <span
                        class="{{ request()->routeIs('users.index') ? 'text-blue-600' : 'text-gray-500 dark:text-gray-400' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-users-round-icon lucide-users-round">
                            <path d="M18 21a8 8 0 0 0-16 0" />
                            <circle cx="10" cy="8" r="5" />
                            <path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3" />
                        </svg>
                    </span>
                    <span
                        class="menu-item-text ml-2 {{ request()->routeIs('users.index') ? 'text-blue-600 font-medium' : 'text-gray-700 dark:text-gray-400' }}">
                        Usuarios
                    </span>
                </a>
            </div>
            @endif
            <div class="mb-6">
                <p class="mb-2 text-xs uppercase text-gray-400">Tickets</p>
                <a href="{{ route('tickets.index') }}" wire:navigate
                    class="menu-item group {{ request()->routeIs('tickets.index') ? 'bg-gray-100 dark:bg-zinc-800' : '' }}">
                    <span
                        class="{{ request()->routeIs('tickets.index') ? 'text-blue-600' : 'text-gray-500 dark:text-gray-400' }}">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M20 17.0518V12C20 7.58174 16.4183 4 12 4C7.58168 4 3.99994 7.58174 3.99994 12V17.0518M19.9998 14.041V19.75C19.9998 20.5784 19.3282 21.25 18.4998 21.25H13.9998M6.5 18.75H5.5C4.67157 18.75 4 18.0784 4 17.25V13.75C4 12.9216 4.67157 12.25 5.5 12.25H6.5C7.32843 12.25 8 12.9216 8 13.75V17.25C8 18.0784 7.32843 18.75 6.5 18.75ZM17.4999 18.75H18.4999C19.3284 18.75 19.9999 18.0784 19.9999 17.25V13.75C19.9999 12.9216 19.3284 12.25 18.4999 12.25H17.4999C16.6715 12.25 15.9999 12.9216 15.9999 13.75V17.25C15.9999 18.0784 16.6715 18.75 17.4999 18.75Z"
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                        </svg>
                    </span>
                    <span
                        class="menu-item-text ml-2 {{ request()->routeIs('tickets.index') ? 'text-blue-600 font-medium' : 'text-gray-700 dark:text-gray-400' }}">
                        Support Ticket
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
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M20 17.0518V12C20 7.58174 16.4183 4 12 4C7.58168 4 3.99994 7.58174 3.99994 12V17.0518M19.9998 14.041V19.75C19.9998 20.5784 19.3282 21.25 18.4998 21.25H13.9998M6.5 18.75H5.5C4.67157 18.75 4 18.0784 4 17.25V13.75C4 12.9216 4.67157 12.25 5.5 12.25H6.5C7.32843 12.25 8 12.9216 8 13.75V17.25C8 18.0784 7.32843 18.75 6.5 18.75ZM17.4999 18.75H18.4999C19.3284 18.75 19.9999 18.0784 19.9999 17.25V13.75C19.9999 12.9216 19.3284 12.25 18.4999 12.25H17.4999C16.6715 12.25 15.9999 12.9216 15.9999 13.75V17.25C15.9999 18.0784 16.6715 18.75 17.4999 18.75Z"
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                        </svg>
                    </span>
                    <!-- Texto -->
                    <span
                        class="menu-item-text ml-2 {{ request()->routeIs('call-logs.index') ? 'text-blue-600 font-medium' : 'text-gray-700 dark:text-gray-400' }}">
                        Support Llamadas
                    </span>
                </a>
                <div style="display: none;">
                    <ul class="mt-2 space-y-1 ml-9"></ul>
                </div>
                @if (auth()->user()?->role === 'admin')
                <a href="{{ route('whatsapp.index') }}" wire:navigate
                    class="menu-item group {{ request()->routeIs('whatsapp.index') ? 'bg-gray-100 dark:bg-zinc-800' : '' }}">
                    <!-- Icono -->
                    <span
                        class="{{ request()->routeIs('whatsapp.index') ? 'text-blue-600' : 'text-gray-500 dark:text-gray-400' }}">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.465 3.488" fill="currentColor"/>
                        </svg>
                    </span>
                    <!-- Texto -->
                    <span
                        class="menu-item-text ml-2 {{ request()->routeIs('whatsapp.index') ? 'text-blue-600 font-medium' : 'text-gray-700 dark:text-gray-400' }}">
                        WhatsApp
                    </span>
                </a>
                @endif
            </div>
            <!-- Settings -->
            @if (auth()->user()?->role === 'admin' ||
            auth()->user()?->role === 'Supervisor' ||
            auth()->user()?->area_id === 5 ||
            auth()->user()?->area_id === 6 ||
            auth()->user()?->area_id === 7 ||
            auth()->user()?->area_id === 8)
            <div class="mb-6">
                <p class="mb-2 text-xs uppercase text-gray-400">Settings</p>
                <a href="{{ route('settings.index') }}" wire:navigate
                    class="menu-item group {{ request()->routeIs('settings.index') ? 'bg-gray-100 dark:bg-zinc-800' : '' }}">
                    <span
                        class="{{ request()->routeIs('settings.index') ? 'text-blue-600' : 'text-gray-500 dark:text-gray-400' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-settings">
                            <circle cx="12" cy="12" r="3" />
                            <path
                                d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 8 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 8a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 8 4.6a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09c0 .66.38 1.26 1 1.51a1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 8c.66 0 1.26.38 1.51 1H21a2 2 0 0 1 0 4h-.09c-.13 0-.26.03-.38.08z" />
                        </svg>
                    </span>
                    <span
                        class="menu-item-text ml-2 {{ request()->routeIs('settings.index') ? 'text-blue-600 font-medium' : 'text-gray-700 dark:text-gray-400' }}">
                        Settings
                    </span>
                </a>

                 <a href="{{ route('settings.modelos') }}" wire:navigate
                    class="menu-item group {{ request()->routeIs('settings.modelos') ? 'bg-gray-100 dark:bg-zinc-800' : '' }}">
                    <!-- Icono con cambio de color dinámico -->
                    <span
                        class="{{ request()->routeIs('settings.modelos') ? 'text-blue-600' : 'text-gray-500 dark:text-gray-400' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-washing-machine-icon lucide-washing-machine"><path d="M3 6h3"/><path d="M17 6h.01"/><rect width="18" height="20" x="3" y="2" rx="2"/><circle cx="12" cy="13" r="5"/><path d="M12 18a2.5 2.5 0 0 0 0-5 2.5 2.5 0 0 1 0-5"/></svg>
                    </span>
                    <!-- Texto con color dinámico -->
                    <span
                        class="menu-item-text ml-2 {{ request()->routeIs('settings.modelos') ? 'text-blue-600 font-medium' : 'text-gray-700 dark:text-gray-400' }}">
                        Modelos
                    </span>
                </a>
                
            </div>
            @endif
        </nav>
    </aside>
    <!-- Main Content -->
    <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
        <main>
            <div>
                {{ $slot }}
            </div>
        </main>

    </div>

</div>