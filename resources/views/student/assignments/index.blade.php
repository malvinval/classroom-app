@extends("layouts.core")

@section('container')
    <div class="container student-assignments-container">
        <h4 class="text-muted mb-3">Student Assignments</h4> 
        <table class="table mt-4">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">File</th>
                    <th scope="col">Uploaded at</th>
                </tr>
            </thead>
            <tbody>
                @if($student_assignments->count())
                    @foreach ($student_assignments as $student_assignment)
                        <tr>
                            <td>{{$student_assignment->sender_name}}</td>
                            <td><a href="/storage/{{ $student_assignment->file }}" download="{{$student_assignment->original_file_name}}">{{$student_assignment->original_file_name}}</a></td>
                            <td>{{$student_assignment->created_at}}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>No assignments yet.</td>
                        <td></td>
                    </tr>  
                @endif
            </tbody>
        </table>
    </div>
@endsection