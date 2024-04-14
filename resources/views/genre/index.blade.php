<x-app-layout>

    <!-- Header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Genres') }}
        </h2>
    </x-slot>

    <!-- Genre.index -->
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
                        <a href="{{ route('genre.create') }}" class="btn btn-primary">Add Genre</a>
                        <div>
                            <a href="{{ route('genre.archived') }}" class="btn btn-primary">Archived Genres</a>
                            <a href="{{ route('genre.deleted') }}" class="btn btn-primary">Deleted Genres</a>
                        </div>
                    </div>

                    <!-- Genre table -->
                        <table id="genreIndex" class="data-table table">

                            <!-- Table headings -->
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Genre</th>
                                <th>Books</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>

                            <!-- Table body -->
                            <tbody>
                            @foreach ($genres as $genre)
                                <tr>
                                    <td>{{ $genre->id }}</td>
                                    <td>{{ $genre->name }}</td>
                                    <td>{{ $genre->popularity() }}</td>
                                    <td style="padding-right:4px; padding-left: 4px;">
                                        <a class="btn btn-primary btn-width-80" href="genre/{{ $genre->id }}">Details</a>
                                    </td>
                                    <td style="padding-right:4px; padding-left: 4px;">
                                        <a href="genre/{{ $genre->id }}/edit" class="btn btn-primary btn-width-80">Edit</a>
                                    </td>
                                    <td style="padding-right:4px; padding-left: 4px;">
                                        <button type="button" class="btn btn-primary archiveCategoryBtn btn-width-80" value="{{$genre->id}}" data-bs-toggle="modal" data-bs-target="#archiveModal">Archive</button>
                                    </td>
                                    <td style="padding-right:4px; padding-left: 4px;">
                                        <button type="button" class="btn btn-danger deleteCategoryBtn btn-width-80" value="{{$genre->id}}" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
{{--                    </form>--}}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for archive and delete -->
    @include('partials.archive-modal', ['modalId' => 'archiveModal', 'formAction' => url('genre/archive'), 'textareaId' => 'archiveQuestion', 'categoryId' => 'category_id', 'confirmArchiveBtn' => 'confirmArchiveBtn'])
    @include('partials.delete-modal', ['modalId' => 'deleteModal', 'formAction' => url('genre/delete'), 'textareaId' => 'deleteQuestion', 'archive_genre_id' => 'archive_genre_id', 'confirmDeletionBtn' => 'confirmDeletionBtn'])

    <!-- Imported scripts -->
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>

    <!-- My scripts -->
    <script src="{{ asset('js/genre.js') }}"></script>

    <!-- Confirm delete-->
    <script>
        $('.deleteCategoryBtn').click(function (e) {
            e.preventDefault();

            var category_id = $(this).val();

            $.ajax({
                url: '{{ route('genre.check-deletion', ':id') }}'.replace(':id', category_id),
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
            var test ="genre/archive/" + category_id;

            $.ajax({
                url: '{{ route('genre.check-archive', ':id') }}'.replace(':id', category_id),
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
