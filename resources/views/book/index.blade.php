<x-app-layout>

    <!-- Header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Books') }}
        </h2>
    </x-slot>

    <!-- Book.index -->
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

                    <!-- Add, archived, and deleted buttons -->
                    <div class="top-buttons d-flex justify-content-between">
                        <a href="{{ route('book.create') }}" class="btn btn-primary">Add Book</a>
                        <div>
                            <a href="{{ route('book.archived') }}" class="btn btn-primary">Archived Books</a>
                            <a href="{{ route('book.deleted') }}" class="btn btn-primary">Deleted Books</a>
                        </div>
                    </div>

                    <!-- Book table -->
                    <table id="bookIndex" class="data-table table">

                        <!-- Table headings -->
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>PB/HC</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Publisher</th>
                            <th>Cond.</th>
                            <th>Status</th>
                            <th>Loans</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>

                        <!-- Table body -->
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

                                <!-- Book Authors -->
                                <td>
                                    @foreach($book->catalogueEntry->authors as $author)
                                        {{ $author->forename }} {{ $author->surname }}
                                        @if (!$loop->last)
                                            &amp;
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ $book->publisher->name }}<br>
                                    ({{ \Carbon\Carbon::parse($book->publish_date)->format('jS M Y') }})
                                </td>
                                <td>{{ $book->condition->name }}</td>

                                <!-- Book Status -->
                                <td>
                                    @if ($book->isOnLoan())
                                        On Loan
                                    @else
                                        Available
                                    @endif
                                </td>
                                <td>{{ $book->popularity() }}</td>
                                <!-- Book Action Buttons -->
                                <td style="padding-right:4px; padding-left: 4px;">
                                    <a class="btn btn-primary btn-width-80" href="book/{{ $book->id }}">Details</a>
                                </td>
                                <td style="padding-right:4px; padding-left: 4px;">
                                    <a href="book/{{$book->id}}/edit" class="btn btn-primary btn-width-80">Edit</a>
                                </td>
                                <td style="padding-right:4px; padding-left: 4px;">
                                    <button type="button" class="btn btn-primary archiveCategoryBtn btn-width-80"
                                            value="{{$book->id}}" data-bs-toggle="modal" data-bs-target="#archiveModal">
                                        Archive
                                    </button>
                                </td>
                                <td style="padding-right:4px; padding-left: 4px;">
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

    <!-- Modal for archive and delete confirmation -->
    @include('partials.archive-modal', ['modalId' => 'archiveModal', 'formAction' => url('book/archive'), 'textareaId' => 'archiveQuestion', 'categoryId' => 'category_id', 'confirmArchiveBtn' => 'confirmArchiveBtn'])
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

    <!-- My scripts -->
    <script src="{{ asset('js/book.js') }}"></script>

    <!-- Confirm delete-->
    <script>
        $('.deleteCategoryBtn').click(function (e) {
            e.preventDefault();

            var book_id = $(this).val();
            var url = "book/delete/" + book_id;
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

    <!-- Confirm archive-->
    <script>
        $('.archiveCategoryBtn').click(function (e) {
            e.preventDefault();

            var book_id = $(this).val();
            var url = "book/archive/" + book_id;

            $.ajax({
                url: '{{ route('book.check-archive', ':id') }}'.replace(':id', book_id),
                type: 'GET',
                success: function (response) {
                    // Set the modal content
                    console.log(response.message);
                    $('#archiveQuestion').val(response.message);
                    $('#archive_genre_id').val(book_id);

                    // Set the href attribute of the confirm button
                    $('#confirmArchiveBtn').attr('href', url);

                    // Show the modal
                    $('#archiveModal').modal('show');
                },
                error: function (error) {
                    alert('Error checking archive status');
                }
            });
        });
    </script>


</x-app-layout>
