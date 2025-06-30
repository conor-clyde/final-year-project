@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="card shadow genre-card">
                <div class="card-header bg-light d-flex justify-content-between align-items-center rounded-top">
                    <span><i class="bi bi-plus-circle me-2 text-primary"></i>Create a New Genre</span>
                    <a href="{{ route('genre.index') }}" class="btn btn-outline-secondary" aria-label="Back to Genres">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('genre.store') }}" method="POST" autocomplete="off" role="form">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Genre Name') }} <span class="text-danger" aria-label="{{ __('required') }}">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required aria-required="true" placeholder="e.g. Science Fiction" aria-describedby="genreNameHelp" autofocus>
                            <small id="genreNameHelp" class="form-text text-muted">{{ __('Enter a unique name for the genre (max 255 characters).') }}</small>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('Description') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="{{ __('Describe this genre (optional, max 255 characters)') }}" aria-describedby="descriptionHelp">{{ old('description') }}</textarea>
                            <small id="descriptionHelp" class="form-text text-muted">{{ __('Description is optional, max 255 characters.') }}</small>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i> {{ __('Add Genre') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
