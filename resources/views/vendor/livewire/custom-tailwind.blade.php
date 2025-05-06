@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="hidden sm:flex items-center bg-white border border-zinc-200 rounded-[8px] p-[1px] dark:bg-white/10 dark:border-white/10">
        <div class="flex-1 flex justify-center">
            <span class="relative z-0 inline-flex shadow-sm rounded-md">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <div aria-disabled="true" aria-label="&laquo; Previous" class="flex justify-center items-center size-6 rounded-[6px] text-zinc-300 dark:text-zinc-500">
                        <svg class="shrink-0 [:where(&)]:size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M9.78 4.22a.75.75 0 0 1 0 1.06L7.06 8l2.72 2.72a.75.75 0 1 1-1.06 1.06L5.47 8.53a.75.75 0 0 1 0-1.06l3.25-3.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                @else
                    <button wire:click="previousPage" wire:loading.attr="disabled" rel="prev" class="flex justify-center items-center size-6 rounded-[6px] text-zinc-400 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-white/20 hover:text-zinc-800 dark:hover:text-white">
                        <svg class="shrink-0 [:where(&)]:size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M9.78 4.22a.75.75 0 0 1 0 1.06L7.06 8l2.72 2.72a.75.75 0 1 1-1.06 1.06L5.47 8.53a.75.75 0 0 1 0-1.06l3.25-3.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span aria-disabled="true" class="cursor-default flex justify-center items-center text-xs h-6 px-2 rounded-[6px] font-medium dark:text-white text-zinc-800">{{ $element }}</span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <div wire:key="paginator-page-page{{ $page }}" aria-current="page" class="cursor-default flex justify-center items-center text-xs h-6 px-2 rounded-[6px] font-medium dark:text-white text-zinc-800">{{ $page }}</div>
                            @else
                                <button wire:key="paginator-page-page{{ $page }}" wire:click="gotoPage({{ $page }})" type="button" class="text-xs h-6 px-2 rounded-[6px] text-zinc-400 font-medium dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-white/20 hover:text-zinc-800 dark:hover:text-white">{{ $page }}</button>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <button type="button" wire:click="nextPage" aria-label="Next &raquo;" class="flex justify-center items-center size-6 rounded-[6px] text-zinc-400 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-white/20 hover:text-zinc-800 dark:hover:text-white">
                        <svg class="shrink-0 [:where(&)]:size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M6.22 4.22a.75.75 0 0 1 1.06 0l3.25 3.25a.75.75 0 0 1 0 1.06l-3.25 3.25a.75.75 0 0 1-1.06-1.06L8.94 8 6.22 5.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                @else
                    <div aria-disabled="true" aria-label="Next &raquo;" class="flex justify-center items-center size-6 rounded-[6px] text-zinc-300 dark:text-zinc-500">
                        <svg class="shrink-0 [:where(&)]:size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M6.22 4.22a.75.75 0 0 1 1.06 0l3.25 3.25a.75.75 0 0 1 0 1.06l-3.25 3.25a.75.75 0 0 1-1.06-1.06L8.94 8 6.22 5.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                @endif
            </span>
        </div>
    </nav>
@endif
