<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <h2 class="font-semibold text-gray-800 leading-tight" style="margin: 16px;">
            {{ __('Add Loan') }}
        </h2>
    </x-slot>

    {{-- Book.Create --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 genres">

                    {{-- Flash Message --}}
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
                    <a href="{{route ('loan') }}" class="btn btn-secondary mb-4">Go Back</a>

                    {{-- Add Book Form --}}
                    <form method="post" action="{{route('loan.store')}}">
                        @csrf


                        <div class="row align-items-center">
                            <div class="col-md-11">
                                <!-- Add, archived, and deleted buttons -->
                                <div class="top-buttons d-flex justify-content-between">
                                    <h3>Book Title <span class="text-danger">*</span></h3>
                                    <div>
                                        <h3><span class="text-danger">*</span> = required</h3>
                                    </div>
                                </div>

                                {{-- Book Title --}}
                                <div class="row align-items-center">
                                    <div class="col-md-5">
                                        {{-- Catalogue Entry Selection --}}
                                        <div class="form-group">
                                            <select name="title" id="title" class="form-control">
                                                <option value="" disabled selected>Select Title...</option>
                                                {{-- Existing Catalogue Entries --}}
                                                @foreach($catalogue_entries as $catalogue_entry)
                                                    <option
                                                        value="{{ $catalogue_entry->id }}">{{ $catalogue_entry->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- Book Title --}}
                                <div class="row align-items-center">
                                    <h3>Patron <span class="text-danger">*</span></h3>
                                    <div class="col-md-5">
                                        {{-- Catalogue Entry Selection --}}
                                        <div class="form-group">
                                            <select name="patron" id="patron" class="form-control">
                                                <option value="" disabled selected>Select Patron...</option>
                                                {{-- Existing Catalogue Entries --}}
                                                @foreach($patrons as $patron)
                                                    <option
                                                        value="{{ $patron->id }}">{{ $patron->surname }}, {{ $patron->forename }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- Submit Button --}}
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Confirm Book</button>
                                </div>
                            </div>
                    </form>
                </div>
                </form>
            </div>
        </div>

        <script>

        </script>

        <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">
</x-app-layout>
