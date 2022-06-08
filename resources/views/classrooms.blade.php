@extends('layouts.core')

@section('container')
    @if (session()->has("success"))
        <div class="toast show border-success" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <h6 class="me-auto">{{ env("APP_NAME") }} says :</h6>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <p class="text-success">{{ session("success") }}</p> 
            </div>
        </div>
    @elseif(session()->has("failed"))
        <div class="toast show border-danger" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <h6 class="me-auto">{{ env("APP_NAME") }} says :</h6>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <p class="text-danger">{{ session("failed") }}</p>
            </div>
        </div>
    @endif
    <div class="container card-container d-flex flex-wrap">
        @if($classrooms->count())
            @foreach ($classrooms as $classroom)
                <div class="card mb-3 me-2" style="width: 400px;">
                    <div class="row g-0">
                        <div class="col-md-12">
                            <div class="card-body">
                                <div class="classrooms-header d-flex justify-content-between">
                                    <h5 class="card-title">{{ $classroom->name }}</h5>
                                    <div class="classrooms-buttons-container">
                                        <a href="/mc/{{ $classroom->access_code }}" class="badge bg-primary"><i class="bi bi-person-fill"></i></a>
                                    </div>
                                </div>
                                @if($classroom->creator_id == auth()->user()->id)
                                    <p class="card-text card-creator-name text-success">You owned this classroom</p>
                                @else
                                    <p class="card-text card-creator-name">{{ $classroom->creator_name }}</p>
                                @endif
                                <a href="/c/{{ $classroom->access_code }}" class="btn btn-success">Check</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-danger">You haven't joined any classes yet.</p>
        @endif
    </div>
@endsection