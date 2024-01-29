<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Book Publisher') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 genres">


                    {!! Form::open (['method' => 'PUT', 'url' => ['publisher/update', $publisher->id]]) !!}

                    {!! Form::hidden ('id', $publisher->id) !!}

                    {!! Form::label ('name', 'Name:') !!}
                    {!! Form::text ('name', $publisher->name) !!}

                    {!! Form::submit ('Update', ['class' => 'btn btn-primary', 'style' => "background-color: #0d6efd;"])  !!}

                    {!! Form::close() !!}









                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" type="text/css" href="{{ asset('custom.css') }}" >
</x-app-layout>

