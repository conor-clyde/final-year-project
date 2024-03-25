<x-app-layout>
    <!-- Header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Author Details') }}
        </h2>
    </x-slot>

    <!-- Author.show -->
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

                <!-- Author Details -->
                <h1>{{ $author->surname}}, {{ $author->forename }}</h1>
                <p style="margin-bottom: 8px;">Added: {{ $author->created_at->format('F d, Y') }}</p>
                <p style="margin-bottom: 8px;">Updated: {{ $author->updated_at->format('F d, Y') }}</p>
                <div style="padding-top: 4px;" class="border-b-2 border-gray-300 mb-2"></div>
                <div class="mb-8">
                    <div style="margin: 20px 4px;" class="row">
                        <!-- Book Titles -->
                        <h2 class="text-xl font-semibold mb-4">Books Written by {{ $author->surname}}
                            , {{ $author->forename }}</h2>
                        @if ($author->catalogueEntries->count() > 0)
                            <table id="genreShow" class="data-table table">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Publisher</th>
                                    <th>Published</th>
                                    <th>Condition</th>
                                    <th>Status</th>
                                    <th>Loans</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach ($author->catalogueEntries as $catalogueEntry)
                                    @foreach ($catalogueEntry->bookCopies as $book)
                                        <tr>
                                            <td>{{ $book->id }}</td>

                                            <td>{{ $book->catalogueEntry->title }}</td>
                                            <td>{{ $book->publisher->name }}</td>
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
                                            <td>
                                                <a class="btn btn-primary btn-width-80" href="{{ route('book.show', ['book' => $book->id]) }}">Details</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-gray-600">No books are written by this author</p>
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
                dom: '<"top"fli>rt<"bottom"pB>',
                language: {
                    lengthMenu: 'Show _MENU_',
                    info: 'Displaying _START_-_END_ out of _TOTAL_',
                    search: 'Search Books:',
                },
                buttons: [{
                    extend: 'csv',
                    text: 'Export Book List',
                    title: 'Books'
                }],
                responsive: true,
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10', '25', '50', 'All']
                ],
                columnDefs: []
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
