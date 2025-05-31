@if ($paginator->hasPages())
<div class="flex justify-between items-center">
    <div class="flex items-center gap-1">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-1.5 text-sm text-gray-400 bg-gray-100 rounded-md cursor-not-allowed">Anterior</span>
        @else
            <button wire:click="previousPage" wire:loading.attr="disabled"
                class="px-3 py-1.5 text-sm text-gray-800 bg-white border border-gray-200 rounded-md hover:bg-gray-100">
                Anterior
            </button>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-3 py-1.5 text-sm text-gray-500">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-1.5 text-sm font-semibold text-white bg-gray-900 rounded-md">{{ $page }}</span>
                    @else
                        <button wire:click="gotoPage({{ $page }})" wire:key="page-{{ $page }}"
                            class="px-3 py-1.5 text-sm text-gray-800 bg-white border border-gray-200 rounded-md hover:bg-gray-100">
                            {{ $page }}
                        </button>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <button wire:click="nextPage" wire:loading.attr="disabled"
                class="px-3 py-1.5 text-sm text-gray-800 bg-white border border-gray-200 rounded-md hover:bg-gray-100">
                Siguiente
            </button>
        @else
            <span class="px-3 py-1.5 text-sm text-gray-400 bg-gray-100 rounded-md cursor-not-allowed">Siguiente</span>
        @endif
    </div>
</div>
@endif