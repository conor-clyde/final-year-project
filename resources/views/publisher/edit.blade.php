<x-app-layout>

    <!-- Header-->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Publisher') }}
        </h2>
    </x-slot>

    <!-- Publisher.edit-->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 genres">

                    <!-- Errors-->
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
                        <a href="{{ route('publisher') }}" class="btn btn-secondary mb-4 returnBtn">Go Back</a>
                        <div>
                            <h3><span class="text-danger">*</span> = required</h3>
                        </div>
                    </div>

                    <form method="post" action="{{ route('publisher.update', $publisher->id) }}">
                        @csrf
                        @method('PUT')

                        {{-- Publisher Name --}}
                        <div class="row align-items-center">
                            <label class="form-label" for="forename">Publisher <span
                                    class="text-danger">*</span></label>
                            <input id="name" type="text" class="form-control" name="name"
                                   required placeholder="Enter Publisher..." value="{{ $publisher->name }}"/>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Update Publisher</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" type="text/css" href="{{ asset('styles.css') }}">
</x-app-layout>
