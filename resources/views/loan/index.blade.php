<x-app-layout>

    <!-- Header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Loans') }}
        </h2>
    </x-slot>

    <!-- Loan.index -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 genres">

                    <!-- Flash message -->
                    @if(Session::has('flashMessage'))
                        <div class="alert alert-success">
                            {{ Session::get('flashMessage') }}
                        </div>
                    @endif

                    <!-- Add, archived, and deleted buttons -->
                    <div class="top-buttons d-flex justify-content-between">
                        <a href="{{ route('loan.create') }}" class="btn btn-primary">Add Loan</a>
                    </div>

                    <!-- Book table -->
                    <table id="indexLoan" class="data-table table">

                        <!-- Table headings -->
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Book</th>
                            <th>Patron</th>
                            <th>Start Date</th>
                            <th>Return Date</th>
                            <th>Returned</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>

                        <!-- Table body -->
                        <tbody>
                        @foreach ($loans as $loan)
                            <tr>
                                <td>{{ $loan->id }}</td>
                                <td>{{ $loan->bookCopy->CatalogueEntry->title }} by
                                    @foreach ($loan->bookCopy->CatalogueEntry->authors as $author)
                                        {{ $author->forename }} {{ $author->surname }}
                                        @if (!$loop->last)
                                            &amp;
                                        @endif

                                    @endforeach
                                ({{ $loan->bookCopy->id }})</td>
                                <td>{{ $loan->patron->forename }} {{ $loan->patron->surname }} ({{ $loan->patron->id }})
                                </td>
                                <td>{{ \Carbon\Carbon::parse($loan->start_time)->format('jS M Y') }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($loan->end_time)->format('jS M Y') }}</td>
                                <td>{{ $loan->is_returned ? 'Yes' : 'No' }}</td>

                                <td style="padding-right:4px; padding-left: 4px;">
                                    @if (!$loan->is_returned)
                                        <a class="btn btn-primary btn-width-80" href="loan/return/{{ $loan->id }}">
                                            Return</a>
                                    @else
                                    @endif
                                </td>
                                <td style="padding-right:4px; padding-left: 4px;">
                                    <a href="loan/{{$loan->id}}/edit" class="btn btn-primary btn-width-80">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for archive and delete confirmation -->
    @include('partials.delete-modal', ['modalId' => 'deleteModal', 'formAction' => url('loan/delete'), 'textareaId' => 'deleteQuestion', 'archive_genre_id' => 'archive_genre_id', 'confirmDeletionBtn' => 'confirmDeletionBtn'])

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

    <!-- DataTables Buttons JS -->
    <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>

    <!-- DataTables Responsive JS -->
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <!-- My scripts -->
    <script src="{{ asset('js/loan.js') }}"></script>

    <!-- Confirm delete-->
    <script>
        $('.deleteCategoryBtn').click(function (e) {
            e.preventDefault();

            var category_id = $(this).val();
            console.log(category_id);

            $.ajax({
                url: '{{ route('loan.check-deletion', ':id') }}'.replace(':id', category_id),
                type: 'GET',
                success: function (response) {
                    console.log(response.message);
                    $('#deleteQuestion').val(response.message);
                    $('#category_id').val(category_id);

                    var deletable = response.deletable;

                    if (deletable) {
                        $('#confirmDeletionBtn').show();
                    } else {
                        $('#confirmDeletionBtn').hide();
                    }

                    // Show the modal
                    $('#deleteModal').modal('show');
                },
                error: function (error) {
                    // Handle errors, e.g., show an alert
                    alert('Error checking deletion status');
                }
            });
        });
    </script>

</x-app-layout>
