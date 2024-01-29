<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Book') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 genres">



                    <form method="post" action="{{ route('book.store') }}">
                        <div class="form-group">
                            @csrf
                            <label for="name">Title</label>
                            <input type="text" class="form-control" name="title" placeholder="Title"/>
                            <label for="author">Author:</label>
                            <select name="author" id="author" required>
                                @foreach($authors as $author)
                                    <option value="{{ $author->id }}">{{ $author->surname }}, {{ $author->forename }} </option>
                                @endforeach
                            </select>


                            <label for="genre">Genre:</label>
                            <select name="genre" id="genre" required>
                                @foreach($genres as $genre)
                                    <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                                @endforeach
                            </select>

                            <label for="publisher">Publisher:</label>
                            <select name="publisher" id="publisher" required>
                                @foreach($publishers as $publisher)
                                    <option value="{{ $publisher->id }}">{{ $publisher->name }}</option>
                                @endforeach
                            </select>
                            <label for="year">Year:</label>
                            <input type="number" name="year" id="year" required>
                        </div>


                        <button type="submit" class="btn btn-primary" style="background-color: #0d6efd;">Confirm Book</button>

                    </form>










                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" type="text/css" href="{{ asset('custom.css') }}" >
</x-app-layout>

