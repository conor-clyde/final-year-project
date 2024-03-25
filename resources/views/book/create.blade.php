<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <h2 class="font-semibold text-gray-800 leading-tight" style="margin: 16px;">
            {{ __('Add Book') }}
        </h2>
    </x-slot>

    {{-- Book.Create --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 genres">

                    {{-- Flash Message --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Return Button --}}
                    <a href="{{route ('book') }}" class="btn btn-secondary mb-4">Go Back</a>

                    {{-- Add Book Form --}}
                    <form method="post" action="{{route('book.store')}}">
                        @csrf

                        <div class="row align-items-center">
                            <div class="col-md-11">
                                <!-- Add, archived, and deleted buttons -->
                                <div class="top-buttons d-flex justify-content-between">

                                    <h3>Book Title <span class="text-danger">*</span></h3>
                                    <div>
                                        <h3><span class="text-danger">*</span> = required</h3>
                                    </div>
                                </div>

                                {{-- Book Title --}}
                                <div class="row align-items-center">
                                    <div class="col-md-5">
                                        {{-- Catalogue Entry Selection --}}
                                        <div class="form-group">
                                            <select name="title" id="title" class="form-control">
                                                <option value="" disabled selected>Select Title...</option>
                                                {{-- Existing Catalogue Entries --}}
                                                @foreach($catalogue_entries as $catalogue_entry)
                                                    <option
                                                        value="{{ $catalogue_entry->id }}" {{ old('title') == $catalogue_entry->id ? 'selected' : '' }}>
                                                        {{ $catalogue_entry->title }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-1 text-center" style="text-align: center;">
                                        <p class="or-divider">OR</p>
                                    </div>
                                    <div class="col-md-5">
                                        {{-- OR Add a New Catalogue Entry --}}
                                        <div class="form-group">
                                            <input type="text" name="new_title" id="new_title" class="form-control"
                                                   placeholder="Enter Title..." value="{{ old('new_title') }}">
                                        </div>
                                    </div>
                                </div>
                                {{-- If creating a new catalogue entry --}}
                                <div id="newCatalogueEntryFields"
                                     style="display: none; margin-top:20px; margin-bottom:20px; padding: 20px 30px;background-color: #E5DFD8; border-radius: 20px;">
                                    <h3 style=" text-align: center;">New Book Title Details</h3>
                                    <hr>

                                    {{-- Author --}}
                                    <div class="form-group">
                                        <h3>Author <span class="text-danger">*</span></h3>
                                        <div class="row align-items-center">
                                            <div class="col-md-5">
                                                <select name="author" id="author" class="form-control">
                                                    <option value="" disabled selected>Select Author...</option>
                                                    @foreach($authors as $author)
                                                        <option
                                                            value="{{ $author->id }}" {{ old('author') == $author->id ? 'selected' : '' }}>
                                                            {{ $author->surname }}, {{ $author->forename }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-1 text-center" style="text-align: center;">
                                                <p class="or-divider">OR</p>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <input type="text" name="new_author_surname"
                                                           id="new_author_surname"
                                                           class="form-control"
                                                           placeholder="Enter Author Surname..."
                                                           value="{{ old('new_author_surname') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <input type="text" name="new_author_forename"
                                                           id="new_author_forename"
                                                           class="form-control"
                                                           placeholder="Enter Author Forename..."
                                                           value="{{ old('new_author_forename') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    {{-- Genre --}}
                                    <div class="form-group">
                                        <h3>Genre <span class="text-danger">*</span></h3>
                                        <div class="row align-items-center">
                                            <div class="col-md-5">
                                                <select name="genre" id="genre" class="form-control">
                                                    <option value="" disabled selected>Select Genre...</option>
                                                    @foreach($genres as $genre)
                                                        <option
                                                            value="{{ $genre->id }}" {{ old('genre') == $genre->id ? 'selected' : '' }}>
                                                            {{ $genre->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-1 text-center" style="text-align: center;">
                                                <p class="or-divider">OR</p>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <input type="text" name="new_genre" id="new_genre"
                                                           class="form-control"
                                                           placeholder="Enter Genre..."
                                                           value="{{ old('new_genre') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Description --}}
                                    <div class="form-group">
                                        <h3>Description</h3>
                                        <textarea style="resize: none;" class="form-control" id="description"
                                                  name="description"
                                                  placeholder="Enter description ..."
                                                  rows="5">{{ old('description') ? old('description') : '' }}</textarea>
                                    </div>
                                </div>


                                {{-- If not a new catalogue entry --}}
                                <div id="existingCatalogueEntryFields">
                                    {{-- Format --}}

                                        <div class="col-md-5">
                                            <h3>Format <span class="text-danger">*</span></h3>
                                            <select name="format" id="format" class="form-control">
                                                @foreach($formats as $format)
                                                    <option
                                                        value="{{ $format->id }}" {{ old('format', $format->id) == $format->id ? 'selected' : '' }}>
                                                        {{ $format->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-1">
                                        </div>



                                    <div class="col-md-5">
                                        <h3>Language <span class="text-danger">*</span></h3>
                                        <select name="language" id="language" class="form-control">
                                            @foreach($languages as $language)
                                                <option
                                                    value="{{ $language->id }}" {{ old('language', $language->id) == $language->id ? 'selected' : '' }}>
                                                    {{ $language->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>


                                    {{-- Condition --}}
                                    <div class="form-group">
                                        <h3>Book Condition <span class="text-danger">*</span></h3>
                                        <div class="row align-items-center">
                                            <div class="col-md-5">
                                                <select name="condition" id="condition" class="form-control">
                                                    @foreach($conditions as $condition)
                                                        <option
                                                            value="{{ $condition->id }}" {{ old('condition', \App\Models\Condition::where('name', 'New')->first()->id) == $condition->id ? 'selected' : '' }}>
                                                            {{ $condition->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                {{-- Publisher --}}
                                <div class="form-group">
                                    <h3>Publisher <span class="text-danger">*</span></h3>
                                    <div class="row align-items-center">
                                        <div class="col-md-5">
                                            <select name="publisher" id="publisher" class="form-control">
                                                <option value="" disabled selected>Select Publisher...</option>
                                                @foreach($publishers as $publisher)
                                                    <option
                                                        value="{{ $publisher->id }}" {{ old('publisher') == $publisher->id ? 'selected' : '' }}>
                                                        {{ $publisher->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-1 text-center" style="text-align: center;">
                                            <p class="or-divider">OR</p>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <input type="text" name="new_publisher" id="new_publisher"
                                                       class="form-control" placeholder="Enter Publisher..."
                                                       value="{{ old('new_publisher') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Publish Date --}}
                                <div class="row align-items-center">
                                    <div class="col-md-11">
                                        <div class="form-group">
                                            <h3>Publish Date <span class="text-danger">*</span></h3>
                                            <div class="row align-items-center">
                                                {{-- Day Input --}}
                                                <div class="col-md-2">
                                                    {!! Form::selectRange('publish_day', 1, 31, old('publish_day'), ['class' => 'form-control']) !!}
                                                </div>

                                                {{-- Month Input --}}
                                                <div class="col-md-2">
                                                    {!! Form::selectMonth('publish_month', old('publish_month'), ['class' => 'form-control']) !!}
                                                </div>

                                                {{-- Year Input --}}
                                                <div class="col-md-2">
                                                    {!! Form::selectRange('publish_year', date('Y'), date('Y') - 100, old('publish_year'), ['class' => 'form-control']) !!}
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                                {{-- ISBN --}}
                                <div class="form-group">
                                    <div class="row align-items-center">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <h3>ISBN</h3>
                                                <input type="text" name="isbn" id="isbn" class="form-control"
                                                       placeholder="Enter ISBN..." value="{{ old('isbn') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row align-items-center">

                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <h3>Pages</h3>
                                                <input type="number" name="pages" id="pages" class="form-control"
                                                       placeholder="Enter page count..."
                                                       value=" {{ old('pages') }}">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                </div>

                {{-- Submit Button --}}
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Confirm Book</button>
                </div>
                </form>
            </div>

        </div>
    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const titleSelect = document.getElementById('title');
            const newCatalogueEntryFields = document.getElementById('newCatalogueEntryFields');
            const existingCatalogueEntryFields = document.getElementById('existingCatalogueEntryFields');
            const newTitleInput = document.getElementById('new_title');
            const publisherSelect = document.getElementById('publisher');
            const newPublisherInput = document.getElementById('new_publisher');
            const authorSelect = document.getElementById('author');
            const newAuthorSurnameInput = document.getElementById('new_author_surname');
            const newAuthorForenameInput = document.getElementById('new_author_forename');
            const genreSelect = document.getElementById('genre');
            const newGenreInput = document.getElementById('new_genre');

            function resetAuthorSelection() {
                authorSelect.selectedIndex = 0; // Reset to the first option
            }

            // Check if 'title' has a value in old input
            if (titleSelect.value === '' && newTitleInput.value.trim() !== '') {
                newCatalogueEntryFields.style.display = 'block';
            } else if (titleSelect.value === '' || titleSelect.value === null) {
                //newCatalogueEntryFields.style.display = 'block';
            } else {
                newCatalogueEntryFields.style.display = 'none';
                newTitleInput.value = '';
            }

            titleSelect.addEventListener('change', function () {
                if (titleSelect.value === '' || titleSelect.value === null) {
                    existingCatalogueEntryFields.style.display = 'none';
                    newCatalogueEntryFields.style.display = 'block';
                } else {
                    newCatalogueEntryFields.style.display = 'none';
                    existingCatalogueEntryFields.style.display = 'block';
                    newTitleInput.value = '';


                }
            });

            newTitleInput.addEventListener('input', function () {
                if (newTitleInput.value.trim() !== '') {
                    // Clear the value of newCatalogueEntryInput when a book catalogue entry is selected
                    titleSelect.value = '';
                    newCatalogueEntryFields.style.display = 'block';
                    existingCatalogueEntryFields.style.display = 'block';
                }
            });

            newPublisherInput.addEventListener('input', function () {
                if (newPublisherInput.value.trim() !== '') {
                    // Clear the value of publisher dropdown when a new publisher is being entered
                    publisherSelect.selectedIndex = 0;
                }
            });

            newAuthorSurnameInput.addEventListener('input', function () {
                if (newAuthorSurnameInput.value.trim() !== '' || newAuthorForenameInput.value.trim() !== '') {
                    // Clear the value of author dropdown when a new author is being entered
                    resetAuthorSelection(); // Reset author selection
                }
            });

            newAuthorForenameInput.addEventListener('input', function () {
                if (newAuthorSurnameInput.value.trim() !== '' || newAuthorForenameInput.value.trim() !== '') {
                    // Clear the value of author dropdown when a new author is being entered
                    resetAuthorSelection(); // Reset author selection
                }
            });

            newGenreInput.addEventListener('input', function () {
                if (newGenreInput.value.trim() !== '') {
                    // Clear the value of genre dropdown when a new genre is being entered
                    resetGenreSelection(); // Reset genre selection
                }
            });


        });
    </script>

        <!-- Add this to your Blade view file or include in your main layout -->
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

        <script>
            $(document).ready(function () {
                $('#title').on('change', function () {
                    var selectedBook = $(this).val();

                    $.ajax({
                        url: '/get-book-details/' + selectedBook,
                        type: 'GET',
                        success: function (data) {
                            // Update the DOM with the fetched book details
                            $('#author').text('Author: ' + data.author);
                            $('#genre').text('Genre: ' + data.genre);
                        },
                        error: function () {
                            console.log('Error fetching book details.');
                        }
                    });
                });
            });
        </script>


        <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">
</x-app-layout>
