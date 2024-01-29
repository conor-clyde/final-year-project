
<style>

</style>
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Archived Genres') }}
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
                                    <a href="unarchive/{{$genre->id}}" class="btn btn-primary">Unarchive</a>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger deleteCategoryBtn" value="{{$genre->id}}" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                        Delete
                                    </button>
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
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ url('genre/delete') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Genre</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="category_delete_id" id="category_id">
                        <textarea style="border: none; border-color: transparent; width:100%; resize: none;" readonly id="deleteQuestion" cols="50" rows="2"></textarea>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Cancel</button>

                        <button id="confirmDeletionBtn" type="submit" class="btn btn-danger">Confirm Deletion</button>

                    </div>
                </form>
            </div>

        </div>
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






