<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Genre') }}
        </h2>
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
                            <div class="col-md-11">
                                    <h3>Genre <span class="text-danger">*</span></h3>

                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="name" name="name"
                                           value="{{ old('name') }}"
                                           placeholder="Enter genre..." required/>
                                </div>

                                <div class="mb-3">
                                    <h3>Description</h3>
                                    <textarea class="form-control" id="description" name="description"
                                              style="resize: vertical; min-height: 100px; max-height: 200px;"
                                              placeholder="Enter description..."
                                              rows="8">{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Confirm Genre</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" type="text/css" href="{{ asset('styles.css') }}">
</x-app-layout>
