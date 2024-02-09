<x-app-layout>
    <!-- Header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Genre Details') }}
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


                <!-- Genre Details -->
                <h1>{{ $book->catalogueEntry->title }}</h1>

                <div class="border-b-2 border-gray-300 mb-2"></div>


                <div class="mb-8">
                    <div class="row">
                        <div class="col-md-4">
                            <h2 class="text-xl font-semibold mb-4">Details</h2>
                            <p class="text-gray-600">Created: {{ $book->created_at->format('F d, Y') }}</p>
                            <p class="text-gray-600">Last Updated: {{ $book->updated_at->format('F d, Y') }}</p>
                            <p>Description: </p>
                        </div>
                        <div class="col-md-8">
                            <!-- Book Titles -->
                            <h2 class="text-xl font-semibold mb-4">Loans Classified under {{ $book->catalogueEntry->title }}</h2>
                            @if ($book->loans->count() > 0)
                                <table id="genreShow" class="data-table table">
                                    <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th></th>
                                    </tr>

                                    </thead>
                                    <tbody>
                                    @foreach ($genre->catalogueEntries as $catalogueEntry)
                                        <tr>
                                            <td>{{ $catalogueEntry->title }}</td>
                                            <td>
                                                @foreach ($catalogueEntry->authors as $author)
                                                    {{ $author->surname }}, {{ $author->forename }}
                                                    <br>
                                                @endforeach
                                            <td>
                                                <a class="btn btn-primary btn-width-80" href="">Details</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="text-gray-600">No books are classified by this genre.</p>
                            @endif
                        </div>
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
                    text: 'Export Genre List',
                    title: 'Genres'
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
