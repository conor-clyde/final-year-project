<x-app-layout>

    {{-- Header --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Book') }}
        </h2>
    </x-slot>

    {{-- Book.Edit --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 genres">

                    {{-- Error Message --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Flash message -->
                    @if(Session::has('flashMessage'))
                        <div class="alert alert-success">
                            {{ Session::get('flashMessage') }}
                        </div>
                    @endif

                    <!-- Go back button -->
                    <a href="{{ route('book') }}" class="btn btn-secondary" style="margin-bottom: 40px;">Go Back</a>

                    <!-- Update Book Title Details-->
                    <h2>Book Title Details</h2>
                    @if (isset($book))
                            <?php
                            $books = \App\Models\BookCopy::where('catalogue_entry_id', $book->catalogue_entry_id)->get();
                            ?>
                        <p style="margin-bottom: 10px;">The library has {{ count($books) }} book(s) under this title.
                            ID(s):
                            @foreach ($books as $book)
                                {{ $book->id }}
                                @if (!$loop->last)
                                    <!-- Check if it's not the last book -->
                                    , <!-- Add comma if it's not the last book -->
                                @endif
                            @endforeach
                        </p>
                    @else
                        <p>No book found.</p>
                    @endif

                    <form method="post" action="{{ route('book.title-update', $book->catalogue_entry_id) }}">
                        @csrf
                        @method('PUT')
                        <table id="updateBookTitle" class="data-table table">

                            <!-- Table Headers -->
                            <thead>
                            <tr>
                                <th style="width: 20px">Detail</th>
                                <th>Current Value</th>
                                <th>New Value</th>
                            </tr>
                            </thead>

                            <!-- Table Body -->
                            <tbody>

                            {{-- Book Title --}}
                            <tr>
                                <td>Title</td>
                                <td>{{ $book->catalogueEntry->title }}</td>
                                <td><input type="text" name="title" id="title" class="form-control"
                                           value="{{ $book->catalogueEntry->title }}">
                                </td>
                            </tr>

                            {{-- Book Author --}}
                            <tr>
                                <td>Author</td>
                                <td>
                                    @foreach ($book->catalogueEntry->authors as $key => $author)
                                        <label>ID: {{ $author->id }}</label><br>
                                        Forename: {{ $author->forename }}<br>
                                        Surname: {{ $author->surname }}
                                        @if (!$loop->last)
                                            <br>      <br>
                                        @endif
                                    @endforeach
                                </td>

                                {{-- Update Author Surname and Forename --}}
                                <td>
                                    <input type="hidden" name="removed_author_ids" id="removed_author_ids" value="">

                                    @foreach ($book->catalogueEntry->authors as $author)
                                        <div style="display: inline-block; margin-right: 10px; width: 250px;">
                                            <select name="author_ids[{{ $author->id }}]"
                                                    id="author_select_{{ $author->id }}" class="form-control"
                                                    style="margin-bottom: 10px;">
                                                @foreach ($authors as $availableAuthor)
                                                    <option
                                                        value="{{ $availableAuthor->id }}" {{ $author->id == $availableAuthor->id ? 'selected' : '' }}>
                                                        {{ $availableAuthor->id }}
                                                        : {{ $availableAuthor->forename }} {{ $availableAuthor->surname }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if (count($book->catalogueEntry->authors) > 1)
                                                <button style="margin-bottom: 20px;" type="button"
                                                        id="remove-author-button-{{ $author->id }}"
                                                        class="btn btn-danger"
                                                        onclick="removeAuthor({{ $author->id }})">X
                                                </button>
                                            @endif


                                        </div>
                                    @endforeach
                                    <div id="author-dropdown-container">
                                        <!-- Existing author dropdowns will be added here -->
                                    </div>


                                    <button type="button" onclick="addNewAuthor()" class="btn btn-primary">Add Author
                                    </button>


                            </tr>

                            {{-- Book Genre --}}
                            <tr>
                                <td>Genre</td>
                                <td>{{ $book->catalogueEntry->genre->name}}</td>
                                <td><select name="genre" id="genre" class="form-control">
                                        @foreach ($genres as $genre)
                                            <option
                                                value="{{ $genre->id }}" {{ $book->catalogueEntry->genre_id == $genre->id ? 'selected' : '' }}>
                                                {{ $genre->name }}
                                            </option>
                                        @endforeach
                                    </select></td>
                            </tr>

                            {{-- Book Description --}}
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
                                    @if (strlen($book->catalogueEntry->description) > 200)
                                        <button id="toggleDescriptionBtn" class="btn btn-link" type="button">See Full
                                            Description
                                        </button>
                                    @endif
                                </td>
                                <td>
                                    <textarea style="resize: vertical; min-height: 100px; max-height: 800px;"
                                              class="form-control" id="description" name="description"
                                              rows="5">{{ $book->catalogueEntry->description }} </textarea>
                                </td>
                            </tr>

                            </tbody>
                        </table>

                        {{-- Submit Book Title Details Button --}}
                        <div class="text-right">
                            <button type="submit" class="btn-primary btn">Confirm Book Title Details</button>
                        </div>
                    </form>

                    <h2>Book Copy Details</h2>
                    <form method="post" action="{{ route('book.update', $book->id) }}">
                        @csrf
                        @method('PUT')
                        <table id="updateBook" class="data-table table">
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
                                <td>{{ date('jS M Y', strtotime($book->publish_date)) }}</td>

                                <td>
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            {!! Form::selectRange('publish_day', 1, 31, date('j', strtotime($book->publish_date)), ['class' => 'form-control']) !!}
                                        </div>

                                        {{-- Month Input --}}
                                        <div class="col-md-4">
                                            {!! Form::selectMonth('publish_month', intval(date('m', strtotime($book->publish_date))), ['class' => 'form-control']) !!}
                                        </div>

                                        {{-- Year Input --}}
                                        <div class="col-md-4">
                                            {!! Form::selectRange('publish_year', date('Y'), date('Y') - 100, date('Y', strtotime($book->publish_date)), ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Pages</td>
                                <td>{{ $book->pages }}</td>
                                <td>
                                    <input min="0" max="2000" class="form-control" type="number" name="pages"
                                           value="{{ $book->pages }}">
                                </td>
                            </tr>

                            </tbody>
                        </table>

                        {{-- Submit Book Details Button --}}
                        <div class="text-right">
                            <button type="submit" class="btn-primary btn">Confirm Book Copy Details</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

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
            $('#updateBookTitle').DataTable({
                responsive: true,
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
            $('#updateBook').DataTable({
                responsive: true,
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
    </script>

    <script>
        function removeAuthor(authorId) {
            var activeAuthorsCount = document.querySelectorAll('select[name^="author_ids"]:enabled').length;

            if (activeAuthorsCount <= 1) {
                alert('At least one author must be active for the book.');
                return;
            }

            console.log(activeAuthorsCount);
            // Append the author's ID to the hidden input field value
            var removedAuthorsInput = document.getElementById('removed_author_ids');
            removedAuthorsInput.value += authorId + ',';

            var authorSelect = document.getElementById('author_select_' + authorId);
            authorSelect.disabled = true;


            var authorSelectContainer = authorSelect.parentNode;
            authorSelectContainer.parentNode.removeChild(authorSelectContainer);



            var removeButton = document.getElementById('remove-author-button-' + authorId);


            removeButton.onclick = function () {
                // Remove the author ID from the hidden input field
                var removedAuthorsInputValue = removedAuthorsInput.value;
                var idToRemoveIndex = removedAuthorsInputValue.indexOf(authorId.toString());
                if (idToRemoveIndex !== -1) {
                    removedAuthorsInputValue = removedAuthorsInputValue.substring(0, idToRemoveIndex) +
                        removedAuthorsInputValue.substring(idToRemoveIndex + authorId.toString().length + 1);
                    removedAuthorsInput.value = removedAuthorsInputValue;
                }

                // Enable the author selection dropdown
                authorSelect.disabled = false;

                // Change the button text back to 'X' and reset onclick functionality
                removeButton.textContent = 'X';
                removeButton.onclick = function () {
                    removeAuthor(authorId);
                };
            };


        }
    </script>

    <script>

        function addNewAuthor() {
            // Check if the maximum number of authors has already been reached
            var authorCount = document.querySelectorAll('select[name^="author_ids[]"]').length;
            var authorsCount = document.querySelectorAll('select[name^="author_ids"]:enabled').length;

            console.log(authorsCount);



            if (authorsCount >= 3) {
                alert('You can only add up to three authors to a book.');
                return;
            }

            // Create a new <select> element for the author
            var authorSelect = document.createElement('select');
            authorSelect.name = 'author_ids[]';
            authorSelect.className = 'form-control';

            // Add options for authors (you may need to adjust this based on your implementation)
            @foreach ($authors as $availableAuthor)
            var option = document.createElement('option');
            option.value = '{{ $availableAuthor->id }}';
            option.textContent = '{{ $availableAuthor->id }}: {{ $availableAuthor->forename }} {{ $availableAuthor->surname }}';
            authorSelect.appendChild(option);
            @endforeach

            // Append the new <select> element to the form
            document.getElementById('author-dropdown-container').appendChild(authorSelect);
        }
    </script>

</x-app-layout>

