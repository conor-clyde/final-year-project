<div class="text-center my-5">
    <i class="bi {{ $icon ?? 'bi-emoji-frown' }} genre-empty-animate" style="font-size:2.5rem;color:#adb5bd;"></i>
    <h4 class="mt-3">{{ $title ?? __('No items found') }}</h4>
    <p class="text-muted">{{ $message ?? '' }}</p>
    @if(!empty($actionRoute) && !empty($actionLabel))
        <a href="{{ $actionRoute }}" class="btn btn-primary mt-2" aria-label="{{ $actionLabel }}">
            <i class="bi bi-plus-circle me-1"></i> {{ $actionLabel }}
        </a>
    @endif
</div> 