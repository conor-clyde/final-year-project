@extends('layouts.app')

@section('title', 'Archived Genres | Library Management System')

@section('content')
    <div class="py-12" role="main">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card shadow genre-card">
                <div class="card-header bg-light d-flex justify-content-between align-items-center rounded-top">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-archive me-2 text-secondary genre-empty-animate" style="font-size:1.5rem;"></i>
                        <div>
                            <span class="fw-bold">{{ __('Archived Genres') }}</span>
                            <div class="text-muted small">{{ __('Genres that have been archived and are not currently active. You can restore them at any time.') }}</div>
                        </div>
                    </div>
                    <a href="{{ route('genre.index') }}" class="btn btn-outline-secondary" aria-label="{{ __('Back to Genres') }}">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert" aria-live="polite">
                            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
                        </div>
                    @endif
                    @if($genres->isEmpty())
                        @include('partials.empty-state', [
                            'icon' => 'bi-archive',
                            'title' => __('No archived genres'),
                            'message' => __('You have not archived any genres yet. Archived genres will appear here and can be restored at any time.'),
                            'actionRoute' => route('genre.index'),
                            'actionLabel' => __('Back to Genres')
                        ])
                    @else
                    <div class="table-responsive">
                        <table id="genreArchived" class="table table-hover table-striped align-middle genre-table" role="table" aria-label="{{ __('Archived Genres Table') }}">
                            <thead class="table-light">
                                <tr role="row">
                                    <th role="columnheader">ID</th>
                                    <th role="columnheader">{{ __('Name') }}</th>
                                    <th role="columnheader">{{ __('Book Count') }}</th>
                                    <th class="text-center" role="columnheader">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($genres as $genre)
                                    <tr role="row">
                                        <td role="cell">{{ $genre->id }}</td>
                                        <td role="cell">
                                            <span class="fw-semibold" data-bs-toggle="tooltip" title="{{ __('Genre ID:') }} {{ $genre->id }}">{{ $genre->name }}</span>
                                        </td>
                                        <td role="cell">
                                            @if($genre->catalogueEntries->count() > 0)
                                                <span class="badge bg-primary" data-bs-toggle="tooltip" title="{{ $genre->catalogueEntries->pluck('title')->take(5)->implode(', ') }}@if($genre->catalogueEntries->count() > 5), ...@endif">
                                                    {{ $genre->catalogueEntries->count() }}
                                                </span>
                                            @else
                                                <span class="text-muted">0</span>
                                            @endif
                                        </td>
                                        <td class="text-center" role="cell">
                                            <form action="{{ route('genre.unarchive', ['genre' => $genre->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to unarchive this genre?') }}');">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-success btn-sm me-1" data-bs-toggle="tooltip" title="{{ __('Unarchive Genre') }}" aria-label="{{ __('Unarchive Genre') }}">
                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                </button>
                                            </form>
                                            <button class="btn btn-outline-danger btn-sm deleteCategoryBtn" value="{{ $genre->id }}" data-bs-toggle="tooltip" title="{{ __('Delete Genre') }}" aria-label="{{ __('Delete Genre') }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @include('partials.delete-modal')
@endsection

@push('scripts')
    <script src="{{ asset('js/genre.js') }}"></script>

@endpush






