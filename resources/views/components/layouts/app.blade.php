<x-layouts.app.sidebar :title="$title ?? null" >
   
    @livewireStyles
    <flux:main class=" ">
         @php
    $areas = \App\Models\Area::all();
@endphp
        {{ $slot }}
        @livewireScripts
@stack('scripts')
    </flux:main>
    
</x-layouts.app.sidebar>
