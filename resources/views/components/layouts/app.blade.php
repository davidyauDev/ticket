<x-layouts.app.sidebar :title="$title ?? null" >
    @livewireStyles
    <flux:main class=" ">
        {{ $slot }}
        @livewireScripts
@stack('scripts')
    </flux:main>
    
</x-layouts.app.sidebar>
