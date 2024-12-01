@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled" aria-disabled="true">
                <a class="page-link" href="#" tabindex="-1">Previous</a>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">Previous</a>
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
                    {{-- Show first 2 pages, current page, and last 2 pages --}}
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active" aria-current="page"><a class="page-link" href="#">{{ $page }} <span class="sr-only">(current)</span></a></li>
                    @elseif ($page == 1 || $page == 2 || $page == $paginator->lastPage() || $page == $paginator->lastPage() - 1 || abs($page - $paginator->currentPage()) < 2)
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @elseif ($page == 3 && $paginator->currentPage() > 4)
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    @elseif ($page == $paginator->lastPage() - 2 && $paginator->currentPage() < $paginator->lastPage() - 3)
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a>
            </li>
        @else
            <li class="page-item disabled" aria-disabled="true">
                <a class="page-link" href="#" tabindex="-1">Next</a>
            </li>
        @endif
    </ul>
@endif
