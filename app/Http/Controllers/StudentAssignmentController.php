<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Forum;
use App\Models\ForumStudentFileAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $specified_forum = Forum::find($request["forum_id"]);
        $classroom = Classroom::where("access_code", $specified_forum->classroom_access_code)->get();

        $validatedData = $request->validate([
            "student_file_attachment" => 'required|file|max:1024'
        ]);

        $validatedData['forum_id'] = $request["forum_id"];
        $validatedData['sender_id'] = auth()->user()->id;
        $validatedData['sender_name'] = auth()->user()->name;

        foreach($classroom as $c) {
            $specified_forum_title = strtolower($specified_forum->title);
            $specified_forum_title = str_replace(' ', '-', $specified_forum_title);

            $sender_name = strtolower($validatedData["sender_name"]);
            $sender_name = str_replace(' ', '-', $sender_name);

            $validatedData['file'] = $request->file("student_file_attachment")->store("forum-student-file-attachment/" . $c->slug . "/" . $sender_name . "/" . $specified_forum_title);
        }


        ForumStudentFileAttachment::create($validatedData);
        
        return redirect("/f/" . $request["forum_id"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student_assignments = ForumStudentFileAttachment::where("forum_id", $id)->get();
        
        return view("student.assignments.index", [
            "student_assignments" => $student_assignments,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $affected_student_file_attachment = ForumStudentFileAttachment::find($id);

        ForumStudentFileAttachment::destroy($affected_student_file_attachment->id);

        if(file_exists("storage/".$affected_student_file_attachment->file))
        {
            Storage::delete($affected_student_file_attachment->file);
        }

        return redirect("/f/" . $affected_student_file_attachment->forum_id);
    }
}
