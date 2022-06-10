@extends('layouts.core')

@section('container')
    <div class="container classroom-header">
      <h1 class="display-5 fw-bold text-success">{{ $classroomName }}</h1>
      <p class="col-md-8 fs-6 text-muted">{{ $classroomDescription }}</p>
      <hr>

      @foreach ($forums as $forum)
        <div class="col border p-4 mb-2">
          <div class="single-forum-header-container d-flex justify-content-between">
            <div class="single-forum-header-identity-container">
              <p class="m-0"><strong>{{ $forum->creator_name }}</strong></p>
              <small class="text-muted">created at {{ $forum->created_at->format('Y-m-d') }}</small>
              {{-- <small class="text-muted">edited</small> --}}
            </div>

            @if($forum->creator_id == auth()->user()->id)
              <div class="single-forum-header-buttons-container">
                <a href="/f/{{ $forum->id }}/edit" class="badge bg-warning"><i class="bi bi-pencil-fill"></i></a>
                <form action="/f/{{ $forum->id }}" method="POST" class="d-inline">
                  @csrf
                  @method('delete')
                  <button class="badge bg-danger border-0" onclick="return confirm('Are you sure want to delete this book ?');"><i class="bi bi-trash3-fill"></i></button>
              </form>
              </div>
            @endif
          </div>
          <hr>
          @if ($forum->isAttachFile == 'Y')
            <div class="single-forum-title-container mt-3">
              <a href="/f/{{ $forum->id }}" class="btn text-success border-success">{{ $forum->title }}</a>
            </div>
          @else
            <div class="single-forum-header-container">
              {{ $forum->title }}
            </div>  

            <div class="single-forum-caption-container mt-3">
              {!! $forum->caption !!}
            </div>
          @endif
        </div>
      @endforeach
    </div>
@endsection