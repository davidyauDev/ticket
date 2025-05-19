<x-layouts.app.sidebar :title="$title ?? null" >
    <flux:main class=" rounded-4xl border  m-3">
        {{ $slot }}
        
    </flux:main>
    
</x-layouts.app.sidebar>
