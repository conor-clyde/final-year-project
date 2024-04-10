<x-app-layout>
    <!-- Header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Deleted Genres') }}
        </h2>
    </x-slot>

    <!-- Genre.deleted -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 genres">

                    <!-- Flash message -->
                    @if(Session::has('flashMessage'))
                        <div class="alert alert-success">
                            {{ Session::get('flashMessage') }}
                        </div>
                    @endif

                        <!-- Return and Restore all buttons -->
                        <div class="top-buttons d-flex justify-content-between">
                            <a href="{{ route('genre') }}" class="btn btn-secondary" style="margin-bottom: 40px;">Go Back</a>
                            <div>
                                <a href="{{ route('genre.restore-all') }}" class="btn btn-primary" style="margin-bottom: 40px;">Restore All</a>
                            </div>
                        </div>

                    <!-- Deleted Genre table -->
                    <table id="genreDelete" class="data-table table">

                        <!-- Table headings -->
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Book Titles</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        <!-- Table Body -->
                        @foreach ($genres as $genre)
                            <tr>
                                <td>{{ $genre->id }}</td>
                                <td>{{ $genre->name }}</td>
                                <td>{{ $genre->popularity() }}</td>
                                <td style="padding-right:4px; padding-left: 4px;">
                                    <a class="btn btn-primary btn-width-80" href="{{ $genre->id }}">Details</a>
                                </td>
                                <td style="padding-right:4px; padding-left: 4px;">
                                    <a href="restore/{{$genre->id}}" class="btn btn-primary">Restore</a>
                                </td>
                                <td style="padding-right:4px; padding-left: 4px;">
                                    <form action="{{ route('genre.permanent-delete', $genre->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger">Perm. Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    @include('partials.delete-modal', ['modalId' => 'deleteModal', 'formAction' => url('genre/delete'), 'textareaId' => 'deleteQuestion', 'archive_genre_id' => 'archive_genre_id', 'confirmDeletionBtn' => 'confirmDeletionBtn'])


    <!-- Imported scripts -->
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#genreDelete').DataTable({
                dom: '<"top"fli>rt<"bottom"pB>',
                language: {
                    responsive:true,
                    lengthMenu: 'Show _MENU_',
                    info: 'Displaying _START_-_END_ out of _TOTAL_',
                    search: 'Search Genres:',
                },
                order: [[1, 'asc']],
                buttons: [{
                    extend: 'csv',
                    text: 'Export Genre List',
                    exportOptions: { columns: [1, 2] },
                    title: 'Deleted Genres'
                }],
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10', '25', '50', 'All']
                ],
                columnDefs: [{
                    targets: [3, 4, 5],
                    orderable: false,
                    searchable: false,
                },
                    {
                        targets: [2],
                        searchable: false,
                    }],
            });

            var wrapper = $('.dataTables_wrapper');
            var filter = wrapper.find('.dataTables_filter');
            var searchInput = filter.find('input');
            var lengthMenu = wrapper.find('.dataTables_length');
            var paginationContainer = $('.dataTables_paginate');

            var filter = wrapper.find('.dataTables_filter');
            filter.css('float', 'left');

            lengthMenu.css('float', 'right');
            searchInput.css({
                'margin-left': '20px',
                'width': '340px'
            });

            paginationContainer.addClass('float-start');
        });

        document.getElementById('select-all').addEventListener('change', function () {
            var isChecked = this.checked;
            var genreCheckboxes = document.querySelectorAll('input[name="selected_genres[]"]');

            genreCheckboxes.forEach(function (checkbox) {
                checkbox.checked = isChecked;
            });
        });
    </script>




</x-app-layout>
