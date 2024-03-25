<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Book') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 genres">
                    @if(Session::has('flashMessage'))
                        <div class="alert alert-success">
                            {{ Session::get('flashMessage') }}
                        </div>
                    @endif

                    <!-- Add, archived, and deleted buttons -->
                    <a href="{{ route('book') }}" class="btn btn-secondary" style="margin-bottom: 40px;">Go Back</a>

                    <h2>Book Title Details</h2>
                    <form method="post" action="{{ route('book.title-update', $book->id) }}">
                        @csrf
                        @method('PUT')
                        <table id="test" class="data-table table">
                            <thead>
                            <tr>
                                <th style="width: 20px">Detail</th>
                                <th>Current Value</th>
                                <th>New Value</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr>
                                <td>Title</td>
                                <td>{{ $book->catalogueEntry->title }}</td>
                                <td><input type="text" name="isbn" id="isbn" class="form-control"
                                           value="{{ $book->catalogueEntry->title }}"></td>
                            </tr>


                            <tr>
                                <td>Author</td>
                                <td>  @foreach ($book->catalogueEntry->authors as $author)
                                        {{ $author->surname }}, {{ $author->forename }}
                                        <br>
                                    @endforeach</td>
                                <td>
                                </td>
                            </tr>

                            <tr>
                                <td>Genre</td>
                                <td>{{ $book->catalogueEntry->genre->name}}</td>
                                <td>Update</td>
                            </tr>

                            <tr>
                                <td style="vertical-align: top; max-width: 200px; word-wrap: break-word;">Description
                                </td>
                                <td style="max-width: 200px; word-wrap: break-word;">
                                    <div id="shortDescription">
                                        {{ \Illuminate\Support\Str::limit($book->catalogueEntry->description, 200) }}
                                    </div>
                                    <div id="fullDescription" style="display: none;">
                                        {{ $book->catalogueEntry->description }}
                                    </div>
                                    <button id="toggleDescriptionBtn" class="btn btn-link">See Full Description</button>
                                </td>
                                <td></td>
                            </tr>


                            </tbody>
                        </table>
                        <button type="submit" class="btn-primary btn">Confirm Book Title Details</button>
                    </form>
                    <?php
                    $books = \App\Models\BookCopy::where('catalogue_entry_id', $book->catalogue_entry_id)->get();
                    ?>
                    @foreach ($books as $book)
                        <p>
                            {{$book->id}}

                        </p>
                    @endforeach


                    <h2>Book Copy Details</h2>
                    <form method="post" action="{{ route('book.update', $book->id) }}">
                        @csrf
                        @method('PUT')
                        <table id="test2" class="data-table table">
                            <thead>
                            <tr>
                                <th style="max-width: 20px;">Detail</th>
                                <th>Current Value</th>
                                <th>New Value</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>ID</td>
                                <td>{{ $book->id }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Format</td>
                                <td>{{ $book->format->name}}</td>
                                <td><select name="format" id="format" class="form-control">
                                        @foreach($formats as $format)
                                            <option
                                                    value="{{ $format->id }}" {{ $book->format_id == $format->id ? 'selected' : '' }}>
                                                {{ $format->name }}
                                            </option>
                                        @endforeach
                                    </select></td>
                            </tr>
                            <tr>
                                <td>Language</td>
                                <td>{{ $book->language->name}}</td>
                                <td><select name="language" id="language" class="form-control">
                                        @foreach($languages as $language)
                                            <option
                                                    value="{{ $language->id }}" {{ $book->language_id == $language->id ? 'selected' : '' }}>
                                                {{ $language->name }}
                                            </option>
                                        @endforeach
                                    </select></td>
                            </tr>


                            <tr>
                                <td>Condition</td>
                                <td>{{ $book->condition->name}}</td>
                                <td><select name="condition" id="condition" class="form-control">
                                        @foreach($conditions as $condition)
                                            <option
                                                    value="{{ $condition->id }}" {{ $book->condition_id == $condition->id ? 'selected' : '' }}>
                                                {{ $condition->name }}
                                            </option>
                                        @endforeach
                                    </select></td>
                            </tr>
                            <tr>
                                <td>Publisher</td>
                                <td>{{ $book->publisher->name}}</td>
                                <td><select name="publisher" id="publisher" class="form-control">
                                        <option value="" disabled selected>Select Publisher...</option>
                                        @foreach($publishers as $publisher)
                                            <option
                                                    value="{{ $publisher->id }}" {{ $book->publisher_id == $publisher->id ? 'selected' : '' }}>
                                                {{ $publisher->name }}
                                            </option>
                                        @endforeach
                                    </select></td>
                            </tr>
                            <tr>
                                <td>Publish Date</td>
                                <td>{{ $book->publish_date}}</td>
                                <td>
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            {!! Form::selectRange('publish_day', 1, 31, date('d', strtotime($book->publish_date)), ['class' => 'form-control']) !!}
                                        </div>

                                        {{-- Month Input --}}
                                        <div class="col-md-4">
                                            {!! Form::selectMonth('publish_month', intval(date('d', strtotime($book->publish_date))), ['class' => 'form-control']) !!}
                                        </div>

                                        {{-- Year Input --}}
                                        <div class="col-md-4">
                                            {!! Form::selectRange('publish_year', date('Y'), date('Y') - 100, date('Y', strtotime($book->publish_date)), ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>ISBN</td>
                                <td>
                                    {{ $book->ISBN }}
                                </td>
                                <td>
                                    <input type="text" name="isbn" id="isbn" class="form-control"
                                           placeholder="Enter ISBN..." value="{{ $book->ISBN  }}">
                                </td>
                            </tr>

                            <tr>
                                <td>Pages</td>
                                <td>{{ $book->pages }}</td>
                                <td>
                                    <input type="number" name="pages" value="{{ $book->pages }}">
                                </td>
                            </tr>

                            </tbody>
                        </table>

                        <div class="top-buttons d-flex justify-content-between">
                            <div>

                                <button type="submit" class="btn-primary btn">Confirm Book Copy Details</button>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
    <link rel="stylesheet" type="text/css" href="{{ asset('styles.css') }}">

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


    <script>
        // Create genre.index datatable
        $(document).ready(function () {
            $('#test').DataTable({
                searching: false,
                ordering: false, // Disable sorting
                paging: false, // Remove pagination
                lengthChange: false, // Remove "Show entries" dropdown
                language: {
                    info: '', // Remove information about displaying entries
                },
                columnDefs: [{
                    targets: [2],
                    orderable: false,
                    searchable: false,
                }],
            });
        });

        $(document).ready(function () {
            $('#test2').DataTable({
                searching: false,
                ordering: false, // Disable sorting
                paging: false, // Remove pagination
                lengthChange: false, // Remove "Show entries" dropdown
                language: {
                    info: '', // Remove information about displaying entries
                },
                columnDefs: [{
                    targets: [2],
                    orderable: false,
                    searchable: false,
                }],
            });
        });

    </script>

    <script>
        $(document).ready(function () {
            $('#toggleDescriptionBtn').click(function () {
                $('#shortDescription').toggle();
                $('#fullDescription').toggle();
                if ($(this).text() === 'See Full Description') {
                    $(this).text('Hide Full Description');
                } else {
                    $(this).text('See Full Description');
                }
            });
        });

        // Save button click event handler
        $(document).on('click', '#saveDescriptionBtn', function () {
            // Get the updated description value
            var updatedDescription = $('#descriptionInput').val();

            // Update the content of the cell with the updated value
            $('#shortDescription').text(updatedDescription);

            // Restore the original button text and ID
            $('#saveDescriptionBtn').text('Update').attr('id', 'updateDescriptionBtn');
        });
        })
        ;
    </script>
</x-app-layout>

