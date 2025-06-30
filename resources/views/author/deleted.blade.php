<x-app-layout>

    <x-slot name="header">
        <h2 >
            {{ __('Deleted Authors') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div >
                <div >

                    @if(Session::has('flashMessage'))
                        <div class="alert alert-success">
                            {{ Session::get('flashMessage') }}
                        </div>
                    @endif

                    <!-- Return and Restore all buttons -->
                    <div class="top-buttons d-flex justify-content-between">
                        <a href="{{ route('author') }}" class="btn btn-secondary">Go Back</a>
                        <div>
                            <a href="{{ route('author.restore-all') }}" class="btn btn-primary">Restore All</a>
                        </div>
                    </div>

                    <table id="authorDeleted" class="data-table table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Forename</th>
                            <th>Surname</th>
                            <th>Books</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>


                        @foreach ($authors as $author)
                            <tr>
                                <td>{{ $author->id }}</td>
                                <td>{{ $author->forename }}</td>
                                <td>{{ $author->surname }}</td>
                                <td>{{ $author->popularity() }}</td>
                                <td>
                                    <a href="{{$author->id}}" class="btn btn-primary">Details</a>
                                </td>
                                <td>
                                    <a href="restore/{{$author->id}}" class="btn btn-primary">Restore</a>
                                </td>
                                <td>
                                    <form action="{{ route('author.permanent-delete', $author->id) }}" method="POST" class="pull-right">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirmPermanentDelete(event, {{ $author->id }})">
                                            Delete
                                        </button>
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

    <!-- Modal -->
    <!-- Permanent Delete Modal -->
    <div class="modal fade" id="permanentDeleteModal" tabindex="-1" aria-labelledby="permanentDeleteModalLabel"
         aria-hidden="true">
        <!-- Modal content goes here -->

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>


    <script>
        $(document).ready(function () {
            $('#authorDeleted').DataTable({
                dom: '<"top"fli>rt<"bottom"pB>',
                language: {
                    lengthMenu: 'Show _MENU_',
                    info: 'Displaying _START_-_END_ out of _TOTAL_',
                    search: 'Search Authors:',
                },
                buttons: [{
                    extend: 'csv',
                    text: 'Export Author List',
                    exportOptions: {columns: [0, 1, 2]},
                    title: 'Authors'
                }],
                responsive: true,
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10', '25', '50', 'All']
                ],
                columnDefs: [{
                    targets: [4, 5, 6],
                    orderable: false,
                    searchable: false,
                },
                    {
                        targets: [3],
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






