@extends('layouts.app')

@section('title', 'Genre: ' . ($genre->name ?? 'Details') . ' | Library Management System')

@section('content')
    <div class="py-12" role="main">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card shadow genre-card">
                <div class="card-header bg-light d-flex justify-content-between align-items-center rounded-top">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-tag me-3 text-primary" style="font-size:2rem;"></i>
                        <h2 class="fw-bold mb-0">{{ $genre->name }}</h2>
                    </div>
                    <div>
                        <a href="{{ route('genre.index') }}" class="btn btn-outline-secondary me-2" aria-label="Back to Genres">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        @if(!$genre->deleted_at)
                            <a href="{{ route('genre.edit', $genre) }}" class="btn btn-primary" aria-label="Edit Genre">
                                <i class="bi bi-pencil me-1"></i> Edit
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if($genre->deleted_at)
                        <div class="alert alert-danger d-flex align-items-center mb-4" role="alert">
                            <i class="bi bi-trash me-2"></i>
                            <div>
                                This genre has been <strong>deleted</strong>. You can restore it from the deleted genres page.
                            </div>
                        </div>
                    @endif
                    <div class="mb-3">
                        <span class="text-muted">Description:</span>
                        <span class="ms-2">{{ $genre->description ? $genre->description : 'No description provided.' }}</span>
                    </div>
                    <div class="mb-3">
                        @if(!$genre->deleted_at && $genre->catalogueEntries->count() > 0)
                            <span class="badge bg-primary me-2"><i class="bi bi-journal me-1"></i> {{ $genre->catalogueEntries->count() }} Titles</span>
                            <span class="badge bg-secondary"><i class="bi bi-collection me-1"></i> {{ $genre->catalogueEntries->flatMap->bookCopies->count() }} Book Copies</span>
                        @endif
                    </div>
                    <div class="mb-3 text-muted">
                        <small><i class="bi bi-calendar-plus me-1"></i> Created: {{ $genre->created_at ? $genre->created_at->format('Y-m-d') : 'N/A' }}</small>
                        <small class="ms-3"><i class="bi bi-clock-history me-1"></i> Last Updated: {{ $genre->updated_at ? $genre->updated_at->format('Y-m-d') : 'N/A' }}</small>
                    </div>
                    <hr>
                    @if(!$genre->deleted_at)
                        @if($genre->catalogueEntries->count() > 0)
                            <div class="table-responsive">
                                <table id="genreBooksTable" class="table table-hover table-striped align-middle genre-table">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Title</th>
                                            <th>Authors</th>
                                            <th># Copies</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($genre->catalogueEntries as $entry)
                                            <tr>
                                                <td>
                                                    @if($entry->bookCopies && $entry->bookCopies->count())
                                                        <a href="{{ route('book.show', $entry->bookCopies->first()) }}" aria-label="View book: {{ $entry->title }}">{{ $entry->title }}</a>
                                                    @else
                                                        {{ $entry->title }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($entry->authors->count())
                                                        @php
                                                            $authors = $entry->authors;
                                                            $count = $authors->count();
                                                        @endphp
                                                        @if($count === 1)
                                                            {{ $authors->first()->forename }} {{ $authors->first()->surname }}
                                                        @elseif($count === 2)
                                                            {{ $authors[0]->forename }} {{ $authors[0]->surname }} & {{ $authors[1]->forename }} {{ $authors[1]->surname }}
                                                        @else
                                                            @for($i = 0; $i < $count; $i++)
                                                                @if($i === $count - 1)
                                                                    & {{ $authors[$i]->forename }} {{ $authors[$i]->surname }}
                                                                @elseif($i === $count - 2)
                                                                    {{ $authors[$i]->forename }} {{ $authors[$i]->surname }} 
                                                                @else
                                                                    {{ $authors[$i]->forename }} {{ $authors[$i]->surname }}, 
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>
                                                <td>{{ $entry->bookCopies ? $entry->bookCopies->count() : 0 }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center my-5">
                                <i class="bi bi-emoji-frown genre-empty-animate" style="font-size:2.5rem;color:#adb5bd;"></i>
                                <h5 class="mt-3">No books found for this genre.</h5>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#genreBooksTable').DataTable({
        responsive: true,
        dom: '<"d-flex justify-content-between align-items-center mb-2"<"dt-search"f><"dt-length"l>>rtp',
        language: {
            search: 'Search books:',
            lengthMenu: 'Show _MENU_',
            info: 'Displaying _START_-_END_ of _TOTAL_ books',
        },
        order: [[0, 'asc']]
    });
});
</script>
@endpush
