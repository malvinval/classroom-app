@extends('layouts.core')

@section('container')
    <div class="container">
        @foreach($classroom as $c)
            <div class="single-forum-detail-header-container">
                <h1 class="display-5 fw-bold text-success">{{ $c->name }}</h1>
                <p class="col-md-8 fs-6 text-muted">{{ $c->description }}</p>
                <hr>  
            </div>

            <div class="single-forum-detail-body-container mt-3">
                <div class="mb-3">
                    <p>{!! $specified_forum->caption !!}</p>
                    
                    @if($teacher_file_attachment->count())
                        @foreach ($teacher_file_attachment as $file)
                            <a href="/storage/{{ $file->file }}">Download file</a>
                        @endforeach
                    @endif
                </div>

                @if($creator_id == auth()->user()->id)
                    <a href="/sa/{{ $specified_forum->id }}" class="btn btn-success mt-3">Check</a>
                @else
                    @if($student_file_attachment->count())
                        @foreach ($student_file_attachment as $file)
                            <div class="card">
                                <div class="card-body">
                                    <p class="text-muted">Your attachment : </p>
                                    <a href="/storage/{{ $file->file }}">{{ $file->file }}</a>
                                </div>
                            </div>
                            <form action="/sa/{{ $file->id }}" method="POST">
                                @csrf
                                @method("delete")
                                <button type="submit" name="submit" onclick="return confirm('Are you sure want to delete this assignment ?');" class="btn btn-danger mt-3">Cancel</button>
                            </form>
                        @endforeach
                    @else
                        <form method="POST" action="/sa" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3 w-50">
                                <input class="form-control-sm @error('student_file_attachment') is-invalid @enderror" type="file" id="student_file_attachment" name="student_file_attachment">
                
                                @error("student_file_attachment")
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <input type="hidden" name="forum_id" value="{{ $specified_forum->id }}" readonly>

                            <button type="submit" name="submit" class="btn btn-success mt-3">Submit</button>
                        </form>
                    @endif
                @endif
            </div>
        @endforeach
    </div>
@endsection