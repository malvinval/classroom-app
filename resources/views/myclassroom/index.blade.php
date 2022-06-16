@extends('layouts.core')

@section('container')
    <div class="container myclassroom-container">
        <div class="dropdown-container d-flex">
            <div class="dropdown me-1">
                <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-plus-lg"></i> Create
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="/mc/create">New classroom</a></li>
                    @if($myclassrooms->count())
                    <li><a class="dropdown-item" href="/f/create">New forum</a></li>
                    @endif
                </ul>
            </div>
            
            {{-- <div class="dropdown me-1">
                <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-journal-check"></i> Check
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="#">Student's Assignments</a></li>
                    @if($myclassrooms->count())
                    <li><a class="dropdown-item" href="#">Student's Presence</a></li>
                    @endif
                </ul>
            </div> --}}
        </div>
            
            <div class="myclassroom-list-container mt-4">
            @if($myclassrooms->count())
                @foreach ($myclassrooms as $myclassroom)
                    <div class="card mb-3 me-2" style="width: 400px;">
                        <div class="row g-0">
                            <div class="myclassroom-cards row g-0">
                                <div class="col-md-12">
                                    <div class="card-body">
                                        <div class="sub-header d-flex justify-content-between">
                                            <h5 class="card-title">{{ $myclassroom->name }}</h5>
                                            <div class="myclassroom-buttons-container">
                                                <a href="/mc/{{ $myclassroom->access_code }}" class="badge bg-primary"><i class="bi bi-person-check-fill"></i></a>
                                                <a href="/mc/{{ $myclassroom->access_code }}/edit" class="badge bg-warning"><i class="bi bi-pen-fill"></i></a>
                                                <form action="/mc/{{ $myclassroom->access_code }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="badge bg-danger border-0" onclick="return confirm('Are you sure want to delete this classroom ?');"><i class="bi bi-trash3-fill"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                        <small class="text-muted">{{ $myclassroom->raw_access_code }}</small>
                                        <br>
                                        <a href="/c/{{ $myclassroom->access_code }}" class="btn text-success border-success mt-4">Check</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-danger">You have never created any classroom !</p>
            @endif
        </div>
    </div>
@endsection