@extends('layouts.core')

@section('container')
    <div class="row container mx-auto mt-4 mb-4">
        <div class="col-md-6">
            <form class="input-group join-classroom" method="POST" action="/r">
                @csrf
                <input class="form-control bg-opacity-0" id="access_code_input" name="access_code" type="text" placeholder="Classroom code" aria-label="Search">
                <button class="btn btn-outline-success" type="submit"><i class="bi bi-box-arrow-in-right"></i></button>
            </form>
        </div>
    </div>
@endsection