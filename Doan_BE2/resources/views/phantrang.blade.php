@if ($paginator->hasPages())
<ul class="pagination justify-content-center">

    {{-- Nút "Trước" --}}
    @if ($paginator->onFirstPage())
    <li class="page-item disabled"><span class="page-link">«</span></li>
    @else
    <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}">«</a></li>
    @endif

    @php
    $currentPage = $paginator->currentPage();
    $lastPage = $paginator->lastPage();
    $start = max(1, $currentPage - 2);
    $end = min($lastPage, $currentPage + 2);
    @endphp

    {{-- Dấu "..." đầu nếu cần --}}
    @if ($start > 1)
    <li class="page-item"><a class="page-link" href="{{ $paginator->url(1) }}">1</a></li>
    @if ($start > 2)
    <li class="page-item disabled"><span class="page-link">...</span></li>
    @endif
    @endif

    {{-- Hiển thị các trang lân cận --}}
    @for ($i = $start; $i <= $end; $i++)
        @if ($i==$currentPage)
        <li class="page-item active"><span class="page-link">{{ $i }}</span></li>
        @else
        <li class="page-item"><a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
        @endif
        @endfor

        {{-- Dấu "..." cuối nếu cần --}}
        @if ($end < $lastPage)
            @if ($end < $lastPage - 1)
            <li class="page-item disabled"><span class="page-link">...</span></li>
            @endif
            <li class="page-item"><a class="page-link" href="{{ $paginator->url($lastPage) }}">{{ $lastPage }}</a></li>
            @endif

            {{-- Nút "Tiếp" --}}
            @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}">»</a></li>
            @else
            <li class="page-item disabled"><span class="page-link">»</span></li>
            @endif
</ul>
@endif