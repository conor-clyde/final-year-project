<x-app-layout>
    <!-- Header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book Publishers') }}
        </h2>
    </x-slot>

    <!-- Publisher.index -->
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
                        <a href="{{ route('publisher.create') }}" class="btn btn-primary">Add Publisher</a>
                        <div>
                            <a href="{{ route('publisher.archived') }}" class="btn btn-primary">Archived Publishers</a>
                            <a href="{{ route('publisher.deleted') }}" class="btn btn-primary">Deleted Publishers</a>
                        </div>
                    </div>

                    <!-- Publisher table -->
                    <table id="publisherIndex" class="data-table table">

                        <!-- Table headings -->
                        <thead>
                        <tr>
                            <th>Publisher</th>
                            <th>Books</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>

                        <!-- Table body -->
                        <tbody>
                        @foreach ($publishers as $publisher)
                            <tr>
                                <td>{{ $publisher->name }}</td>
                                <td>{{ $publisher->popularity() }}</td>
                                <td>
                                    <a class="btn btn-primary btn-width-80" href="publisher/{{ $publisher->id }}">Details</a>
                                </td>
                                <td>
                                    <a href="publisher/{{$publisher->id}}/edit" class="btn btn-primary">Edit</a>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary archiveCategoryBtn btn-width-80" value="{{$publisher->id}}" data-bs-toggle="modal" data-bs-target="#archiveModal">Archive</button>
                                </td>
                                <td>
                                    {!! Form::open(['url' => ['publisher/delete', $publisher->id], 'method' => 'POST', 'class' => 'pull-right']) !!}

                                    {!! Form::hidden('_method', 'DELETE') !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger', 'style' => "background-color: #dc3545;"]) !!}

                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <!-- Imported scripts -->
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>

    <!-- My scripts -->
    <script src="{{ asset('js/publisher.js') }}"></script>

</x-app-layout>
