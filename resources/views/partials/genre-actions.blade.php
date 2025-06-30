<div class="btn-group" role="group" aria-label="{{ __('Actions for') }} {{ $genre->name }}">
    <a href="{{ route('genre.edit', $genre) }}" class="btn btn-outline-primary btn-sm me-1" data-bs-toggle="tooltip" title="{{ __('Edit Genre') }}" aria-label="{{ __('Edit Genre') }}">
        <i class="bi bi-pencil"></i>
    </a>
    <button class="btn btn-outline-secondary btn-sm me-1 archiveCategoryBtn" value="{{ $genre->id }}" data-bs-toggle="tooltip" title="{{ __('Archive Genre') }}" aria-label="{{ __('Archive Genre') }}">
        <i class="bi bi-archive"></i>
    </button>
    <button class="btn btn-outline-danger btn-sm deleteCategoryBtn" value="{{ $genre->id }}" data-bs-toggle="tooltip" title="{{ __('Delete Genre') }}" aria-label="{{ __('Delete Genre') }}">
        <i class="bi bi-trash"></i>
    </button>
</div> 