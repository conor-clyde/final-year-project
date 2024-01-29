<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book Genres') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if(session('flashMessage'))
                    <div class="alert alert-success mb-4">
                        {{ session('flashMessage') }}
                    </div>
                @endif

                <a href="{{ route('genre') }}" class="btn btn-primary mb-4">Return to Genres</a>

                <div class="mb-8">
                    <h1 style="font-size: 2rem; font-weight: bold;">{{ $genre->name }} Details</h1>
                    <p>Descrption: {{ $genre->dsceiption }}</p>
                    <p class="text-gray-600">Creation Date: {{ $genre->created_at->format('F d, Y') }}</p>
                    <p class="text-gray-600">Last Updated: {{ $genre->updated_at->format('F d, Y') }}</p>
                    <p class="text-lg">{{ $genre->description }}</p>
                </div>

                <h2 class="text-xl font-semibold mb-4">Associated Catalogue Entries</h2>
                @if ($genre->catalogueEntries->count() > 0)
                    <table id="myTable" class="genreTable table">
                        <thead>
                        <tr>
                            <th>Book Title</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($genre->catalogueEntries as $catalogueEntry)
                            <tr>
                                <td>{{ $catalogueEntry->title }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-gray-600">No associated catalogue entries for this genre.</p>
                @endif
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>

</x-app-layout>
