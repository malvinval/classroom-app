@extends('layouts.core')

@section('container')
    <div class="container classroom-header">
      <h1 class="display-5 fw-bold text-success">{{ $classroomName }}</h1>
      <p class="col-md-8 fs-6 text-muted">{{ $classroomDescription }}</p>
      <hr>
      @foreach ($forums as $forum)
        <div class="col border p-4">
          {{ $forum->caption }}
        </div>
      @endforeach
    </div>
@endsection