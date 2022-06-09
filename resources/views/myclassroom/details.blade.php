@extends('layouts.core')

@section('container')
    <div class="container myclassroom-details-container">
        <h3 class="text-success">Teacher</h3>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Creation date</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>{{$classrooms->first()->creator_name}} {{ $classrooms->first()->creator_id == auth()->user()->id ? "(You)" : "" }}</td>
                    <td>{{$classrooms->first()->created_at->format('Y-m-d')}}</td>
                </tr>
            </tbody>
        </table>

        <h3 class="text-success mt-5">Students</h3>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Joined at</th>
                </tr>
            </thead>

            <tbody>
                @if($classrooms->count() > 1)
                    @foreach ($classrooms->skip(1) as $classroom)
                        <tr>
                            <td>{{$classroom->registrar_name}} {{ $classroom->registrar_id == auth()->user()->id ? "(You)" : "" }}</td>
                            <td>{{$classroom->created_at->format('Y-m-d')}}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>No students yet.</td>
                        <td></td>
                    </tr>  
                @endif
            </tbody>
        </table>
    </div>
@endsection