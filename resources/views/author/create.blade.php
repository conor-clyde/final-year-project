<x-app-layout>

    <!-- Header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Author') }}
        </h2>
    </x-slot>

    <!-- Author.create -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 genres">

                    {{-- Error Message --}}
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
                        <a href="{{ route('author') }}" class="btn btn-secondary mb-4 returnBtn">Go Back</a>
                        <div>
                            <h3><span class="text-danger">*</span> = required</h3>
                        </div>
                    </div>

                    <!-- Add Author Form -->
                    <form method="post" action="{{ route('author.store') }}">
                        @csrf

                        {{-- Author Forename --}}
                        <div class="row align-items-center">
                            <label class="form-label" for="forename">Forename <span
                                    class="text-danger">*</span></label>
                            <input required id="forename" type="text" class="form-control" name="forename"
                                   value="{{ old('forename') }}" placeholder="Enter forename..."/>

                            {{-- Author Surname --}}
                            <label class="form-label" for="surname">Surname <span
                                    class="text-danger">*</span></label>
                            <input required id="surname" type="text" class="form-control" name="surname"
                                   value="{{ old('surname') }}" placeholder="Enter surname..."/>

                            {{-- Confirm Author Button --}}
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary confirmBtn">Confirm Author</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" type="text/css" href="{{ asset('styles.css') }}">
</x-app-layout>
