<x-app-layout>

    <!-- Header -->
    <x-slot name="header">
        <h2 >
            {{ __('Archived Publishers') }}
        </h2>
    </x-slot>

    <!-- Genre.archived -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div >
                <div >

                    <!-- Flash message -->
                    @if(Session::has('flashMessage'))
                        <div class="alert alert-success">
                            {{ Session::get('flashMessage') }}
                        </div>
                    @endif

                        <!-- Go back and Unarchive all buttons -->
                        <div class="top-buttons d-flex justify-content-between">
                            <a href="{{ route('publisher') }}" class="btn btn-secondary">Go Back</a>
                            <div>
                                <a href="{{ route('publisher.unarchive-all') }}" class="btn btn-primary">Unarchive All</a>
                            </div>
                        </div>

                    <!-- Archived Genre table -->
                        <table id="genreArchive" class="data-table table">

                            <!-- Table headings -->
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Publisher</th>
                            <th>Book Titles</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        <!-- Table Body -->
                        @foreach ($publishers as $publisher)
                            <tr>
                                <td>
                                    {{$publisher->id}}
                                </td>
                                <td>{{ $publisher->name }}</td>
                                <td>{{ $publisher->popularity() }}</td>
                                <td>
                                    <a class="btn btn-primary" href="{{ $publisher->id }}">Details</a>
                                </td>
                                <td>
                                    <a href="unarchive/{{$publisher->id}}" class="btn btn-primary">Unarchive</a>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger deleteCategoryBtn" value="{{$publisher->id}}" data-bs-toggle="modal" data-bs-target="#deleteModal">
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

    @include('partials.delete-modal', ['modalId' => 'deleteModal', 'formAction' => url('publisher/delete'), 'textareaId' => 'deleteQuestion', 'archive_genre_id' => 'archive_genre_id', 'confirmDeletionBtn' => 'confirmDeletionBtn'])

    <!-- Imported scripts -->
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>



    <script>
        $(document).ready(function () {
            $('#genreArchive').DataTable({
                dom: '<"top"fli>rt<"bottom"pB>',
                language: {
                    lengthMenu: 'Show _MENU_',
                    info: 'Displaying _START_-_END_ out of _TOTAL_',
                    search: 'Search Publishers:',
                },
                order: [[1, 'asc']],
                buttons: [{
                    extend: 'csv',
                    text: 'Export Publisher List',
                    exportOptions: { columns: [1, 2] },
                    title: 'Archived Publishers'
                }],
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10', '25', '50', 'All']
                ],
                columnDefs: [{
                    targets: [],
                    orderable: false,
                    searchable: false,

                },
                    {
                        targets: [2],
                        searchable: false,
                    }],

                order: [[1, 'asc']]
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

    <!-- Confirm delete-->
    <script>
        $('.deleteCategoryBtn').click(function (e) {
            e.preventDefault();

            var category_id = $(this).val();

            $.ajax({
                url: '{{ route('publisher.check-delete', ':id') }}'.replace(':id', category_id),
                type: 'GET',
                success: function (response) {
                    console.log(response.message);
                    $('#deleteQuestion').val(response.message);
                    $('#category_id').val(category_id);

                    var deletable = response.deletable;

                    if (deletable) {
                        $('#confirmDeletionBtn').show();
                    } else {
                        $('#confirmDeletionBtn').hide();
                    }

                    // Show the modal
                    $('#deleteModal').modal('show');
                },
                error: function (error) {
                    // Handle errors, e.g., show an alert
                    alert('Error checking deletion status');
                }
            });
        });
    </script>








</x-app-layout>






