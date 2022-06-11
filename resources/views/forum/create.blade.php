@extends('layouts.core')

@section('container')
    <div class="create-forum-form-container container">
        <div class="col-lg-6">
            <form method="POST" action="/f" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="classroom_access_code" class="form-label">Choose classroom</label>
                    <select class="form-select @error('classroom_access_code') is-invalid @enderror" name="classroom_access_code" id="classroom_access_code">
                        @foreach($myclassrooms as $myclassroom)
                            @if(old("classroom_access_code") == $myclassroom->access_code)
                                <option value="{{ $myclassroom->access_code }}" selected>{{ $myclassroom->name }}</option>
                            @else
                                <option value="{{ $myclassroom->access_code }}">{{ $myclassroom->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    @error("classroom_access_code")
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

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
            
                <div class="mb-3">
                    <label for="formFileMultiple" class="form-label">Attach file (optional)</label>
                    <input class="form-control @error('teacher_file_attachment') is-invalid @enderror" type="file" id="formFileMultiple"  name="teacher_file_attachment" multiple>
                    @error("teacher_file_attachment")
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- <input class="form-control mb-3 @error('teacher_file') is-invalid @enderror" type="file" id="teacher_file" name="teacher_file"> --}}


                <label class="mb-3">Students attach file ?</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="isAttachFile" id="flexRadioDefault1" value="Y">
                    <label class="form-check-label" for="flexRadioDefault1">
                    Yes
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="isAttachFile" id="flexRadioDefault2" value="N" checked>
                    <label class="form-check-label" for="flexRadioDefault2">
                    No
                    </label>
                </div>


                <button type="submit" class="btn btn-success mt-3">Create</button>
            </form>
        </div>
    </div>
@endsection