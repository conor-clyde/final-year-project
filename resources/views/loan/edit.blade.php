<x-app-layout>

    {{-- Header --}}
    <x-slot name="header">
        <h2 >
            {{ __('Update Loan') }}
        </h2>
    </x-slot>

    {{-- Loan.Edit --}}
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
                    <a href="{{ route('loan') }}" class="btn btn-secondary">Go Back</a>

                    <!-- Update Book Title Details-->
                    <h2>Loan Details</h2>

                    <form method="post" action="{{ route('loan.update', $loan->id) }}">
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
                                <td>Book</td>
                                <td>{{ $loan->bookCopy->catalogueEntry->title }}</td>
                                <td>
                                    <select name="title" class="form-control">
                                        @foreach ($books as $book)
                                            <option
                                                value="{{ $book->id }}" {{ $loan->book_copy_id == $book->id ? 'selected' : '' }}>
                                                {{ $book->catalogueEntry->title }} ({{ $book->id }})
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>

                            {{-- Patron --}}
                            <tr>
                                <td>Patron</td>
                                <td>{{ $loan->patron->forename }} {{ $loan->patron->surname }}</td>
                                <td>
                                    <select name="patron" class="form-control">
                                        @foreach ($patrons as $patron)
                                            <option
                                                value="{{ $patron->id }}" {{ $loan->patron_id == $patron->id ? 'selected' : '' }}>
                                                {{ $patron->forename }} {{ $patron->surname }} ({{ $patron->id }})
                                            </option>
                                        @endforeach
                                    </select>
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

                            @php
                                $startTime = \Carbon\Carbon::parse($loan->loan_date);
                                $endTime = \Carbon\Carbon::parse($loan->due_date);
                                $type = "";

                                // Create separate instances for comparison
                                $startPlusMonth = $startTime->copy()->addMonth();
                                $startPlusTwoWeeks = $startTime->copy()->addWeeks(2);

                                if ($startPlusMonth->equalTo($endTime)) {
                                    $type = "Month";
                                } elseif ($startPlusTwoWeeks->equalTo($endTime)) {
                                    $type = "2Week";
                                }
                            @endphp

                            <tr>
                                <td>Loan Duration</td>
                                <td>
                                    @if ($type=="Month")
                                        One Month
                                    @elseif ($type=="2Week")
                                        Two Weeks
                                    @endif

                                </td>
                                <td>
                                    @if ($endTime->greaterThan(now()))
                                            <select name="loan_duration" id="loan_duration" class="form-control">
                                                <option value="2_weeks" {{ $type == "2Week" ? "selected" : "" }}>Two
                                                    Weeks
                                                </option>
                                                <option value="1_month" {{ $type == "Month" ? "selected" : "" }}>One
                                                    Month
                                                </option>
                                            </select>
                                    @endif
                                </td>
                            </tr>


                            </tbody>
                        </table>

                        {{-- Submit Book Title Details Button --}}
                        <div class="text-right">
                            <button type="submit" class="btn-primary btn">Confirm Loan Details</button>
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

