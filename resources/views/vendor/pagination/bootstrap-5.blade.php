@if ($paginator->hasPages())
    <nav aria-label="pagination">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            <li class="dt-paging-button page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link previous" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous" {{ $paginator->onFirstPage() ? 'aria-disabled="true"' : '' }}>
                    <i class="previous"></i>
                </a>
            </li>

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="dt-paging-button page-item disabled">
                        <span class="page-link">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <li class="dt-paging-button page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}" aria-current="{{ $page == $paginator->currentPage() ? 'page' : '' }}">
                                {{ $page }}
                            </a>
                        </li>
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            <li class="dt-paging-button page-item {{ !$paginator->hasMorePages() ? 'disabled' : '' }}">
                <a class="page-link next" href="{{ $paginator->nextPageUrl() }}" aria-label="Next" {{ !$paginator->hasMorePages() ? 'aria-disabled="true"' : '' }}>
                    <i class="next"></i>
                </a>
            </li>
        </ul>
    </nav>
@endif