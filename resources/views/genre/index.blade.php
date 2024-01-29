
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book Genres') }}
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
                    <a href="{{ route('genre.create') }}" class="btn btn-primary" style="margin-bottom: 40px;">Add Genre</a>
                        <a href="{{ route('genre.archived') }}" class="btn btn-primary" style="margin-bottom: 40px;">Archived Genres</a>

                        <a href="{{ route('genre.deleted') }}" class="btn btn-danger" style="margin-bottom: 40px;">Deleted Genres</a>






                        <form action="{{ route('genre.bulk-delete') }}" method="post">
                            @csrf
                            @method('delete')

                    <table id="myTable" class="genreTable table">
                        <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>Genre Name</th>
                            <th>Catalogue Entries</th>

                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>



                        @foreach ($genres as $genre)
                            <tr>
                                <td><input type="checkbox" name="selected_genres[]" value="{{ $genre->id }}"></td>
                                <td>{{ $genre->name }}</td>
                                <td>{{ $genre->popularity() }}</td>
                                <td>
                                    <a class="btn btn-secondary" href="genre/{{ $genre->id }}">View Details</a>

                                </td>
                                <td>
                                    <a href="genre/{{$genre->id}}/edit" class="btn btn-primary">Edit</a>
                                </td>
                                <td>
                                    <a href="genre/archive/{{$genre->id}}" class="btn btn-primary">Archive</a>
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
                            <!-- Add a button for bulk archive -->
                            <button id="bulk-archive-btn" class="btn btn-primary">Archive Selected Genres</button>

                            <button class="btn btn-danger" type="submit">Delete Selected Genres</button>
                        </form>

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
                    <input type="hidden" name="genre_id" id="category_id">
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

    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">


    <!-- DataTables Buttons JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>



    <script>
        $(document).ready(function () {
            $('#myTable').DataTable({
                dom: 'lfrtBip', // Add buttons to the DOM
                buttons: [
                    {
                        extend: 'csv',
                        text: 'Export as CSV', // Set your desired text

                    }],
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10', '25', '50', 'All']
                ],

                columnDefs: [
                    { targets: [0, 3, 4, 5, 6], orderable: false, searchable: false }
                ]
            });
        });
    </script>



    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Your existing code

            // Handle "Check All" checkbox
            document.getElementById('select-all').addEventListener('change', function () {
                var isChecked = this.checked;
                var genreCheckboxes = document.querySelectorAll('input[name="selected_genres[]"]');

                genreCheckboxes.forEach(function (checkbox) {
                    checkbox.checked = isChecked;
                });
            });

            // Handle bulk archive action
            document.getElementById('bulk-archive-btn').addEventListener('click', function () {
                event.preventDefault();

                var selectedGenres = [];
                var genreCheckboxes = document.querySelectorAll('input[name="selected_genres[]"]:checked');

                genreCheckboxes.forEach(function (checkbox) {
                    selectedGenres.push(checkbox.value);
                });

                if (selectedGenres.length > 0) {
                    $.ajax({
                        url: '{{ route('genre.bulk-archive') }}',
                        type: 'POST',
                        data: {
                            selected_genres: selectedGenres,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            console.log(response);
                            window.location.reload();
                        },
                        error: function (error) {
                            console.error(error);
                        }
                    });
                }
            });
        });

    </script>










</x-app-layout>






