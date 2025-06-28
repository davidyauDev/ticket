<x-layouts.app.sidebar :title="$title ?? null" >
   
    @livewireStyles
        <x-layouts.app.header2 />
    
    <div  class="" >
        {{ $slot }}
        @livewireScripts
@stack('scripts')
    </div>
    
</x-layouts.app.sidebar>
