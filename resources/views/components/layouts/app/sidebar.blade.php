<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">

    <flux:sidebar sticky stashable class="border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />
        <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
            <x-app-logo />
        </a>

        <flux:navlist variant="outline">
            <flux:navlist.group :heading="__('Estadísticas')" class="grid">
                <flux:navlist.item icon="chart-bar" :href="route('tickets.estadisticas')"
                    :current="request()->routeIs('tickets.estadisticas') || request()->is('tickets/estadisticas')"
                    wire:navigate>
                    Estadísticas de Tickets
                </flux:navlist.item>
            </flux:navlist.group>
            @if(auth()->user()?->role === 'admin')
            <flux:navlist.group :heading="__('Users')" class="grid">
                <flux:navlist.item icon="users" :href="route('users.index')" :current="request()->routeIs('users.*')"
                    wire:navigate>{{ __('Users') }}</flux:navlist.item>
            </flux:navlist.group>
            @endif
            <flux:navlist.group :heading="__('Tickets')" class="grid">
                <flux:navlist.item icon="ticket" :href="route('tickets.index')"
                    :current="request()->routeIs('tickets.*') && !request()->routeIs('tickets.estadisticas')"
                    wire:navigate>
                    {{ __('Tickets') }}
                </flux:navlist.item>
            </flux:navlist.group>
            
            {{-- @foreach ($areas as $area)
            <flux:navlist.group  expandable heading="{{ $area->nombre }}" :expanded="false" class="grid">
                @foreach ($area->children as $subarea)
                <flux:navlist.item href="{{ route('areas.show', ['slug' => $subarea->slug]) }}"
                    :current="request()->fullUrlIs(route('areas.show', ['slug' => $subarea->slug]))" wire:navigate>
                    {{ $subarea->nombre }}
                </flux:navlist.item>
                @endforeach
            </flux:navlist.group>
            @endforeach --}}

            
             <flux:navlist.group :heading="__('Tickets')" class="bg-dark">
                <flux:navlist.item icon="ticket" :href="route('call-logs.index')"
                    :current="request()->routeIs('call-logs.index') || request()->is('call-logs')" wire:navigate>
                    {{ __('Llamadas') }}
                </flux:navlist.item>
            </flux:navlist.group> 
        </flux:navlist>
        <flux:spacer />
        <flux:dropdown position="bottom" align="start">
            <flux:profile :name="auth()->user()->name" :initials="auth()->user()->initials()"
                icon-trailing="chevrons-up-down" />
            <flux:menu class="w-[220px]">
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>
                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>
                <flux:menu.separator />
                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>
                <flux:menu.separator />
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>

    </flux:sidebar>
    {{ $slot }}
    @fluxScripts
</body>
</html>