<div class="btn-group" role="group" aria-label="{{ __('Actions for') }} {{ $book->catalogueEntry ? $book->catalogueEntry->title : 'Book' }}">
    <a href="{{ route('book.show', $book->id) }}" class="btn btn-outline-primary btn-sm me-1" data-bs-toggle="tooltip" title="{{ __('Details') }}" aria-label="{{ __('Details') }}">
        <i class="bi bi-eye"></i>
    </a>
    <a href="{{ route('book.edit', $book->id) }}" class="btn btn-outline-primary btn-sm me-1" data-bs-toggle="tooltip" title="{{ __('Edit Book') }}" aria-label="{{ __('Edit Book') }}">
        <i class="bi bi-pencil"></i>
    </a>
    <button class="btn btn-outline-secondary btn-sm me-1 archiveCategoryBtn" value="{{ $book->id }}" data-bs-toggle="tooltip" title="{{ __('Archive Book') }}" aria-label="{{ __('Archive Book') }}">
        <i class="bi bi-archive"></i>
    </button>
    <button class="btn btn-outline-danger btn-sm deleteCategoryBtn" value="{{ $book->id }}" data-bs-toggle="tooltip" title="{{ __('Delete Book') }}" aria-label="{{ __('Delete Book') }}">
        <i class="bi bi-trash"></i>
    </button>
</div> 