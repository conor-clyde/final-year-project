@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit Book') }}
    </h2>
@endsection

@section('content')
    {{-- Header --}}
    <x-slot name="header">
        <h2 >
            {{ __('Update Book') }}
        </h2>
    </x-slot>

    {{-- Book.Edit --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div >
                <div >

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
                    <a href="{{ route('book') }}" class="btn btn-secondary">Go Back</a>

                    <!-- Update Book Title Details-->
                    <h2>Book Title Details</h2>
                    @if (isset($book))
                            <?php
                            $books = \App\Models\BookCopy::where('catalogue_entry_id', $book->catalogue_entry_id)->get();
                            ?>
                        <p>The library has {{ count($books) }} book(s) under this title.
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
                                <th>Detail</th>
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
                                    <div id="author-form">
                                        @foreach ($book->catalogueEntry->authors as $author)
                                            <div class="author-container row align-items-center" id="test">
                                                <div class="col-md-8">
                                                    <select name="author_ids[{{ $author->id }}]"
                                                            id="author_select_{{ $author->id }}" class="form-control">
                                                        @foreach ($authors as $availableAuthor)
                                                            <option
                                                                value="{{ $availableAuthor->id }}" {{ $author->id == $availableAuthor->id ? 'selected' : '' }}>
                                                                {{ $availableAuthor->forename }} {{ $availableAuthor->surname }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                                <div class="col-md-4">
                                                    <button type="button"
                                                            id="remove-author-button-{{ $author->id }}"
                                                            class="btn btn-danger"
                                                            onclick="removeAuthor({{ $author->id }})">X
                                                    </button>

                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="text-right">
                                        <button type="button" onclick="addNewAuthor()" class="btn btn-primary">Add
                                            Author
                                        </button>
                                    </div>


                                </td>
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
                                <td>Description
                                </td>
                                <td>
                                    <div id="shortDescription">
                                        {{ \Illuminate\Support\Str::limit($book->catalogueEntry->description, 200) }}
                                    </div>
                                    <div id="fullDescription">
                                        {{ $book->catalogueEntry->description }}
                                    </div>
                                    @if (strlen($book->catalogueEntry->description) > 200)
                                        <button id="toggleDescriptionBtn" class="btn btn-link" type="button">See Full
                                            Description
                                        </button>
                                    @endif
                                </td>
                                <td>
                                    <textarea class="form-control" id="description" name="description"
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
                                <th>Detail</th>
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
                                            <select name="publish_day" class="form-control">
                                                @for($i = 1; $i <= 31; $i++)
                                                    <option value="{{ $i }}" {{ date('j', strtotime($book->publish_date)) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>

                                        {{-- Month Input --}}
                                        <div class="col-md-4">
                                            <select name="publish_month" class="form-control">
                                                @foreach([
                                                    1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                                                    5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                                                    9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
                                                ] as $value => $label)
                                                    <option value="{{ $value }}" {{ intval(date('m', strtotime($book->publish_date))) == $value ? 'selected' : '' }}>{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Year Input --}}
                                        <div class="col-md-4">
                                            <select name="publish_year" class="form-control">
                                                @for($i = date('Y'); $i >= date('Y') - 100; $i--)
                                                    <option value="{{ $i }}" {{ date('Y', strtotime($book->publish_date)) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                @endfor
                                            </select>
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


            var authorSelectContainer = authorSelect.parentNode.parentNode;
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
            var authorsCount = document.querySelectorAll('.author-container').length;

            if (authorsCount >= 3) {
                alert('You can only add up to three authors to a book.');
                return;
            }

            // Create a new author container
            var authorContainer = document.createElement('div');
            authorContainer.className = 'author-container row align-items-center';

            // Create a new <select> element for the author
            var selectDiv = document.createElement('div');
            selectDiv.className = 'col-md-8';
            var authorSelect = document.createElement('select');
            authorSelect.name = 'author_ids[]';
            authorSelect.className = 'form-control';

            // Add options for authors
            @foreach ($authors as $availableAuthor)
            var option = document.createElement('option');
            option.value = '{{ $availableAuthor->id }}';
            option.textContent = '{{ $availableAuthor->forename }} {{ $availableAuthor->surname }}';
            authorSelect.appendChild(option);
            @endforeach
            selectDiv.appendChild(authorSelect);

            // Create a div for the remove button
            var buttonDiv = document.createElement('div');
            buttonDiv.className = 'col-md-4';
            var removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'btn btn-danger';
            removeButton.textContent = 'X';
            removeButton.onclick = function () {
                authorContainer.parentNode.removeChild(authorContainer);
            };
            buttonDiv.appendChild(removeButton);

            // Append both elements to the author container
            authorContainer.appendChild(selectDiv);
            authorContainer.appendChild(buttonDiv);

            // Append the new author container to the form
            document.getElementById('author-form').appendChild(authorContainer);
        }
    </script>

@endsection

