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

                <h1 class="">Title: {{ $book->catalogueEntry->title }}</h1>
                <p style="margin-bottom: 12px;">ID: {{ $book->id  }}</p>

                <p style="margin-bottom: 12px;">Archived: {{ $book->archived ? 'Yes'  : 'No' }}</p>
                <p style="margin-bottom: 12px;">Deleted: {{ $book->deleted_at ? 'Yes' : 'No' }}</p>

                <p style="margin-bottom: 8px;">Added: {{ $book->created_at->format('F d, Y') }}</p>
                <p style="margin-bottom: 8px;">Updated: {{ $book->updated_at->format('F d, Y') }}</p>
                <div class="border-b-2 border-gray-300 mb-2"></div>
                <!-- Book Details -->
                <h2 class="text-xl font-semibold mb-4">
                    Details</h2>

                <div class="mb-8">
                    <div class="row">
                        <div class="col-md-3">
                            <p style="margin-bottom: 12px;">Format: {{ $book->format->name }}</p>
                            <p style="margin-bottom: 12px;">Language: {{ $book->language->name }}</p>
                            <p style="margin-bottom: 12px;">Author:
                                @foreach ($book->catalogueEntry->authors as $author)
                                    {{ $author->surname }}, {{ $author->forename }}
                                    <br>
                                @endforeach
                            </p>
                            <p style="margin-bottom: 12px;">Genre: {{ $book->catalogueEntry->genre->name }}</p>

                            <p style="margin-bottom: 12px;">Publisher: {{ $book->publisher->name }}</p>
                            <p style="margin-bottom: 12px;">Publish
                                Date: {{ \Carbon\Carbon::parse($book->publish_date)->format('jS M Y') }}</p>
                        </div>
                        <div class="col-md-3">
                            <p style="margin-bottom: 12px;">Status: @if ($book->isOnLoan())
                                    On Loan
                                @else
                                    Available
                                @endif </p>
                            <p style="margin-bottom: 12px;">Condition: {{ $book->condition->name }}</p>
                            <p style="margin-bottom: 12px;">ISBN: {{ $book->isbn ? $book->isbn : 'N/A' }}</p>
                            <p style="margin-bottom: 12px;">Page Count: {{ $book->pages ? $book->pages : 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">

                            <p style="margin-bottom: 6px;">Description:</p>
                            <div
                                style="margin-bottom: 12px; max-height: 200px;word-wrap: break-word; overflow-y: auto;">
                                <p>{{ $book->catalogueEntry->description ? $book->catalogueEntry->description : 'N/A'  }}</p>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="border-b-2 border-gray-300 mb-2"></div>


                <div class="mb-8">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Book Titles -->
                            <h2 class="text-xl font-semibold mb-4">
                                Loans</h2>
                            @if ($book->loans->count() > 0)
                                <table id="genreShow" class="data-table table">
                                    <thead>
                                    <tr>
                                        <th>Patron</th>
                                        <th>Staff</th>
                                        <th>Start</th>
                                        <th>End</th>
                                        <th>Returned</th>
                                        <th></th>
                                    </tr>

                                    </thead>
                                    <tbody>
                                    @foreach ($book->loans as $loan)
                                        <tr>
                                            <td>{{ $loan->patron->surname }}, {{ $loan->patron->forename }},</td>
                                            <td>{{ $loan->staff->surname }}, {{ $loan->staff->forename }}</td>
                                            <td>{{ \Carbon\Carbon::parse($loan->start_time)->format('jS M Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($loan->end_time)->format('jS M Y') }}</td>
                                            <td>{{ $loan->is_returned ? 'Yes' : 'No' }}</td>
                                            <td>
                                                <a class="btn btn-primary btn-width-80" href="">Details</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="text-gray-600">This book has not been loaned</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    <!-- Data Table Initialization -->
    <script>
        $(document).ready(function () {
            $('#genreShow').DataTable({
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
                    title: 'Loans'
                }],
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10', '25', '50', 'All']
                ],
                columnDefs: [{
                    targets: [5],
                    orderable: false,
                    searchable: false,
                }],
            });

            // Styles
            var wrapper = $('.dataTables_wrapper');
            var filter = wrapper.find('.dataTables_filter');
            var searchInput = filter.find('input');
            var lengthMenu = wrapper.find('.dataTables_length');
            var paginationContainer = $('.dataTables_paginate');

            filter.css('float', 'left');
            lengthMenu.css('float', 'right');
            searchInput.css({
                'margin-left': '20px',
                'width': '340px'
            });
            paginationContainer.addClass('float-start');

            // Select all checkbox
            document.getElementById('select-all').addEventListener('change', function () {
                var isChecked = this.checked;
                var genreCheckboxes = document.querySelectorAll('input[name="selected_genres[]"]');

                genreCheckboxes.forEach(function (checkbox) {
                    checkbox.checked = isChecked;
                });
            });
        });
    </script>
</x-app-layout>
