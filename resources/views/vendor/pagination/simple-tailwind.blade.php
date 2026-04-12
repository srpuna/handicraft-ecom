@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center gap-3">
        @if ($paginator->onFirstPage())
            <span class="inline-flex items-center rounded-md border border-truffle-medium/30 bg-cream px-4 py-2 text-sm font-medium text-gray-300">
                {{ __('Previous') }}
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center rounded-md border border-truffle-medium/30 bg-cream px-4 py-2 text-sm font-medium text-truffle-extra-dark hover:border-green-premium hover:text-green-premium">
                {{ __('Previous') }}
            </a>
        @endif

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center rounded-md border border-truffle-medium/30 bg-cream px-4 py-2 text-sm font-medium text-truffle-extra-dark hover:border-green-premium hover:text-green-premium">
                {{ __('Next') }}
            </a>
        @else
            <span class="inline-flex items-center rounded-md border border-truffle-medium/30 bg-cream px-4 py-2 text-sm font-medium text-gray-300">
                {{ __('Next') }}
            </span>
        @endif
    </nav>
@endif
