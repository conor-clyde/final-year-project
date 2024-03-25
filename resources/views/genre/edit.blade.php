<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Genre') }}
        </h1>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 genres">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <a href="{{ route('genre') }}" class="btn btn-secondary mb-4">Go Back</a>

                    <form method="post" action="{{ route('genre.update', $genre->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Genre Name:</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter name..." name="name" value="{{ $genre->name }}" required/>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description (Optional):</label>
                            <textarea class="form-control" id="description" placeholder="Enter description..." name="description" rows="5">{{ $genre->description }}</textarea>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Update Genre</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" type="text/css" href="{{ asset('styles.css') }}">
</x-app-layout>
