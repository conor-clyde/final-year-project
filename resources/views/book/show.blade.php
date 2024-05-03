<x-app-layout>
    <!-- Header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book Details') }}
        </h2>
    </x-slot>

    <!-- Genre.show -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Flash message -->
                @if(session('flashMessage'))
                    <div class="alert alert-success mb-4">
                        {{ session('flashMessage') }}
                    </div>
                @endif

                <!-- Go Back button -->
                <a href="{{ url()->previous() }}" class="btn btn-secondary mb-4">Go Back</a>


                <!-- Book Title Details-->
                <h2>Book Title Details</h2>
                @if (isset($book))
                        <?php
                        $books = \App\Models\BookCopy::where('catalogue_entry_id', $book->catalogue_entry_id)->get();
                        ?>
                    <p style="margin-bottom: 10px;">The library has {{ count($books) }} book(s) under this title. ID(s):
                        @foreach ($books as $book2)
                            {{ $book2->id }}
                            @if (!$loop->last)
                                <!-- Check if it's not the last book -->
                                , <!-- Add comma if it's not the last book -->
                            @endif
                        @endforeach
                    </p>
                @else
                    <p>No book found.</p>
                @endif

                <table id="showBookTitle" class="data-table table">
                    <!-- Table Headers -->
                    <thead>
                    <tr>
                        <th style="width: 20px">Detail</th>
                        <th>Value</th>
                    </tr>
                    </thead>


                    <!-- Table Body -->
                    <tbody>

                    {{-- Book Title --}}
                    <tr>
                        <td>Title</td>
                        <td>{{ $book->catalogueEntry->title }}</td>
                    </tr>
                    <tr>
                        <td>Author</td>
                        <td>
                            @foreach ($book->catalogueEntry->authors as $key => $author)
                                <label>ID: {{ $author->id }}</label><br>
                                Forename: {{ $author->forename }}<br>
                                Surname: {{ $author->surname }}
                                @if (!$loop->last)
                                    <br>      <br>
                                @endif
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td>Genre</td>
                        <td>{{ $book->catalogueEntry->genre->name }}</td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td style="max-width: 200px; word-wrap: break-word;">
                            <div id="shortDescription">
                                {{ \Illuminate\Support\Str::limit($book->catalogueEntry->description, 200) }}
                            </div>
                            <div id="fullDescription" style="display: none;">
                                {{ $book->catalogueEntry->description }}
                            </div>
                            @if (strlen($book->catalogueEntry->description) > 200)
                                <button id="toggleDescriptionBtn" class="btn btn-link" type="button">See Full
                                    Description
                                </button>
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>

                <h2>Book Copy Details</h2>
                <table id="showBook" class="data-table table">
                    <thead>
                    <tr>
                        <th style="max-width: 20px;">Detail</th>
                        <th>Value</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>ID</td>

                        <td>{{ $book->id }}</td>
                    </tr>
                    <tr>
                        <td>Format</td>
                        <td>{{ $book->format->name }}</td>
                    </tr>
                    <tr>
                        <td>Language</td>
                        <td>{{ $book->language->name }}</td>
                    </tr>
                    <tr>
                        <td>Condition</td>
                        <td>{{ $book->condition->name }}</td>
                    </tr>
                    <tr>
                        <td>Publisher</td>
                        <td>{{ $book->publisher->name }}</td>
                    </tr>
                    <tr>
                        <td>Publish Date</td>
                        <td>{{ date('jS M Y', strtotime($book->publish_date)) }}</td>

                    </tr>

                    <tr>
                        <td>Pages</td>
                        <td>{{ $book->pages ? : 'N/A' }}</td>
                    </tr>

                    <tr>
                        <td>Status</td>
                        <td>@if ($book->isOnLoan())
                                On Loan
                            @else
                                Available
                            @endif</td>
                    </tr>

                    <tr>
                        <td>
                            Archived
                        </td>
                        <td>
                            {{ $book->archived ? 'Yes'  : 'No' }}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Deleted
                        </td>
                        <td>
                            {{ $book->deleted ? 'Yes'  : 'No' }}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Added
                        </td>
                        <td>
                            {{ $book->created_at->format('jS M Y, H:i:s') }}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Last updated
                        </td>
                        <td>
                            {{ $book->updated_at->format('jS M Y, H:i:s') }}
                        </td>
                    </tr>

                    </tbody>
                </table>

                <h2>Loan Details</h2>
                <div class="mb-8">
                    <div class="row">
                        <div class="col-md-12">

                            <!-- Book Titles -->
                            @if ($book->loans->count() > 0)
                                <table id="showBookLoans" class="data-table table">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Patron</th>
                                        <th>Start Date</th>
                                        <th>Return Date</th>
                                        <th>Returned</th>
                                    </tr>

                                    </thead>
                                    <tbody>
                                    @foreach ($book->loans as $loan)
                                        <tr>
                                            <td>{{ $loan->id }}</td>
                                            <td>{{ $loan->patron->forename }} {{ $loan->patron->surname }}</td>
                                            <td>{{ \Carbon\Carbon::parse($loan->start_time)->format('jS M Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($loan->end_time)->format('jS M Y') }}</td>
                                            <td>{{ $loan->is_returned ? 'Yes' : 'No' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="text-gray-600">This book has not been loaned.</p>
                            @endif
                        </div>
                    </div>
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
            $('#showBookTitle').DataTable({
                responsive: true,
                searching: false,
                ordering: false, // Disable sorting
                paging: false, // Remove pagination
                lengthChange: false, // Remove "Show entries" dropdown
                language: {
                    info: '', // Remove information about displaying entries
                }
            });
        });

        $(document).ready(function () {
            $('#showBook').DataTable({
                responsive: true,
                searching: false,
                ordering: false, // Disable sorting
                paging: false, // Remove pagination
                lengthChange: false, // Remove "Show entries" dropdown
                language: {
                    info: '', // Remove information about displaying entries
                },
                columnDefs: [{
                    targets: [2],
                    orderable: false,
                    searchable: false,
                }],
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#showBookLoans').DataTable({
                responsive: true,
                dom: '<"top"fli>rt<"bottom"pB>',
                language: {
                    lengthMenu: 'Show _MENU_',
                    info: 'Displaying _START_-_END_ out of _TOTAL_',
                    search: 'Search Loans:',
                },
                buttons: [{
                    extend: 'csv',
                    text: 'Export Loan List',
                    exportOptions: {columns: [0, 1, 2, 3]},
                    title: 'Loans'
                }],
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10', '25', '50', 'All']
                ],
                columnDefs: [{
                    targets: [2, 3],
                    orderable: false
                },
                    {
                        targets: [4],
                        searchable: false,
                    }
                ],
                order: [[0, 'desc']]
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

    <script>
        $(document).ready(function () {
            $('#toggleDescriptionBtn').click(function () {
                $('#shortDescription').toggle();
                $('#fullDescription').toggle();
                if ($(this).text() === 'See Full Description') {
                    $(this).text('Hide Full Description');
                } else {
                    $(this).text('See Full Description');
                }
            });
        });
    </script>


</x-app-layout>
