@extends('layouts.core')

@section('container')
    <div class="create-forum-form-container container">
        <div class="col-lg-6">
            <form method="POST" action="/f" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" autofocus
                    value="{{ old('title') }}" autocomplete="off">
                    @error("title")
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="caption" class="form-label">Caption</label>
                    <input id="caption" type="hidden" name="caption" class="@error('caption') is-invalid @enderror" value="{{ old('caption') }}">
                    <trix-editor input="caption"></trix-editor>
                    @error("caption")
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <label class="mb-3">Must attach file ?</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                    <label class="form-check-label" for="flexRadioDefault1">
                    Yes
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                    <label class="form-check-label" for="flexRadioDefault2">
                    No
                    </label>
                </div>

                <button type="submit" class="btn btn-success mt-3">Create</button>
            </form>
        </div>
    </div>
@endsection