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
                <p>{!! $specified_forum->caption !!}</p>

                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3 w-50">
                      <input class="form-control @error('file_attachment') is-invalid @enderror" type="file" id="file_attachment" name="file_attachment">
      
                      @error("file_attachment")
                          <div class="invalid-feedback">
                              {{ $message }}
                          </div>
                      @enderror
                    </div>
                </form>
            </div>
        @endforeach
    </div>
@endsection