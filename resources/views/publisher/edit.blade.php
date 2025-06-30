@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit Publisher') }}
    </h2>
@endsection

@section('content')
    <div class="container">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div >
                    <div >

                        <!-- Errors-->
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
                            <a href="{{ route('publisher') }}" class="btn btn-secondary mb-4 returnBtn">Go Back</a>
                            <div>
                                <h3><span class="text-danger">*</span> = required</h3>
                            </div>
                        </div>

                        <form method="post" action="{{ route('publisher.update', $publisher->id) }}">
                            @csrf
                            @method('PUT')

                            {{-- Publisher Name --}}
                            <div class="row align-items-center">
                                <label class="form-label" for="forename">Publisher <span
                                        class="text-danger">*</span></label>
                                <input id="name" type="text" class="form-control" name="name"
                                       required placeholder="Enter Publisher..." value="{{ $publisher->name }}"/>
                            </div>

                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">Update Publisher</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
