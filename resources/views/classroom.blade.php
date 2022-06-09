@extends('layouts.core')

@section('container')
    <div class="container classroom-header">
      <h1 class="display-5 fw-bold text-success">{{ $classroomName }}</h1>
      <p class="col-md-8 fs-6 text-muted">{{ $classroomDescription }}</p>
      <hr>

      @foreach ($forums as $forum)
        <div class="col border p-4 mb-2">
          <div class="single-forum-header-container">
            <p class="m-0"><strong>{{ $forum->creator_name }}</strong></p>
            <small class="text-muted">at {{ $forum->created_at->format('Y-m-d') }}</small>
            <hr>
          </div>
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