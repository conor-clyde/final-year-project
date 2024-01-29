<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>




        <script>
            $('.deleteCategoryBtn').click(function (e) {
                e.preventDefault();

                var category_id = $(this).val();

                // Perform the AJAX request to check if the category can be deleted
                $.ajax({
                    url: '{{ route('genre.check-deletion', ':id') }}'.replace(':id', category_id),
                    type: 'GET',
                    success: function (response) {
                        // Set the modal content
                        console.log(response.message);
                        $('#deleteQuestion').val(response.message);
                        $('#category_id').val(category_id);

                        // Determine whether the genre is deletable
                        var deletable = response.deletable; // Assuming the response contains information about deletability

                        // Show or hide the "Confirm Deletion" button based on deletability
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

        <script>
            $('.permanentDeleteBtn').click(function (e) {
                e.preventDefault();

                var genre_id = $(this).val();

                // Perform the AJAX request for permanent delete
                $.ajax({
                    url: '{{ route('genre.permanent-delete', ':id') }}'.replace(':id', genre_id),
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}', // Include CSRF token
                    },
                    success: function (response) {
                        // Handle success (e.g., show a success message)
                        alert(response.message);

                        // Optionally, you can reload the page or update the UI as needed
                        location.reload();
                    },
                    error: function (error) {
                        // Handle errors (e.g., show an error message)
                        alert('Error during permanent deletion.');
                    }
                });
            });

        </script>









    </body>
</html>
