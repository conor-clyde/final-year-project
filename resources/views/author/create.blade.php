<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Book Author') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 genres">



                    <form method="post" action="{{ route('author.store') }}">
                        <div class="form-group">
                            @csrf
                            <label for="surname">Surname</label>
                            <input type="text" class="form-control" name="surname" placeholder="Surname"/>
                            <label for="forename">Forename</label>
                            <input type="text" class="form-control" name="forename" placeholder="Forename"/>
                        </div>


                        <button type="submit" class="btn btn-primary" style="background-color: #0d6efd;">Confirm Author</button>

                    </form>




                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" type="text/css" href="{{ asset('custom.css') }}" >
</x-app-layout>

