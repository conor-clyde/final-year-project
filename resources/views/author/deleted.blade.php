@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Deleted Authors') }}
    </h2>
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5 class="mb-0">Deleted Authors</h5>
                <div>
                    <a href="{{ route('author.index') }}" class="btn btn-secondary btn-sm">Return to Authors</a>
                    <a href="{{ route('author.restore-all') }}" class="btn btn-primary btn-sm">Restore All</a>
                </div>
            </div>
            <div class="card-body">
                @if(session('flashMessage'))
                    <div class="alert alert-success mb-4">
                        {{ session('flashMessage') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table id="authorDeleted" class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Forename</th>
                            <th>Surname</th>
                            <th>Books</th>
                            <th class="text-end">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($authors as $author)
                            <tr>
                                <td>{{ $author->id }}</td>
                                <td>{{ $author->forename }}</td>
                                <td>{{ $author->surname }}</td>
                                <td>{{ $author->popularity() }}</td>
                                <td class="text-end">
                                    <form action="{{ route('author.force-delete', $author->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('author.restore', $author->id) }}" class="btn btn-primary btn-sm">{{ __('Restore') }}</a>
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('Are you sure you want to permanently delete this author? This action cannot be undone.') }}')">
                                            {{ __('Force Delete') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            @include('partials.empty-state', [
                                'icon' => 'bi-emoji-frown',
                                'title' => __('No deleted authors'),
                                'message' => __('No deleted authors found. Deleted authors will appear here and can be restored or permanently removed.'),
                                'actionRoute' => route('author.index'),
                                'actionLabel' => __('Back to Authors')
                            ])
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/author.js') }}"></script>
@endpush






