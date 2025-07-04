<x-app-layout>

    {{-- Header --}}
    <x-slot name="header">
        <h2 >
            {{ __('Add Loan') }}
        </h2>
    </x-slot>

    {{-- Loan.Create --}}
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

                    {{-- Return Button --}}
                    <div class="top-buttons d-flex justify-content-between">
                        <a href="{{ route('loan') }}" class="btn btn-secondary mb-4 returnBtn">Go Back</a>
                        <div>
                            <h3><span class="text-danger">*</span> = required</h3>
                        </div>
                    </div>

                    {{-- Add Loan Form --}}
                    <form method="post" action="{{route('loan.store')}}">
                        @csrf

                        <div class="row align-items-center">

                            {{-- Book Title --}}
                            <label class="form-label" for="title">Book Title <span class="text-danger">*</span></label>

                            {{-- Container for Book Title Search --}}
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <input type="text" id="search_title" class="form-control">
                                </div>
                                <div class="col-md-1">
                                    <button type="button" id="conortest"
                                            class="conortest btn btn-primary" value="101">
                                        Search
                                    </button>
                                </div>
                            </div>

                            <div class="row">
                                {{-- Container for displaying matching book titles --}}
                                <div class="col-md-7">
                                    <div id="matching_titles_container">
                                        <select id="returned_books" class="form-control" name="title" size="16"
                                               >


                                        </select>
                                    </div>
                                </div>

                                {{-- Container for Book Details  --}}
                                <div class="col-md-5">
                                    <div id="book_details_container" >
                                        <div id="book_details_content"></div>
                                    </div>
                                </div>
                            </div>

                            {{-- Patron--}}
                            <div class="row align-items-center">
                                <label class="form-label" for="title">Patron <span
                                        class="text-danger">*</span></label>

                                {{-- Pre-existing Patron selection --}}
                                <div class="col-md-7">
                                    <select name="patron" id="patron" class="form-control">
                                        <option value="" disabled selected>Select Patron...</option>
                                        {{-- Existing Catalogue Entries --}}
                                        @foreach($patrons as $patron)
                                            <option
                                                value="{{ $patron->id }}">
                                                {{ $patron->surname }}  {{ $patron->forename }} ({{ $patron->id }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Loan Duration --}}
                            <div class="row align-items-center mt-3">
                                <label class="form-label" for="loan_duration">Loan Duration <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-7">
                                    <select name="loan_duration" id="loan_duration" class="form-control">
                                        <option value="2_weeks">Two Weeks</option>
                                        <option value="1_month">One Month</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">Confirm Loan</button>
                            </div>
                        </div>
                    </form>
                </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function () {
            // Simulate click event on page load
            $('.conortest').trigger('click');
        });


        $('.conortest').click(function (e) {
            e.preventDefault();

            var book_id
            var url

            if ($('#search_title').val().trim() == '') {
                book_id = 'test'
                url = '{{ route('loan.conortest2', ':id') }}'.replace(':id', book_id);
            } else {
                book_id = $('#search_title').val();
                url = '{{ route('loan.conortest', ':id') }}'.replace(':id', book_id);
            }

            $.ajax({
                url: url,
                type: 'GET',
                success: function (response) {
                    var books = response.books;
                    var selectDropdown = $('#returned_books');
                    var groupedBooks = {};

                    selectDropdown.empty();

                    books.forEach(function (book) {
                        if (!groupedBooks[book.catalogue_entry.title]) {
                            groupedBooks[book.catalogue_entry.title] = [];
                        }
                        groupedBooks[book.catalogue_entry.title].push(book);
                    });

                    Object.keys(groupedBooks).forEach(function (title) {
                        var booksWithTitle = groupedBooks[title];
                        var section = `<optgroup label="${title}`;

                        if (booksWithTitle[0].catalogue_entry.authors.length > 0) {
                            var authors = booksWithTitle[0].catalogue_entry.authors.map(function (author) {
                                return author.forename + ' ' + author.surname;
                            }).join(' & ');

                            section += ` - By ${authors}">`;
                        } else {
                            section += '">';
                        }

                        booksWithTitle.forEach(function (book) {
                            section += `<option value="${book.id}">Book ID: ${book.id}</option>`;
                        });

                        section += '</optgroup>';
                        selectDropdown.append(section);
                    });


                    $('#returned_books').change(function () {
                        var selectedBookId = $(this).val();
                        var selectedBook = books.find(book => book.id == selectedBookId);

                        if (selectedBook) {
                            var authors = selectedBook.catalogue_entry.authors.map(author => `${author.forename} ${author.surname}`).join(' & ');
                            var bookDetails = `<h3>You Selected...</h3>
            <p>Book ID: ${selectedBook.id}</p>
            <p>Format: ${selectedBook.format.name}</p>
            <p>Title: ${selectedBook.catalogue_entry.title}</p>
            <p>Author(s): ${authors}</p>
            <p>Publisher: ${selectedBook.publisher.name}</p>
            <p>Condition: ${selectedBook.condition.name}</p>`;

                            $('#book_details_content').html(bookDetails);
                        }
                    });

                },
                error: function (error) {
                    alert('Error');
                }
            });
        });
    </script>

</x-app-layout>
