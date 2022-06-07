@extends('layouts.core')

@section('container')
    <div class="container myclassroom-details-container">
        <h3 class="text-muted">Teacher</h3>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Creation time</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>{{$classrooms->first()->creator_name}} {{ $classrooms->first()->creator_id == auth()->user()->id ? "(You)" : "" }}</td>
                    <td>{{$classrooms->first()->created_at}}</td>
                </tr>
            </tbody>
        </table>

        <h3 class="text-muted mt-5">Students</h3>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Joined at</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($classrooms->skip(1) as $classroom)
                    <tr>
                        <td>{{$classroom->registrar_name}} {{ $classroom->registrar_id == auth()->user()->id ? "(You)" : "" }}</td>
                        <td>{{$classroom->created_at}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection