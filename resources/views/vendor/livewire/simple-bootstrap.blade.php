@if ($paginator->hasPages())
    <nav>
        <ul class="pagination justify-content-center">
            {{-- First Page Link --}}
            @if ($paginator->currentPage() > 3) 
                <li class="page-item">
                    <button wire:click="gotoPage(1)" class="page-link" aria-label="First Page">
                        &laquo;&laquo;
                    </button>
                </li>
            @endif

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">&laquo;</span>
                </li>
            @else
                <li class="page-item">
                    <button wire:click="previousPage" wire:loading.attr="disabled" rel="prev" aria-label="@lang('pagination.previous')" class="page-link">
                        &laquo;
                    </button>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        {{-- Show First Page (only once) --}}
                        @if ($page == 1 && $paginator->currentPage() > 3)
                            <li class="page-item">
                                <button wire:click="gotoPage(1)" class="page-link">1</button>
                            </li>
                        @endif

                        {{-- Ellipses for Skipped Pages Before Current --}}
                        @if ($page == 2 && $paginator->currentPage() > 3)
                            <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
                        @endif

                        {{-- Show Pages Around Current --}}
                        @if ($page == $paginator->currentPage() || abs($page - $paginator->currentPage()) <= 1)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active" aria-current="page">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <button wire:click="gotoPage({{ $page }})" class="page-link">{{ $page }}</button>
                                </li>
                            @endif
                        @endif

                        {{-- Ellipses for Skipped Pages After Current --}}
                        @if ($page == $paginator->lastPage() - 1 && $paginator->currentPage() < $paginator->lastPage() - 2)
                            <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
                        @endif

                        {{-- Show Last Page (only once) --}}
                        @if ($page == $paginator->lastPage() && $paginator->currentPage() < $paginator->lastPage() - 1)
                            <li class="page-item">
                                <button wire:click="gotoPage({{ $paginator->lastPage() }})" class="page-link">{{ $paginator->lastPage() }}</button>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <button wire:click="nextPage" wire:loading.attr="disabled" rel="next" aria-label="@lang('pagination.next')" class="page-link">
                        &raquo;
                    </button>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">&raquo;</span>
                </li>
            @endif

            {{-- Last Page Link --}}
            @if ($paginator->currentPage() < $paginator->lastPage() - 2) 
                <li class="page-item">
                    <button wire:click="gotoPage({{ $paginator->lastPage() }})" class="page-link" aria-label="Last Page">
                        &raquo;&raquo;
                    </button>
                </li>
            @endif
        </ul>
    </nav>
@endif
