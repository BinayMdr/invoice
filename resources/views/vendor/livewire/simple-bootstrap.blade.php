<div class="h-100 d-flex align-items-center justify-content-center my-4">
    @if ($paginator->hasPages())
        <nav>
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled me-2" style="width: 40px" aria-disabled="true">
                        <span class="page-link w-100" style="background:darkslategray"><<</span>
                    </li>
                @else
                    @if(method_exists($paginator,'getCursorName'))
                        <li class="page-item me-2" style="width: 40px">
                            <button dusk="previousPage" type="button" class="page-link w-100" wire:click="setPage('{{$paginator->previousCursor()->encode()}}','{{ $paginator->getCursorName() }}')" wire:loading.attr="disabled" rel="prev"><<</button>
                        </li>
                    @else
                        <li class="page-item me-2" style="width: 40px">
                            <button type="button" dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}" class="page-link w-100" wire:click="previousPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" rel="prev"><<</button>
                        </li>
                    @endif
                @endif

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    @if(method_exists($paginator,'getCursorName'))
                        <li class="page-item" style="width: 40px">
                            <button dusk="nextPage" type="button" class="page-link w-100" wire:click="setPage('{{$paginator->nextCursor()->encode()}}','{{ $paginator->getCursorName() }}')" wire:loading.attr="disabled" rel="next">>></button>
                        </li>
                    @else
                        <li class="page-item" style="width: 40px">
                            <button type="button" dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}" class="page-link w-100" wire:click="nextPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" rel="next">>></button>
                        </li>
                    @endif
                @else
                    <li class="page-item disabled" style="width: 40px" aria-disabled="true">
                        <span class="page-link w-100" style="background:darkslategray">>></span>
                    </li>
                @endif
            </ul>
        </nav>
    @endif
</div>
