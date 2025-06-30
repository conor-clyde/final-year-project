@extends('layouts.app')

@section('title', __('Genres') . ' | Library Management System')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card shadow genre-card">
                <div class="card-header bg-light d-flex justify-content-between align-items-center rounded-top position-relative" style="min-height: 3.5rem;">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-tags me-2 text-primary genre-empty-animate" style="font-size:1.7rem;"></i>
                        <h3 class="fw-bold mb-0">{{ __('Genres') }}</h3>
                    </div>
                    <div>
                        <a href="{{ route('genre.create') }}" class="btn btn-primary me-2" aria-label="{{ __('Add Genre') }}">
                            <i class="bi bi-plus-circle me-1"></i> {{ __('Add Genre') }}
                        </a>
                        <a href="{{ route('genre.archived') }}" class="btn btn-outline-secondary me-2" aria-label="{{ __('View Archived Genres') }}">
                            <i class="bi bi-archive"></i>
                        </a>
                        <a href="{{ route('genre.deleted') }}" class="btn btn-outline-danger" aria-label="{{ __('View Deleted Genres') }}">
                            <i class="bi bi-trash"></i>
                        </a>
                        <span data-bs-toggle="tooltip" class="ms-3" title="{{ __('\'Archived\' genres are hidden from active lists but can be restored. \'Deleted\' genres are removed but can be restored from the deleted list.') }}">
                            <i class="bi bi-question-circle-fill text-info" style="font-size: 1.3rem;"></i>
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert" aria-live="polite">
                            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" aria-live="polite">
                            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
                        </div>
                    @endif

                    <!-- Filter Section -->
                    <div class="mb-1 p-3 bg-light rounded">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="flex-grow-1 me-3" style="max-width: 400px;">
                                <div class="input-group shadow-sm rounded">
                                    <span class="input-group-text bg-white border-end-0" id="search-icon">
                                        <i class="bi bi-search text-muted"></i>
                                    </span>
                                    <input
                                        type="search"
                                        id="genreSearch"
                                        class="form-control form-control-sm border-start-0"
                                        placeholder="{{ __('Search genres...') }}"
                                        aria-label="{{ __('Search Genres') }}"
                                        aria-describedby="search-icon"
                                    >
                                </div>
                            </div>
                            <div id="lengthDropdownContainer"></div>
                        </div>
                    </div>
                    <!-- Removed default DataTables search input; only custom search bar is shown -->

                    @if($genres->isEmpty())
                        @include('partials.empty-state', [
                            'icon' => 'bi-emoji-frown',
                            'title' => __('No genres found'),
                            'message' => __('Get started by adding your first genre to organize your library.'),
                            'actionRoute' => route('genre.create'),
                            'actionLabel' => __('Add Genre')
                        ])
                    @else
                    <div class="table-responsive">
                        <table id="genreIndex" class="table table-hover table-striped align-middle genre-table" aria-label="{{ __('Genres Table') }}">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">{{ __('ID') }}</th>
                                    <th scope="col">{{ __('Genre Name') }}</th>
                                    <th scope="col">{{ __('Description') }}</th>
                                    <th scope="col">
                                        {{ __('Titles') }}
                                    </th>
                                    <th scope="col" class="text-center">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($genres as $genre)
                                    <tr>
                                        <td>{{ $genre->id }}</td>
                                        <td>
                                            <a href="{{ route('genre.show', $genre) }}" class="fw-semibold text-decoration-underline text-primary" aria-label="{{ __('View details for') }} {{ $genre->name }}">
                                                {{ $genre->name }}
                                            </a>
                                        </td>
                                        <td>
                                            @if($genre->description)
                                                <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $genre->description }}">
                                                    {{ \Illuminate\Support\Str::limit($genre->description, 40) }}
                                                </span>
                                            @else
                                                <span class="text-muted">{{ __('—') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $books = $genre->catalogueEntries;
                                                $bookTitles = $books->pluck('title');
                                                $tooltipTitles = $bookTitles->take(10)->implode(', ');
                                                $remaining = $bookTitles->count() - 10;
                                                $tooltip = $tooltipTitles;
                                                if ($remaining > 0) {
                                                    $tooltip .= ', ... ' . __('and') . ' ' . $remaining . ' ' . __('more');
                                                }
                                            @endphp
                                            @if($books->count() > 0)
                                                <span class="badge bg-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $tooltip }}">
                                                    {{ $books->count() }}
                                                </span>
                                            @else
                                                <span class="text-muted">0</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @include('partials.genre-actions', ['genre' => $genre])
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">{{ __('No genres found.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @include('partials.archive-modal')
    @include('partials.delete-modal')
@endsection

@push('scripts')
    <script src="{{ asset('js/genre.js') }}"></script>
@endpush
