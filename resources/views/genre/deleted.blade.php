@extends('layouts.app')

@section('title', 'Deleted Genres | Library Management System')

@section('content')
    <div class="py-12" role="main">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card shadow genre-card">
                <div class="card-header bg-light d-flex justify-content-between align-items-center rounded-top">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-trash me-2 text-danger genre-empty-animate" style="font-size:1.5rem;"></i>
                        <div>
                            <span class="fw-bold">{{ __('Deleted Genres') }}</span>
                            <div class="text-muted small">{{ __('Genres that have been deleted. You can restore them or permanently remove them from the system.') }}</div>
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
                            'icon' => 'bi-trash',
                            'title' => __('No deleted genres'),
                            'message' => __('You have not deleted any genres yet. Deleted genres will appear here and can be restored or permanently removed.'),
                            'actionRoute' => route('genre.index'),
                            'actionLabel' => __('Back to Genres')
                        ])
                    @else
                    <div class="table-responsive">
                        <table id="genreDeleted" class="table table-hover table-striped align-middle genre-table" role="table" aria-label="{{ __('Deleted Genres Table') }}">
                            <thead class="table-light">
                                <tr role="row">
                                    <th role="columnheader">ID</th>
                                    <th role="columnheader">{{ __('Genre Name') }}</th>
                                    <th role="columnheader">{{ __('Description') }}</th>
                                    <th role="columnheader">{{ __('Book Count') }}</th>
                                    <th class="text-center" role="columnheader">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($genres as $genre)
                                    <tr role="row">
                                        <td role="cell">{{ $genre->id }}</td>
                                        <td role="cell">
                                            <a href="{{ route('genre.show', $genre) }}" class="fw-semibold text-primary text-decoration-underline" aria-label="{{ __('View details for') }} {{ $genre->name }}">{{ $genre->name }}</a>
                                        </td>
                                        <td role="cell">
                                            @if($genre->description)
                                                <span data-bs-toggle="tooltip" title="{{ $genre->description }}">{{ \Illuminate\Support\Str::limit($genre->description, 40) }}</span>
                                            @else
                                                <span class="text-muted">{{ __('') }}</span>
                                            @endif
                                        </td>
                                        <td role="cell">
                                            @if($genre->catalogueEntries && $genre->catalogueEntries->count() > 0)
                                                <span class="badge bg-primary" data-bs-toggle="tooltip" title="{{ $genre->catalogueEntries->pluck('title')->take(5)->implode(', ') }}@if($genre->catalogueEntries->count() > 5), ...@endif">
                                                    {{ $genre->catalogueEntries->count() }}
                                                </span>
                                            @else
                                                <span class="text-muted">0</span>
                                            @endif
                                        </td>
                                        <td class="text-center" role="cell">
                                            <form action="{{ route('genre.restore', ['id' => $genre->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to restore this genre?') }}');">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-success btn-sm me-1" data-bs-toggle="tooltip" title="{{ __('Restore Genre') }}" aria-label="{{ __('Restore Genre') }}">
                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('genre.forceDelete', ['id' => $genre->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to PERMANENTLY DELETE this genre? This action cannot be undone.') }}');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm" data-bs-toggle="tooltip" title="{{ __('Permanently Delete Genre') }}" aria-label="{{ __('Permanently Delete Genre') }}">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                            </form>
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
@endsection

@push('scripts')
    <script src="{{ asset('js/genre.js') }}"></script>
@endpush
