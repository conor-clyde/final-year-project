<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Author') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 genres">

                    <a href="{{ route('author') }}" class="btn btn-secondary mb-4">Go Back</a>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="post" action="{{ route('author.update', $author->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row align-items-center">
                            <div class="col-md-11">
                                <div class="top-buttons d-flex justify-content-between">
                                    <h3>Surname <span class="text-danger">*</span></h3>
                                    <div>
                                        <h3><span class="text-danger">*</span> = required</h3>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <input type="text" class="form-control" id="surname" placeholder="Enter surname..."
                                           name="surname" value="{{ $author->surname }}" required/>
                                </div>

                                <div class="mb-3">
                                    <h3>Forename</h3>
                                    <input type="text" class="form-control" id="forename"
                                           placeholder="Enter forename..." name="forename"
                                           value="{{ $author->forename }}" required/>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Update Author</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" type="text/css" href="{{ asset('styles.css') }}">
</x-app-layout>
