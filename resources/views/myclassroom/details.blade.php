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
                    <th scope="col">Action</th>
                </tr>
            </thead>

            <tbody>
                @if($classrooms->count() > 1)
                    @foreach ($classrooms->skip(1) as $classroom)
                        <tr>
                            <td>{{$classroom->registrar_name}} {{ $classroom->registrar_id == auth()->user()->id ? "(You)" : "" }}</td>
                            <td>{{$classroom->created_at->format('Y-m-d')}}</td>
                            @if(auth()->user()->id == $classroom->creator_id)
                                <td>
                                    <form action="/r/{{ $classroom->registrar_id }}" method="POST">
                                        @csrf
                                        @method("delete")
                                        <input type="hidden" name="classroom_access_code" value="{{ $classroom->access_code }}" readonly>
                                        <button type="submit" onclick="return confirm('Are you sure want to kick out {{ $classroom->registrar_name }} ?');" class="badge bg-danger text-uppercase text-decoration-none border-0">Kick Out</button>
                                    </form>
                                </td>
                            @elseif(auth()->user()->id == $classroom->registrar_id)
                                <td>
                                    <form action="/r/{{ $classroom->registrar_id }}" method="POST">
                                        @csrf
                                        @method("delete")
                                        <input type="hidden" name="classroom_access_code" value="{{ $classroom->access_code }}" readonly>
                                        <button type="submit" onclick="return confirm('Are you sure want to leave {{ $classroom->name }} classroom ?');" class="badge bg-danger text-uppercase text-decoration-none border-0">Leave</button>
                                    </form>
                                </td>
                            @else
                                <td></td>
                            @endif
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>No students yet.</td>
                        <td></td>
                        <td></td>
                    </tr>  
                @endif
            </tbody>
        </table>
    </div>
@endsection