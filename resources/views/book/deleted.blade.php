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

                    <!-- Return and Restore all buttons -->
                    <div class="top-buttons d-flex justify-content-between">
                        <a href="{{ route('book') }}" class="btn btn-secondary" style="margin-bottom: 40px;">Go Back</a>
                        <div>
                            <a href="{{ route('book.restore-all') }}" class="btn btn-primary"
                               style="margin-bottom: 40px;">Restore All</a>
                        </div>
                    </div>

                    <table id="deletedBook" class="data-table table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>PB/HC</th>
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
                                <td>
                                    @if ($book->format->name == "Paperback")
                                        PB
                                    @else
                                        HC
                                    @endif
                                </td>
                                <td>{{ $book->catalogueEntry->title }}</td>
                                <td>
                                    @foreach ($book->catalogueEntry->authors as $author)
                                        {{ $author->forename }} {{ $author->surname }}
                                        @if (!$loop->last)
                                            &amp;
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ $book->publisher->name }}<br>
                                    ({{ \Carbon\Carbon::parse($book->publish_date)->format('jS M Y') }})</td>
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
                                <td style="padding-right:4px; padding-left: 4px;">
                                    <a class="btn btn-primary btn-width-80" href="{{ $book->id }}">Details</a>
                                </td>
                                <td style="padding-right:4px; padding-left: 4px;">
                                    <a href="restore/{{$book->id}}" class="btn btn-primary">Restore</a>
                                </td>
                                <td style="padding-right:4px; padding-left: 4px;">
                                    {!! Form::open(['url' => ['book/permanent-delete', $book->id], 'method' => 'POST', 'class' => 'pull-right']) !!}

                                    {!! Form::hidden('_method', 'DELETE') !!}
                                    {!! Form::submit('Perm. Delete', ['class' => 'btn btn-danger', 'style' => "background-color: #dc3545;", 'onclick' => 'confirmPermanentDelete(event, ' . $book->id . ')']) !!}

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

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

    <!-- DataTables Buttons JS -->
    <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>

    <!-- DataTables Responsive JS -->
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#deletedBook').DataTable({
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
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    },
                    title: 'Deleted Books'
                }],
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10', '25', '50', 'All']
                ],
                columnDefs: [{
                    targets: [8, 9, 10],
                    orderable: false,
                    searchable: false,
                },
                    {
                        targets: [1, 5, 6, 7, 8, 9, 10],
                        searchable: false,
                    }],
                order: [[2, 'asc']]
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


</x-app-layout>






