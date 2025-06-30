<div class="btn-group" role="group" aria-label="{{ __('Actions for') }} {{ $author->forename }} {{ $author->surname }}">
    <a href="{{ route('author.show', $author) }}" class="btn btn-outline-primary btn-sm me-1" data-bs-toggle="tooltip" title="{{ __('Details') }}" aria-label="{{ __('Details') }}">
        <i class="bi bi-eye"></i>
    </a>
    <a href="{{ route('author.edit', $author) }}" class="btn btn-outline-primary btn-sm me-1" data-bs-toggle="tooltip" title="{{ __('Edit Author') }}" aria-label="{{ __('Edit Author') }}">
        <i class="bi bi-pencil"></i>
    </a>
    <button class="btn btn-outline-secondary btn-sm me-1 archiveCategoryBtn" value="{{ $author->id }}" data-bs-toggle="tooltip" title="{{ __('Archive Author') }}" aria-label="{{ __('Archive Author') }}">
        <i class="bi bi-archive"></i>
    </button>
    <button class="btn btn-outline-danger btn-sm deleteCategoryBtn" value="{{ $author->id }}" data-bs-toggle="tooltip" title="{{ __('Delete Author') }}" aria-label="{{ __('Delete Author') }}">
        <i class="bi bi-trash"></i>
    </button>
</div> 