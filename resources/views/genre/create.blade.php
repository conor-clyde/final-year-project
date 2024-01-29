<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Book Genre') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 genres">
                    <a href="{{ route('genre') }}" class="btn btn-primary" style="margin-bottom: 40px;">Return</a>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif



                    <form method="post" action="{{ route('genre.store') }}">
                        <div class="form-group">
                            @csrf
                            <label for="name">Genre:</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter genre name..."/>
                        </div>


                        <button type="submit" class="btn btn-primary" style="background-color: #0d6efd;">Confirm Genre</button>

                    </form>










                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" type="text/css" href="{{ asset('custom.css') }}" >
</x-app-layout>

