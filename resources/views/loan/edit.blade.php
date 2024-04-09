<x-app-layout>

    {{-- Header --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Loan') }}
        </h2>
    </x-slot>

    {{-- Loan.Edit --}}
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
                    <a href="{{ route('loan') }}" class="btn btn-secondary" style="margin-bottom: 40px;">Go Back</a>

                    <!-- Update Book Title Details-->
                    <h2>Loan Details</h2>

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
                                <td>Book</td>
                                <td>{{ $book->catalogueEntry->title }}</td>
                                <td><input type="text" name="title" id="title" class="form-control"
                                           value="{{ $book->catalogueEntry->title }}">
                                </td>
                            </tr>

                            {{-- Patron --}}
                            <tr>
                                <td>Patron</td>
                                <td>{{ $loan->patron->forename }} {{ $loan->patron->surname }}</td>

                                {{-- Update Author Surname and Forename --}}
                                <td>
                                    <div style="display: inline-block; margin-right: 10px; width:70px;">
                                        <label for="id">ID:</label><br>
                                        <input disabled type="text" name="" id="id"
                                               class="form-control" style="margin-bottom: 10px;"
                                               value="{{ $loan->patron_id }}">
                                    </div>
                                    <div style="display: inline-block; margin-right: 10px; width: 160px;">
                                        <label for="surname">Surname:</label><br>
                                        <input type="text" name="" id="surname"
                                               class="form-control" style="margin-bottom: 10px;"
                                               value="{{ $loan->patron->forename  }}">
                                    </div>
                                    <div style="display: inline-block; width: 160px;">
                                        <label for="forename">Forename:</label><br>
                                        <input type="text" name="" id="forename"
                                               class="form-control"
                                               value="{{ $loan->patron->surname }}">
                                    </div>
                                </td>

                            {{-- Book Returned --}}
                            <tr>
                                <td>Returned</td>
                                <td>{{ $loan->is_returned ? 'Yes'  : 'No' }}</td>
                                <td>
                                    <select name="is_returned" id="is_returned" class="form-control">
                                        <option value="1" {{ $loan->is_returned ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ !$loan->is_returned ? 'selected' : '' }}>No</option>
                                    </select>
                                </td>
                            </tr>






                            </tbody>
                        </table>

                        {{-- Submit Book Title Details Button --}}
                        <div class="text-right">
                            <button type="submit" class="btn-primary btn">Confirm Book Title Details</button>
                        </div>
                    </form>


                    <td></td>


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


</x-app-layout>

