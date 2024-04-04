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

                    {{-- Return Button --}}
                    <a href="{{ route ('book') }}" class="btn btn-secondary mb-4">Go Back</a>

                    {{-- Add Book Form --}}
                    <form method="post" action="{{ route('book.store') }}">
                        @csrf

                        <div class="text-right">
                            <h3><span class="text-danger">*</span> = required</h3>
                        </div>

                        {{-- Book Title --}}
                        <div class="row align-items-center">
                            <label class="form-label" for="title">Book Title <span
                                    class="text-danger">*</span></label>

                            {{-- Pre-existing book title selection --}}
                            <div class="col-md-5">
                                <select name="title" id="title" class="form-control">
                                    <option value="" disabled selected>Select Title...</option>
                                    @foreach($catalogue_entries as $catalogue_entry)
                                        <option
                                            value="{{ $catalogue_entry->id }}" {{ old('title') == $catalogue_entry->id ? 'selected' : '' }}>
                                            {{ $catalogue_entry->title }} by
                                            @foreach($catalogue_entry->authors as $author)
                                                {{ $author->surname }}, {{ $author->forename }}
                                                @if (!$loop->last)
                                                    @if ($loop->remaining == 1)
                                                        &amp;
                                                    @else
                                                        ,
                                                    @endif
                                                @endif
                                            @endforeach
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2 text-center">
                                <p class="or-divider">OR</p>
                            </div>

                            {{-- OR enter a new book title --}}
                            <div class="col-md-5">
                                <input type="text" name="new_title" id="new_title" class="form-control"
                                       placeholder="Enter Title..." value="{{ old('new_title') }}">
                            </div>
                        </div>

                        {{-- IF entering a new book title --}}
                        <div id="newCatalogueEntryFields"
                             style="display: none; margin-top:20px; margin-bottom:20px; padding: 20px 30px;background-color: #E5DFD8; border-radius: 20px;">
                            <h3 style=" text-align: center;">New Book Title Details</h3>
                            <hr style="margin-bottom: 10px;">

                            {{-- Pre-existing book author selection --}}
                            <div class="form-group">
                                <label class="form-label" for="author">Author <span
                                        class="text-danger">*</span></label>
                                <div class="row align-items-center form-group2">
                                    <div class="col-md-5">
                                        <select id="author" name="author[]" class="form-control">
                                            <option value="" disabled selected>Select Author...</option>
                                            @foreach($authors as $author)
                                                <option
                                                    value="{{ $author->id }}" {{ old('author.0') == $author->id ? 'selected' : '' }}>
                                                    {{ $author->surname }}, {{ $author->forename }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-2 text-center" style="text-align: center;">
                                        <p class="or-divider">OR</p>
                                    </div>

                                    {{-- OR enter a new book author --}}
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <div id="author-inputs">
                                                <input class="form-control" type="text" name="author_surname[]"
                                                       placeholder="Author Surname">
                                                <input class="form-control" type="text" name="author_forename[]"
                                                       placeholder="Author Forename">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Add/remove author buttons --}}
                                <div class="text-right">
                                    <button style="width:40px; margin-bottom: 20px;" type="button"
                                            id="remove-author-button" class="btn btn-danger">X
                                    </button>
                                    <button style="width:120px; margin-bottom: 20px;" class='btn btn-primary'
                                            type="button" id="add-author">Add Author
                                    </button>
                                </div>
                            </div>

                            {{-- Book Genre --}}
                            <label class="form-label" for="genre">Genre <span class="text-danger">*</span></label>

                            {{-- Pre-existing book genre selection --}}
                            <div class="row align-items-center">
                                <div class="col-md-5">
                                    <select name="genre" id="genre" class="form-control">
                                        <option value="" disabled selected>Select Genre...</option>
                                        @foreach($genres as $genre)
                                            <option
                                                value="{{ $genre->id }}" {{ old('genre') == $genre->id ? 'selected' : '' }}>{{ $genre->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Book Description --}}
                            <label class="form-label" for="description">Description</label>
                            <textarea style="resize: none;" class="form-control" id="description" name="description"
                                      placeholder="Enter description ..."
                                      rows="5">{{ old('description') ? old('description') : '' }}</textarea>
                        </div>

                        {{-- Always shows --}}
                        <div id="existingCatalogueEntryFields">

                            {{-- Book Format --}}
                            <div class="row">
                                <div class="col-md-5">
                                    <label class="form-label" for="format">Format <span
                                            class="text-danger">*</span></label>
                                    <select name="format" id="format" class="form-control">
                                        @foreach($formats as $format)
                                            <option
                                                value="{{ $format->id }}" {{ old('format', $format->id) == $format->id ? 'selected' : '' }}>{{ $format->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Book Language --}}
                            <div class="row">
                                <div class="col-md-5">
                                    <label class="form-label" for="language">Language <span
                                            class="text-danger">*</span></label>
                                    <select name="language" id="language" class="form-control">
                                        @foreach($languages as $language)
                                            <option
                                                value="{{ $language->id }}" {{ old('language', $language->id) == $language->id ? 'selected' : '' }}>
                                                {{ $language->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Book Condition --}}
                            <div class="row">
                                <div class="col-md-5">
                                    <label class="form-label" for="condition">Condition <span
                                            class="text-danger">*</span></label>
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

                            {{-- Book Publisher --}}
                            <div class="row align-items-center">
                                <label class="form-label" for="publisher">Publisher <span
                                        class="text-danger">*</span></label>

                                {{-- Pre-existing book publisher selection --}}
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

                                <div class="col-md-2 text-center" style="text-align: center;">
                                    <p class="or-divider">OR</p>
                                </div>

                                {{-- OR enter a new book publisher --}}
                                <div class="col-md-5">
                                    <input type="text" name="new_publisher" id="new_publisher"
                                           class="form-control" placeholder="Enter Publisher..."
                                           value="{{ old('new_publisher') }}">
                                </div>
                            </div>

                            {{-- Book Publish Date --}}
                            <div class="row align-items-center">
                                <label class="form-label" for="publisher">Publish Date <span
                                        class="text-danger">*</span></label>

                                {{-- Day Input --}}
                                <div class="col-md-2">
                                    {!! Form::selectRange('publish_day', 1, 31, old('publish_day'), ['class' =>
                                    'form-control']) !!}
                                </div>

                                {{-- Month Input --}}
                                <div class="col-md-3">
                                    {!! Form::selectMonth('publish_month', old('publish_month'), ['class' =>
                                    'form-control']) !!}
                                </div>

                                {{-- Year Input --}}
                                <div class="col-md-2">
                                    {!! Form::selectRange('publish_year', date('Y'), date('Y') - 100,
                                    old('publish_year'), ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            {{-- Book ISBN --}}
                            <div class="row">
                                <div class="col-md-5">
                                    <label class="form-label" for="isbn">ISBN</label>
                                    <input type="text" name="isbn" id="isbn" class="form-control"
                                           placeholder="Enter ISBN..." value="{{ old('isbn') }}">
                                </div>
                            </div>

                            {{-- Book Pages --}}
                            <div class="row">
                                <div class="col-md-5">
                                    <label class="form-label" for="pages">Pages</label>
                                    <input min="0" max="2000" type="number" name="pages" id="pages" class="form-control"
                                           placeholder="Enter page count..." value="{{ old('pages') }}">
                                </div>
                            </div>
                        </div>

                        {{-- Submit Form Button --}}
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Confirm Book</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script>
        var addedAuthorSections = 0;

        // Add author input section
        function addAuthorSection() {
            if (addedAuthorSections < 2) {
                var authorContainer = document.querySelector('.form-group2');
                var clonedAuthorContainer = authorContainer.cloneNode(true);
                var oldAuthorIndex = addedAuthorSections === 0 ? "{{ old('author.1') }}" : "{{ old('author.2') }}";
                var oldSurnameIndex = addedAuthorSections === 0 ? {{ old('author_surname.0') ?? -1 }} : {{ old('author_surname.1') ?? -1 }};
                var oldForenameIndex = addedAuthorSections === 0 ? {{ old('author_forename.0') ?? -1 }} : {{ old('author_forename.1') ?? -1 }};

                clonedAuthorContainer.querySelector('[name="author_surname[]"]').value = '';
                clonedAuthorContainer.querySelector('[name="author_forename[]"]').value = '';
                clonedAuthorContainer.querySelector('[name="author[]"]').selectedIndex = 0;

                if (oldAuthorIndex !== "") {
                    clonedAuthorContainer.querySelector('[name="author[]"]').value = oldAuthorIndex;
                }

                if (oldSurnameIndex !== -1) {
                    if (!(clonedAuthorContainer.querySelector('[name="author[]"]').selectedIndex === 0))
                        oldSurnameIndex = addedAuthorSections === 0 ? {{ old('author_surname.1') ?? -1 }} : {{ old('author_surname.2') ?? -1 }};
                    clonedAuthorContainer.querySelector('[name="author_surname[]"]').value = oldSurnameIndex;
                }

                if (oldForenameIndex !== -1) {
                    if (!(clonedAuthorContainer.querySelector('[name="author[]"]').selectedIndex === 0))
                        oldForenameIndex = addedAuthorSections === 0 ? {{ old('author_forename.1') ?? -1 }} : {{ old('author_forename.2') ?? -1 }};
                    clonedAuthorContainer.querySelector('[name="author_forename[]"]').value = oldForenameIndex;
                }

                authorContainer.parentNode.appendChild(clonedAuthorContainer);
                addedAuthorSections++;
            } else {
                alert('You can only add up to three authors.');
            }
        }

        // Remove the newest author input section
        function removeNewestAuthorSection() {
            const authorContainers = document.querySelectorAll('.form-group2');
            if (authorContainers.length > 1) {
                const lastAuthorContainer = authorContainers[authorContainers.length - 1];
                lastAuthorContainer.remove();
                addedAuthorSections--;
            } else {
                alert('You must have at least one author.');
            }
        }

        document.addEventListener('DOMContentLoaded', function () {

            // Add event listener to the "Add Author" button
            const addAuthorButton = document.getElementById('add-author');
            if (addAuthorButton) {
                addAuthorButton.addEventListener('click', addAuthorSection);
            }

            // Add event listener to the "Remove Author" button
            const removeAuthorButton = document.getElementById('remove-author-button');
            if (removeAuthorButton) {
                removeAuthorButton.addEventListener('click', removeNewestAuthorSection);
            }

            document.addEventListener('change', function (event) {
                const target = event.target;
                // Check if the changed element is an author select
                if (target && target.matches('.form-group2 select[name="author[]"]')) {
                    const authorSelect = target;
                    const authorSection = authorSelect.closest('.form-group2');
                    const newAuthorSurnameInput = authorSection.querySelector('input[name="author_surname[]"]');
                    const newAuthorForenameInput = authorSection.querySelector('input[name="author_forename[]"]');

                    if (authorSelect.value !== '') {
                        // Reset the surname and forename inputs if an author is selected from the dropdown
                        newAuthorSurnameInput.value = '';
                        newAuthorForenameInput.value = '';
                    }
                }
            });

            document.addEventListener('input', function (event) {
                const target = event.target;
                // Check if the input element belongs to an author section
                if (target && (target.matches('.form-group2 input[name="author_surname[]"]') || target.matches('.form-group2 input[name="author_forename[]"]'))) {
                    const authorSection = target.closest('.form-group2');
                    const authorSelect = authorSection.querySelector('select[name="author[]"]');



                    if (target.value.trim() !== '') {
                        // Clear the value of author dropdown when a new author is being entered
                        authorSelect.selectedIndex = 0; // Reset author selection
                    }
                }


            });
        });

        // After the page reloads due to validation errors, re-add author sections
        window.addEventListener('load', function () {
            const authorSectionsCount = document.querySelectorAll('.form-group2').length;
            const expectedAuthorCount = {{ old('author') ? count(old('author')) : 0 }};
            const expectedSurnameCount = {{ old('author_surname') ? count(old('author_surname')) : 0 }};



            if (expectedAuthorCount === 0) {
                // Set surname and forename inputs to the values of surname.0 and forename.0
                var oldSurnameIndex = {{ old('author_surname.0') ?? -1 }};
                var oldForenameIndex = {{ old('author_forename.0') ?? -1 }};
                document.querySelector('input[name="author_surname[]"]').value = oldSurnameIndex !== -1 ? oldSurnameIndex : '';
                document.querySelector('input[name="author_forename[]"]').value = oldForenameIndex !== -1 ? oldForenameIndex : '';
            }



            for (let i = authorSectionsCount; i < expectedSurnameCount; i++) {
                addAuthorSection();
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const titleSelect = document.getElementById('title');
            const newCatalogueEntryFields = document.getElementById('newCatalogueEntryFields');
            const existingCatalogueEntryFields = document.getElementById('existingCatalogueEntryFields');
            const newTitleInput = document.getElementById('new_title');
            const publisherSelect = document.getElementById('publisher');
            const newPublisherInput = document.getElementById('new_publisher');
            const authorSelect = document.querySelector('select[name="author[]"]');
            const newAuthorSurnameInput = document.querySelector('input[name="author_surname[]"]');
            const newAuthorForenameInput = document.querySelector('input[name="author_forename[]"]');

            function resetAuthorSelection() {
                authorSelect.selectedIndex = 0; // Reset to the first option
            }

            function resetSurnameAndForenameInputs() {
                newAuthorSurnameInput.value = '';
                newAuthorForenameInput.value = '';
            }

            authorSelect.addEventListener('change', function () {
                if (authorSelect.value !== '') {
                    // Reset the surname and forename inputs if an author is selected from the dropdown
                    resetSurnameAndForenameInputs();
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
        });
    </script>




    <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">
</x-app-layout>
