<x-layouts.app.sidebar :title="$title ?? null" >
   
    @livewireStyles
        <x-layouts.app.header2 />
    
    <div  class="" >
      
        @livewireScripts
@stack('scripts')
    </div>
    
</x-layouts.app.sidebar>
