<x-layouts.app.sidebar :title="$title ?? null" >
    @livewireStyles
    <flux:main class=" rounded-4xl border  m-3">
        {{ $slot }}
        @livewireScripts
@stack('scripts')
    </flux:main>
    
</x-layouts.app.sidebar>
