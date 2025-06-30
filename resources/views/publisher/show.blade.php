<x-app-layout>
    <!-- Header -->
    <x-slot name="header">
        <h2 >
            {{ __('Publisher Details') }}
        </h2>
    </x-slot>

    <!-- Publisher.show -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div >

                <!-- Flash message -->
                @if(session('flashMessage'))
                    <div class="alert alert-success mb-4">
                        {{ session('flashMessage') }}
                    </div>
                @endif

                <!-- Go Back button -->
                <a href="{{ url()->previous() }}" class="btn btn-secondary mb-4">Go Back</a>

                <!-- Publisher Details -->
                <h2>{{ $publisher->id}}: {{ $publisher->name }}</h2>
                <p>Added:  {{ $publisher->created_at->format('jS M Y, H:i:s') }}</p>
                <p>Last Updated: {{ $publisher->updated_at->format('jS M Y, H:i:s') }}</p>
                <div ></div>

                <div class="mb-8">
                    <div class="row">
                        <!-- Book Titles -->
                        <h2 class="text-xl font-semibold mb-4">Books Published by {{ $publisher->name }}</h2>
                        @if ($publisher->bookCopies->count() > 0)
                            <table id="genreShow" class="data-table table">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>PB/HC</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Published</th>
                                    <th>Condition</th>
                                    <th>Status</th>
                                    <th>Loans</th>
                                </tr>

                                </thead>
                                <tbody>
                                @foreach ($publisher->bookCopies as $book)
                                    <tr>
                                        <td>{{ $book->id }}</td>
                                        <td>{{ $book->id }}</td>
                                        <td>{{ $book->catalogueEntry->title }}</td>
                                        <td>
                                            @foreach ($book->catalogueEntry->authors as $author)
                                                {{ $author->surname }}, {{ $author->forename }}
                                                <br>
                                        @endforeach
                                        <td>{{ \Carbon\Carbon::parse($book->publish_date)->format('jS M Y') }}</td>
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
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <p >No books are published by this publisher.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- External Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

    <!-- Data Table Initialization -->
    <script>
        $(document).ready(function () {
            $('#genreShow').DataTable({
                responsive:true,
                dom: '<"top"fli>rt<"bottom"pB>',
                language: {
                    lengthMenu: 'Show _MENU_',
                    info: 'Displaying _START_-_END_ out of _TOTAL_',
                    search: 'Search Books:',
                },
                buttons: [{
                    extend: 'csv',
                    text: 'Export Genre List',
                    title: 'Genres'
                }],
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10', '25', '50', 'All']
                ],
                columnDefs: [
                    {
                        targets: [1, 5, 6, 7],
                        searchable: false,
                    }],

                order: [[2, 'asc']]
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
