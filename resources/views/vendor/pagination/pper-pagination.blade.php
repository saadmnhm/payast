@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="left disabled">
                <span class="template-left3">&nbsp;</span>
            </li>
        @else
            <li class="left">
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="template-left3">&nbsp;</a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="selected"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="right">
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="template-right3">&nbsp;</a>
            </li>
        @else
            <li class="right disabled">
                <span class="template-right3">&nbsp;</span>
            </li>
        @endif
    </ul>
@endif