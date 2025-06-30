@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Publishers') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div >
                <div >

                    <!-- Flash Message -->
                    @if(Session::has('flashMessage'))
                        <div class="alert alert-success">
                            {{ Session::get('flashMessage') }}
                        </div>
                    @endif


                    <!-- Add, archived, and deleted buttons -->
                    <div class="top-buttons d-flex justify-content-between">
                        <a href="{{ route('publisher.create') }}" class="btn btn-primary">Add Publisher</a>
                        <div>
                            <a href="{{ route('publisher.archived') }}" class="btn btn-primary">Archived Publishers</a>
                            <a href="{{ route('publisher.deleted') }}" class="btn btn-primary">Deleted Publishers</a>
                        </div>
                    </div>

                    <!-- Publisher table -->
                    <table id="publisherIndex" class="data-table table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Publisher</th>
                            <th>Books</th>
                            <th class="text-end">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($publishers as $publisher)
                            <tr>
                                <td>{{ $publisher->id }}</td>
                                <td>{{ $publisher->name }}</td>
                                <td>{{ $publisher->popularity() }}</td>
                                <td class="text-end">
                                    @include('partials.publisher-actions', ['publisher' => $publisher])
                                </td>
                            </tr>
                        @empty
                            @include('partials.empty-state', [
                                'icon' => 'bi-emoji-frown',
                                'title' => __('No publishers found'),
                                'message' => __('Get started by adding your first publisher.'),
                                'actionRoute' => route('publisher.create'),
                                'actionLabel' => __('Add Publisher')
                            ])
                        @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal for archive and delete -->
    @include('partials.archive-modal', ['modalId' => 'archiveModal', 'formAction' => url('publisher/archive'), 'textareaId' => 'archiveQuestion', 'categoryId' => 'category_id', 'confirmArchiveBtn' => 'confirmArchiveBtn'])
    @include('partials.delete-modal', ['modalId' => 'deleteModal', 'formAction' => url('publisher/delete'), 'textareaId' => 'deleteQuestion', 'archive_genre_id' => 'archive_genre_id', 'confirmDeletionBtn' => 'confirmDeletionBtn'])


    <!-- Imported scripts -->
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>

    <!-- My scripts -->
    <script src="{{ asset('js/publisher.js') }}"></script>

    <!-- Confirm delete-->
    <script>
        $('.deleteCategoryBtn').click(function (e) {
            e.preventDefault();

            var category_id = $(this).val();

            $.ajax({
                url: '{{ route('publisher.check-delete', ':id') }}'.replace(':id', category_id),
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
            var test ="publisher/archive/" + category_id;

            $.ajax({
                url: '{{ route('publisher.check-archive', ':id') }}'.replace(':id', category_id),
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
@endsection
