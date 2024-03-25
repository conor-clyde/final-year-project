<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Archived Books') }}
        </h2>
    </x-slot>

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

                    <!-- Go back and Unarchive all buttons -->
                    <div class="top-buttons d-flex justify-content-between">
                        <a href="{{ route('book') }}" class="btn btn-secondary">Go Back</a>
                        <div>
                            <a href="{{ route('book.unarchive-all') }}" class="btn btn-primary" style="margin-bottom: 40px;">Unarchive All</a>
                        </div>
                    </div>

                    <table id="bookArchived" class="data-table table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Publisher</th>
                            <th>Condition</th>
                            <th>Status</th>
                            <th>Loans</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($books as $book)

                            <tr>
                                <td>{{ $book->id }}</td>
                                <td>{{ $book->catalogueEntry->title }}</td>
                                <td>
                                @foreach ($book->catalogueEntry->authors as $author)
                                    {{ $author->surname }}, {{ $author->forename }}
                                    <br>
                                @endforeach
                                </td>
                                <td>{{ $book->publisher->name }},<br>
                                    {{ \Carbon\Carbon::parse($book->publish_date)->format('jS M Y') }}</td>
                                <td>{{ $book->condition->name }}</td>
                                <!-- Status column -->
                                <td>
                                    @if ($book->isOnLoan())
                                        On Loan
                                    @else
                                        Available
                                    @endif
                                </td>
                                <td>{{ $book->popularity() }}</td>
                                <td>
                                    <a class="btn btn-primary btn-width-80" href="{{ $book->id }}">Details</a>
                                </td>
                                <td>
                                    <a href="unarchive/{{$book->id}}" class="btn btn-primary">Unarchive</a>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger deleteCategoryBtn btn-width-80"
                                            value="{{$book->id}}" data-bs-toggle="modal" data-bs-target="#deleteModal">
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

    @include('partials.delete-modal', ['modalId' => 'deleteModal', 'formAction' => url('book/delete'), 'textareaId' => 'deleteQuestion', 'archive_genre_id' => 'archive_genre_id', 'confirmDeleteBtn' => 'confirmDeleteBtn'])

    <!-- Imported scripts -->
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
    <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">

    <!-- DataTables Responsive CSS -->
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

    <!-- DataTables Responsive JS -->
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#bookArchived').DataTable({
                responsive: true,
                dom: '<"top"fli>rt<"bottom"pB>',
                language: {
                    lengthMenu: 'Show _MENU_',
                    info: 'Displaying _START_-_END_ out of _TOTAL_',
                    search: 'Search Books:',
                },
                buttons: [{
                    extend: 'csv',
                    text: 'Export Book List',
                    exportOptions: {columns: [0, 1, 2, 3, 4]},
                    title: 'Books'
                }],
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10', '25', '50', 'All']
                ],
                columnDefs: [{
                    targets: [7, 8, 9],
                    orderable: false,
                    searchable: false,
                }],
                order: [[1, 'asc']]
            });

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
            var book_id = $(this).val();

            $.ajax({
                url: '{{ route('book.check-delete', ':id') }}'.replace(':id', book_id),
                type: 'GET',
                success: function (response) {
                    console.log(response.message);
                    $('#deleteQuestion').val(response.message);
                    $('#category_id').val(book_id);

                    var deletable = response.deletable;

                    if (deletable) {
                        $('#confirmDeletionBtn').show();
                        // Set the href attribute of the confirm button
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

