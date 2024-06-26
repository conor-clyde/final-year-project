<x-app-layout>

    <!-- Header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Genre') }}
        </h2>
    </x-slot>

    <!-- Genre.create -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 genres">

                    <!-- Errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Return Button --}}
                    <div class="top-buttons d-flex justify-content-between">
                        <a href="{{ route('genre') }}" class="btn btn-secondary mb-4 returnBtn">Go Back</a>
                        <div>
                            <h3><span class="text-danger">*</span> = required</h3>
                        </div>
                    </div>

                    <form method="post" action="{{ route('genre.store') }}">
                        @csrf

                        {{-- Genre Name --}}
                        <div class="row align-items-center">
                            <label class="form-label" for="forename">Genre <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name"
                                   value="{{ old('name') }}" placeholder="Enter genre..." required/>


                            <label class="form-label" for="forename">Description</label>
                            <textarea class="form-control" id="description" name="description"
                                      style="resize: vertical; min-height: 100px; max-height: 200px;"
                                      placeholder="Enter description..."
                                      rows="5">{{ old('description') }}</textarea>

                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">Confirm Genre</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" type="text/css" href="{{ asset('styles.css') }}">
</x-app-layout>
