<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <style>
            body {
                background-color: #f8fafc;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-md-8">
                    <div class="text-center mb-4">
                        <a href="/">
                            <x-application-logo style="width: 8rem; height: auto;" />
                        </a>
                    </div>
                    @yield('content')
                </div>
            </div>
        </div>
    </body>
</html>
