<div class="btn-group" role="group" aria-label="{{ __('Actions for') }} {{ $publisher->name }}">
    <a href="{{ route('publisher.show', $publisher->id) }}" class="btn btn-outline-primary btn-sm me-1" data-bs-toggle="tooltip" title="{{ __('Details') }}" aria-label="{{ __('Details') }}">
        <i class="bi bi-eye"></i>
    </a>
    <a href="{{ route('publisher.edit', $publisher->id) }}" class="btn btn-outline-primary btn-sm me-1" data-bs-toggle="tooltip" title="{{ __('Edit Publisher') }}" aria-label="{{ __('Edit Publisher') }}">
        <i class="bi bi-pencil"></i>
    </a>
    <button class="btn btn-outline-secondary btn-sm me-1 archiveCategoryBtn" value="{{ $publisher->id }}" data-bs-toggle="tooltip" title="{{ __('Archive Publisher') }}" aria-label="{{ __('Archive Publisher') }}">
        <i class="bi bi-archive"></i>
    </button>
    <button class="btn btn-outline-danger btn-sm deleteCategoryBtn" value="{{ $publisher->id }}" data-bs-toggle="tooltip" title="{{ __('Delete Publisher') }}" aria-label="{{ __('Delete Publisher') }}">
        <i class="bi bi-trash"></i>
    </button>
</div> 