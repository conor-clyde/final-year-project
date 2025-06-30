@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Deleted Books') }}
    </h2>
@endsection

@section('content')
    <style>

    </style>
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
                        <a href="{{ route('book') }}" class="btn btn-secondary">Go Back</a>
                        <div>
                            <a href="{{ route('book.restore-all') }}" class="btn btn-primary">Restore All</a>
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
                        @forelse ($books as $book)
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
                                        {{ $author->forename }} {{ $author->surname }}@if (!$loop->last) &amp; @endif
                                    @endforeach
                                </td>
                                <td>{{ $book->publisher->name }}<br>
                                    ({{ \Carbon\Carbon::parse($book->publish_date)->format('jS M Y') }})</td>
                                <td>{{ $book->condition->name }}</td>
                                <td>
                                    @if ($book->isOnLoan())
                                        {{ __('On Loan') }}
                                    @else
                                        {{ __('Available') }}
                                    @endif
                                </td>
                                <td>{{ $book->popularity() }}</td>
                                <td>
                                    <a class="btn btn-primary" href="{{ $book->id }}">{{ __('Details') }}</a>
                                </td>
                                <td>
                                    <a href="restore/{{$book->id}}" class="btn btn-primary">{{ __('Restore') }}</a>
                                </td>
                                <td>
                                    <form action="{{ route('book.permanent-delete', $book->id) }}" method="POST" class="pull-right">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirmPermanentDelete(event, {{ $book->id }})">
                                            {{ __('Perm. Delete') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            @include('partials.empty-state', [
                                'icon' => 'bi-emoji-frown',
                                'title' => __('No deleted books'),
                                'message' => __('No deleted books found. Deleted books will appear here and can be restored or permanently removed.'),
                                'actionRoute' => route('book'),
                                'actionLabel' => __('Back to Books')
                            ])
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

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
@endsection






