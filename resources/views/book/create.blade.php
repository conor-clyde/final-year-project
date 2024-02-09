<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Book') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 genres">

                    {{-- Display success message if available --}}
                    @if(Session::has('flashMessage'))
                        <div class="alert alert-success">
                            {{ Session::get('flashMessage') }}
                        </div>
                    @endif

                    {{-- Link to return to the Books index --}}
                    <a href="{{ url()->previous() }}" class="btn btn-secondary mb-4">Go Back</a>

                    {{-- Book Copy Form --}}
                    <form method="post" action="{{route('book.store')}}">
                        <div class="row mb-3">
                            <h2 class="col-12">Select the Book Title or Add a New Book Title</h2>
                        </div>
                        <div class="row">
                            <div class="col-md-6">

                                {{-- Catalogue Entry Selection --}}
                                <div class="form-group">
                                    <label for="catalogue_entry">Select Book Title:</label>
                                    <select name="catalogue_entry" id="catalogue_entry" class="form-control">
                                        <option value="" disabled selected>Select book title...</option>
                                        {{-- Existing Catalogue Entries --}}
                                        @foreach($catalogue_entries as $catalogue_entry)
                                            <option value="{{ $catalogue_entry->id }}">{{ $catalogue_entry->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">

                                {{-- OR Add a New Catalogue Entry --}}
                                <div class="form-group">
                                    <label for="new_catalogue_entry">Enter New Book Title:</label>
                                    <input type="text" name="new_catalogue_entry" id="new_catalogue_entry" class="form-control" placeholder="Enter book title...">
                                </div>
                            </div>
                        </div>

                        {{-- If creating a new catalogue entry --}}
                        <div id="newCatalogueEntryFields" style="display: none;">

                            {{-- Genre --}}
                            <div class="form-group">
                                <label for="genre">Genre:</label>
                                <select name="genre" id="genre" class="form-control" required>
                                    @foreach($genres as $genre)
                                        <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Author --}}
                            <div class="form-group">
                                <label for="author">Author:</label>
                                <select name="author" id="author" class="form-control" required>
                                    @foreach($authors as $author)
                                        <option value="{{ $author->id }}">{{ $author->surname }}, {{ $author->forename }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- If not a new catalogue entry --}}
                        <div id="existingCatalogueEntryFields" style="display: none;">

                            {{-- Publisher --}}
                            <div class="form-group">
                                <label for="publisher">Publisher:</label>
                                <select name="publisher" id="publisher" class="form-control" required>
                                    @foreach($publishers as $publisher)
                                        <option value="{{ $publisher->id }}">{{ $publisher->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Publish Year --}}
                            <div class="form-group">
                                <label for="publish_year">Publish Year:</label>
                                <input type="number" name="publish_year" id="publish_year" class="form-control" required>
                            </div>
                        </div>

                        {{-- Custom Fields or Additional Relationships --}}
                        {{-- Add any other fields or relationships based on your database structure --}}

                        {{-- Submit Button --}}
                        <button type="submit" class="btn btn-primary" style="background-color: #0d6efd;">Add Book Copy</button>
                    </form>

                </div>
            </div>
        </div>
    </div>


    {{-- Include Custom JavaScript --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const catalogueEntrySelect = document.getElementById('catalogue_entry');
            const newCatalogueEntryFields = document.getElementById('newCatalogueEntryFields');
            const existingCatalogueEntryFields = document.getElementById('existingCatalogueEntryFields');
            const newCatalogueEntryInput = document.getElementById('new_catalogue_entry');

            catalogueEntrySelect.addEventListener('change', function () {


                if (catalogueEntrySelect.value === '' || catalogueEntrySelect.value === null) {

                    existingCatalogueEntryFields.style.display = 'none';
                    newCatalogueEntryFields.style.display = 'block';
                } else {

                    newCatalogueEntryFields.style.display = 'none';
                    existingCatalogueEntryFields.style.display = 'block';
                }
            });


            newCatalogueEntryInput.addEventListener('input', function () {
                if (newCatalogueEntryInput.value.trim() !== '') {
                    catalogueEntrySelect.value = '';
                    newCatalogueEntryFields.style.display = 'block';
                    existingCatalogueEntryFields.style.display = 'block';

                }
            });
        });


    </script>

    {{-- Include Custom CSS --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">

</x-app-layout>
