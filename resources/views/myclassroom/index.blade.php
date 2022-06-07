@extends('layouts.core')

@section('container')
    <div class="container myclassroom-container">
        <a href="/mc/create" class="btn btn-success"><i class="bi bi-plus-lg"></i> Create new class</a>

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
                                                    <button class="badge bg-danger border-0" onclick="return confirm('Are you sure want to delete this book ?');"><i class="bi bi-trash3-fill"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                        <small class="text-muted">{{ $myclassroom->raw_access_code }}</small>
                                        <br>
                                        <a href="/c/{{ $myclassroom->access_code }}" class="btn btn-success mt-4">Check</a>
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