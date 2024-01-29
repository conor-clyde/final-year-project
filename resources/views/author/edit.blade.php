<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Book Author') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 genres">



                    {!! Form::open (['method' => 'PUT', 'url' => ['author/update', $author->id]]) !!}

                    {!! Form::hidden ('id', $author->id) !!}

                    {!! Form::label ('surname', 'Surname:') !!}
                    {!! Form::text ('surname', $author->surname) !!}

                    {!! Form::label ('forename', 'Forename:') !!}
                    {!! Form::text ('forename', $author->forename) !!}

                    {!! Form::submit ('Update', ['class' => 'btn btn-primary', 'style' => "background-color: #0d6efd;"])  !!}

                    {!! Form::close() !!}









                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" type="text/css" href="{{ asset('custom.css') }}" >
</x-app-layout>

