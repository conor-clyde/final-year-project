<x-app-layout>
    <x-slot name="header">
        <h2 >
            {{ __('Update Author') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div >
                <div >

                    {{-- Return Button --}}
                    <div class="top-buttons d-flex justify-content-between">
                        <a href="{{ route('author') }}" class="btn btn-secondary mb-4 returnBtn">Go Back</a>
                        <div>
                            <h3><span class="text-danger">*</span> = required</h3>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="post" action="{{ route('author.update', $author->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row align-items-center">

                            {{-- Author Forename --}}
                            <label class="form-label" for="forename">Forename <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="forename"
                                   placeholder="Enter forename..." name="forename"
                                   value="{{ $author->forename }}" required/>

                            {{-- Author Surname --}}
                            <label class="form-label" for="surname">Surname <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="surname" placeholder="Enter surname..."
                                   name="surname" value="{{ $author->surname }}" required/>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Update Author</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
