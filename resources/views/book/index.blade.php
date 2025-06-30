@extends('layouts.app')
@section('title', __('Books') . ' | Library Management System')

@section('content')
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5 class="mb-0">Books</h5>
                <div>
                    <a href="{{ route('book.create') }}" class="btn btn-primary btn-sm">Add Book</a>
                    <a href="{{ route('book.archived') }}" class="btn btn-secondary btn-sm">Archived Books</a>
                    <a href="{{ route('book.deleted') }}" class="btn btn-secondary btn-sm">Deleted Books</a>
                </div>
            </div>
            <div class="card-body">
                @if(Session::has('flashMessage'))
                    <div class="alert alert-success">
                        {{ Session::get('flashMessage') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table id="bookIndex" class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Format</th>
                            <th>Title</th>
                            <th>Author(s)</th>
                            <th>Publisher</th>
                            <th>Status</th>
                            <th>Loans</th>
                            <th class="text-end">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($books as $book)
                            <tr>
                                <td>{{ $book->id }}</td>
                                <td>
                                    @if ($book->format)
                                        <span title="{{ $book->format->name }}" class="badge bg-secondary">{{ $book->format->name == "Paperback" ? 'PB' : 'HC' }}</span>
                                    @endif
                                </td>
                                <td>{{ $book->catalogueEntry ? $book->catalogueEntry->title : 'N/A' }}</td>
                                <td>
                                    {{ $book->catalogueEntry ? $book->catalogueEntry->formatted_authors : 'N/A' }}
                                </td>
                                <td>
                                    @if($book->publisher)
                                        {{ $book->publisher->name }}<br>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($book->publish_date)->format('jS M Y') }}</small>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if ($book->isOnLoan())
                                        <span class="badge bg-warning text-dark">{{ __('On Loan') }}</span>
                                    @else
                                        <span class="badge bg-success">{{ __('Available') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $book->popularity() }}</span>
                                </td>
                                <td class="text-end">
                                    @include('partials.book-actions', ['book' => $book])
                                </td>
                            </tr>
                        @empty
                            @include('partials.empty-state', [
                                'icon' => 'bi-emoji-frown',
                                'title' => __('No books found'),
                                'message' => __('Get started by adding your first book to the library.'),
                                'actionRoute' => route('book.create'),
                                'actionLabel' => __('Add Book')
                            ])
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('partials.archive-modal', ['modalId' => 'archiveModal', 'formAction' => url('book/archive'), 'textareaId' => 'archiveQuestion', 'categoryId' => 'category_id', 'confirmArchiveBtn' => 'confirmArchiveBtn'])
    @include('partials.delete-modal', ['modalId' => 'deleteModal', 'formAction' => url('book/delete'), 'textareaId' => 'deleteQuestion', 'archive_genre_id' => 'archive_genre_id', 'confirmDeleteBtn' => 'confirmDeleteBtn'])
@endsection

@push('scripts')
    <script src="{{ asset('js/book.js') }}"></script>
@endpush
