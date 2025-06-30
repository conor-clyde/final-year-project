@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Add Author') }}
    </h2>
@endsection

@section('content')
    <div class="container py-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ __('Add a new Author') }}</h5>
                <h5 class="mb-0 text-danger" style="font-size: 0.9rem;"><span class="text-danger">*</span> Required</h5>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="post" action="{{ route('author.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="forename">{{ __('Forename') }} <span class="text-danger">*</span></label>
                        <input required id="forename" type="text" class="form-control @error('forename') is-invalid @enderror" name="forename" value="{{ old('forename') }}" placeholder="{{ __('Enter forename...') }}" autofocus />
                        @error('forename')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="surname">{{ __('Surname') }} <span class="text-danger">*</span></label>
                        <input required id="surname" type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ old('surname') }}" placeholder="{{ __('Enter surname...') }}" />
                        @error('surname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('author.index') }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Add Author</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
