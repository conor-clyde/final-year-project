

<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Archived Authors') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 genres">

                    <!-- Flash message -->
                    @if(session('flashMessage'))
                        <div class="alert alert-success mb-4">
                            {{ session('flashMessage') }}
                        </div>
                    @endif

                    <!-- Go back and Unarchive all buttons -->
                    <div class="top-buttons d-flex justify-content-between">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Go Back</a>
                        <div>
                            <a href="{{ route('author.unarchive-all') }}" class="btn btn-primary" style="margin-bottom: 40px;">Unarchive All</a>
                        </div>
                    </div>


                    <table id="authorArchived" class="data-table table">
                        <thead>
                        <tr>
                            <th>Surname</th>
                            <th>Forename</th>
                            <th>Books</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($authors as $author)
                            <tr>
                                <td>{{ $author->surname }}</td>
                                <td>{{ $author->forename }}</td>
                                <td>{{ $author->popularity() }}</td>
                                <td>
                                    <a class="btn btn-primary btn-width-80" href="{{ $author->id }}">Details</a>
                                </td>
                                <td>
                                    <a href="unarchive/{{$author->id}}" class="btn btn-primary btn-width-100">Unarchive</a>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger deleteCategoryBtn btn-width-80"
                                            value="{{$author->id}}" data-bs-toggle="modal" data-bs-target="#deleteModal">
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


    @include('partials.delete-modal', ['modalId' => 'deleteModal', 'formAction' => url('author/delete'), 'textareaId' => 'deleteQuestion', 'archive_genre_id' => 'archive_genre_id', 'confirmDeleteBtn' => 'confirmDeleteBtn'])


    <!-- Imported scripts -->
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>

    @include('partials.delete-modal', ['modalId' => 'deleteModal', 'formAction' => url('genre/delete'), 'textareaId' => 'deleteQuestion', 'archive_genre_id' => 'archive_genre_id', 'confirmDeletionBtn' => 'confirmDeletionBtn'])


    <script>
        // Create genre.index datatable
        $(document).ready(function () {
            $('#authorArchived').DataTable({
                dom: '<"top"fli>rt<"bottom"pB>',
                language: {
                    lengthMenu: 'Show _MENU_',
                    info: 'Displaying _START_-_END_ out of _TOTAL_',
                    search: 'Search Authors:',
                },
                buttons: [{
                    extend: 'csv',
                    text: 'Export Author List',
                    exportOptions: { columns: [0, 1, 2] },
                    title: 'Authors'
                }],
                responsive: true,
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10', '25', '50', 'All']
                ],
                columnDefs: [{
                    targets: [3, 4, 5],
                    orderable: false,
                    searchable: false,
                }]});

            <!-- Styles-->
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
    </script>

    <!-- Confirm delete-->
    <script>
        $('.deleteCategoryBtn').click(function (e) {
            e.preventDefault();

            var category_id = $(this).val();

            $.ajax({
                url: '{{ route('author.check-deletion', ':id') }}'.replace(':id', category_id),
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
