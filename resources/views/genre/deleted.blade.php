
<style>

</style>
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Deleted Genres') }}
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
                    <a href="{{ route('genre') }}" class="btn btn-primary" style="margin-bottom: 40px;">Return</a>






                    <table id="myTable" class="genreTable table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Creation Date</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>



                        @foreach ($genres as $genre)
                            <tr>
                                <td>{{ $genre->name }}</td>
                                <td>{{ date('d-m-Y', strtotime($genre->created_at)) }}</td>
                                <td>
                                    <a href="restore/{{$genre->id}}" class="btn btn-primary">Restore</a>
                                </td>
                                <td>
                                    {!! Form::open(['url' => ['genre/permanent-delete', $genre->id], 'method' => 'POST', 'class' => 'pull-right']) !!}

                                    {!! Form::hidden('_method', 'DELETE') !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger', 'style' => "background-color: #dc3545;", 'onclick' => 'confirmPermanentDelete(event, ' . $genre->id . ')']) !!}

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






