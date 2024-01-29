

<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Books') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 genres">
                    <a href="{{ route('book.create') }}" class="btn btn-primary" style="margin-bottom: 40px;">Add Book</a>
                    <a href="{{ route('book.archived') }}" class="btn btn-warning" style="margin-bottom: 40px;">Archived Books</a>




                    <table id="myTable" class="genreTable table">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Genre</th>
                            <th>Publisher</th>
                            <th>Year</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($books as $book)

                            <tr>
                                <td>{{ $book->title }}</td>
                                <td>{{ $book->surname }}, {{ $book->forename }}</td>
                                <td>{{ $book->genre }}</td>
                                <td>{{ $book->publisher }}</td>
                                <td>{{ $book->year_published }}</td>

                                <td>
                                    <a href="book/{{$book->book_id}}/edit" class="btn btn-primary">Edit</a>
                                </td>
                                <td>
                                    <a href="book/archive/{{$book->book_id}}" class="btn btn-warning">Archive</a>
                                </td>

                                <td>
                                    {!! Form::open(['url' => ['book/delete', $book->book_id], 'method' => 'POST', 'class' => 'pull-right']) !!}

                                    {!! Form::hidden('_method', 'DELETE') !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger', 'style' => "background-color: #dc3545;"]) !!}

                                    {!! Form::close() !!}
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready( function () {
            $('#myTable').DataTable();
        });
    </script>




</x-app-layout>

