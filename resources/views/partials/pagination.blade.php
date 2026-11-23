{{-- Paginasi bertema. Dipakai: {{ $paginator->links('partials.pagination') }} --}}
@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Paginasi" class="mt-6 flex flex-wrap items-center justify-center gap-1.5">
        @if ($paginator->onFirstPage())
            <span class='rounded-full border border-line px-3.5 py-1.5 text-sm text-soft opacity-50' aria-disabled="true">&lsaquo;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class='rounded-full border border-line bg-panel px-3.5 py-1.5 text-sm font-semibold transition hover:border-line-teal' aria-label="Halaman sebelumnya">&lsaquo;</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-2 text-soft">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page" class="rounded-full bg-accent px-3.5 py-1.5 text-sm font-bold shadow-glow-red">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class='rounded-full border border-line bg-panel px-3.5 py-1.5 text-sm font-semibold transition hover:border-line-teal'>{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class='rounded-full border border-line bg-panel px-3.5 py-1.5 text-sm font-semibold transition hover:border-line-teal' aria-label="Halaman berikutnya">&rsaquo;</a>
        @else
            <span class='rounded-full border border-line px-3.5 py-1.5 text-sm text-soft opacity-50' aria-disabled="true">&rsaquo;</span>
        @endif
    </nav>
@endif
