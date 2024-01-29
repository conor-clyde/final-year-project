

<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book Authors') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 genres">
                    <a href="{{ route('author.create') }}" class="btn btn-primary" style="margin-bottom: 40px;">Add Author</a>
                    @if(Session::has('flashMessage'))
                        <div class="alert alert-success">
                            {{ Session::get('flashMessage') }}
                        </div>
                    @endif



                    <table id="myTable" class="genreTable table">
                        <thead>
                        <tr>
                            <th>Surname</th>
                            <th>Forename</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($authors as $author)
                            <tr>
                                <td>{{ $author->surname }}</td>
                                <td>{{ $author->forename }}</td>
                                <td>
                                    <a href="author/{{$author->id}}/edit" class="btn btn-primary">Edit</a>
                                </td>
                                <td>
                                    {!! Form::open(['url' => ['author/delete', $author->id], 'method' => 'POST', 'class' => 'pull-right']) !!}

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


            $('.deleteCategoryBtn').click(function(e) {
                e.preventDefault();

                var category_id = $(this).val();
                $('#category_id').val(category_id);
                $('#deleteModal').modal('show');

            });
        });
    </script>




</x-app-layout>


