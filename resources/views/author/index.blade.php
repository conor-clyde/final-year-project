@extends('layouts.app')

@section('title', __('Authors') . ' | Library Management System')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card shadow genre-card">
                <div class="card-header bg-light d-flex justify-content-between align-items-center rounded-top position-relative" style="min-height: 3.5rem;">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-person-lines-fill me-2 text-primary genre-empty-animate" style="font-size:1.7rem;"></i>
                        <h3 class="fw-bold mb-0">{{ __('Authors') }}</h3>
                    </div>
                    <div>
                        <a href="{{ route('author.create') }}" class="btn btn-primary me-2" aria-label="{{ __('Add Author') }}">
                            <i class="bi bi-plus-circle me-1"></i> {{ __('Add Author') }}
                        </a>
                        <a href="{{ route('author.archived') }}" class="btn btn-outline-secondary me-2" aria-label="{{ __('View Archived Authors') }}">
                            <i class="bi bi-archive"></i>
                        </a>
                        <a href="{{ route('author.deleted') }}" class="btn btn-outline-danger" aria-label="{{ __('View Deleted Authors') }}">
                            <i class="bi bi-trash"></i>
                        </a>
                        <span data-bs-toggle="tooltip" class="ms-3" title="{{ __('\'Archived\' authors are hidden from active lists but can be restored. \'Deleted\' authors are removed but can be restored from the deleted list.') }}">
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
                                        id="authorSearch"
                                        class="form-control form-control-sm border-start-0"
                                        placeholder="{{ __('Search authors...') }}"
                                        aria-label="{{ __('Search Authors') }}"
                                        aria-describedby="search-icon"
                                    >
                                </div>
                            </div>
                            <div id="lengthDropdownContainer"></div>
                        </div>
                    </div>
                    <!-- Removed default DataTables search input; only custom search bar is shown -->

                    @if($authors->isEmpty())
                        @include('partials.empty-state', [
                            'icon' => 'bi-emoji-frown',
                            'title' => __('No authors found'),
                            'message' => __('Get started by adding your first author.'),
                            'actionRoute' => route('author.create'),
                            'actionLabel' => __('Add Author')
                        ])
                    @else
                    <div class="table-responsive">
                        <table id="authorIndex" class="table table-hover table-striped align-middle genre-table" aria-label="{{ __('Authors Table') }}">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">{{ __('ID') }}</th>
                                    <th scope="col">{{ __('Forename') }}</th>
                                    <th scope="col">{{ __('Surname') }}</th>
                                    <th scope="col">{{ __('Books') }}</th>
                                    <th scope="col" class="text-center">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($authors as $author)
                                    <tr>
                                        <td>{{ $author->id }}</td>
                                        <td>{{ $author->forename }}</td>
                                        <td>{{ $author->surname }}</td>
                                        <td>{{ $author->popularity() }}</td>
                                        <td class="text-center">
                                            @include('partials.author-actions', ['author' => $author])
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">{{ __('No authors found.') }}</td>
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
    <script src="{{ asset('js/author.js') }}"></script>
@endpush
