<x-app-layout>
    <!-- Header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Authors') }}
        </h2>
    </x-slot>

    <!-- Author.index -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 genres">

                    <!-- Flash Message -->
                    @if(Session::has('flashMessage'))
                        <div class="alert alert-success">
                            {{ Session::get('flashMessage') }}
                        </div>
                    @endif

                    <!-- Add, archived, and deleted buttons -->
                    <div class="top-buttons d-flex justify-content-between">
                        <a href="{{ route('author.create') }}" class="btn btn-primary">Add Author</a>
                        <div>
                            <a href="{{ route('author.archived') }}" class="btn btn-primary">Archived Authors</a>
                            <a href="{{ route('author.deleted') }}" class="btn btn-primary">Deleted Authors</a>
                        </div>
                    </div>

                    <!-- Author Table -->
                    <table id="authorIndex" class="data-table table">

                        <!--  Table Headings -->
                        <thead>
                        <tr>
                            <th>Surname</th>
                            <th>Forename</th>
                            <th>Books</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>

                        <!--  Table Body -->
                        <tbody>
                        @foreach ($authors as $author)
                            <tr>
                                <td>{{ $author->surname }}</td>
                                <td>{{ $author->forename }}</td>
                                <td>{{ $author->popularity() }}</td>
                                <td>
                                    <a class="btn btn-primary btn-width-80" href="author/{{ $author->id }}">Details</a>
                                </td>
                                <td>
                                    <a href="author/{{$author->id}}/edit" class="btn btn-primary btn-width-80">Edit</a>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary archiveCategoryBtn btn-width-80" value="{{ $author->id }}" data-bs-toggle="modal" data-bs-target="#archiveModal">Archive</button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger deleteCategoryBtn btn-width-80" value="{{$author->id}}" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for archive and delete -->
    @include('partials.archive-modal', ['modalId' => 'archiveModal', 'formAction' => url('author/archive'), 'textareaId' => 'archiveQuestion', 'categoryId' => 'category_id', 'confirmArchiveBtn' => 'confirmArchiveBtn'])
        @include('partials.delete-modal', ['modalId' => 'deleteModal', 'formAction' => url('author/delete'), 'textareaId' => 'deleteQuestion', 'archive_genre_id' => 'archive_genre_id', 'confirmDeletionBtn' => 'confirmDeletionBtn'])

    <!-- Imported scripts -->
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>

    <!-- My scripts -->
    <script src="{{ asset('js/author.js') }}"></script>

    <!-- Confirm delete-->
    <script>
        $('.deleteCategoryBtn').click(function (e) {
            e.preventDefault();

            var category_id = $(this).val();

            $.ajax({
                url: '{{ route('author.check-deletion', ':id') }}'.replace(':id', category_id),
                type: 'GET',
                success: function (response) {
                    console.log(response.message);
                    $('#deleteQuestion').val(response.message);
                    $('#category_id').val(category_id);

                    var deletable = response.deletable;

                    if (deletable) {
                        $('#confirmDeletionBtn').show();
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

            var category_id = $(this).val();
            var test ="author/archive/" + category_id;

            $.ajax({
                url: '{{ route('author.check-archive', ':id') }}'.replace(':id', category_id),
                type: 'GET',
                success: function (response) {
                    // Set the modal content
                    console.log(response.message);
                    $('#archiveQuestion').val(response.message);
                    $('#archive_genre_id').val(category_id);

                    // Set the href attribute of the confirm button
                    $('#confirmArchiveBtn').attr('href', test);

                    // Show the modal
                    $('#archiveModal').modal('show');
                },
                error: function (error) {
                    alert('Error checking deletion status');
                }
            });
        });
    </script>

</x-app-layout>
