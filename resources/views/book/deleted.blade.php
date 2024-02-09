
<style>

</style>
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Deleted Books') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 genres">
                    @if(Session::has('flashMessage'))
                        <div class="alert alert-success">
                            {{ Session::get('flashMessage') }}
                        </div>
                    @endif

                        <!-- Go Back button -->
                        <a href="{{ url()->previous() }}" class="btn btn-secondary mb-4">Go Back</a>

                    <table id="myTable" class="bookTable table">
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
                                    <a href="restore/{{$book->id}}" class="btn btn-primary">Restore</a>
                                </td>
                                <td>
                                    {!! Form::open(['url' => ['book/permanent-delete', $book->id], 'method' => 'POST', 'class' => 'pull-right']) !!}

                                    {!! Form::hidden('_method', 'DELETE') !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger', 'style' => "background-color: #dc3545;", 'onclick' => 'confirmPermanentDelete(event, ' . $book->id . ')']) !!}

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



    <!-- Modal -->
    <!-- Permanent Delete Modal -->
    <div class="modal fade" id="permanentDeleteModal" tabindex="-1" aria-labelledby="permanentDeleteModalLabel" aria-hidden="true">
        <!-- Modal content goes here -->

    </div>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>




    <script>
        $(document).ready(function () {
            $('#myTable').DataTable({
                columnDefs: [
                    { targets: [-2, -1], orderable: false, searchable: false }
                ]
            });
        });
    </script>








</x-app-layout>






