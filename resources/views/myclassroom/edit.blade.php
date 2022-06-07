@extends('layouts.core')

@section('container')
<div class="container myclassroom-container">
    <div class="col-lg-6">
        @foreach($classroom as $c)
            <form method="POST" action="/mc/{{ $c->access_code }}" enctype="multipart/form-data">
                @csrf
                @method("PUT")
                <div class="mb-3">
                    <label for="name" class="form-label">Classroom's name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" autofocus
                    value="{{ $c->name }}" autocomplete="off">
                    @error("name")
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug"
                    value="{{ $c->slug }}" autocomplete="off">
                    @error("slug")
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                    value="{{ $c->description }}" autocomplete="off">
                    @error("description")
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success">Confirm</button>
            </form>
        @endforeach
    </div>
</div>
@endsection