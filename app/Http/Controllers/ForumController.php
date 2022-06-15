<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\ClassroomRegistrar;
use App\Models\Forum;
use App\Models\ForumStudentFileAttachment;
use App\Models\ForumTeacherFileAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ForumController extends Controller
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
        $myclassrooms = Classroom::where("creator_id", auth()->user()->id)->get();

        return view("forum.create", compact("myclassrooms"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $classroom = Classroom::where("access_code", $request["classroom_access_code"])->get();

        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'caption' => 'required',
            'isAttachFile' => 'required'
        ]);

        $validatedData['classroom_access_code'] = $request['classroom_access_code'];
        $validatedData['creator_name'] = auth()->user()->name;
        $validatedData['creator_id'] = auth()->user()->id;

        Forum::create($validatedData);

        if($request->file("teacher_file_attachment")) {
            $forum = Forum::latest()->first();

            $validatedFileData = $request->validate([
                'teacher_file_attachment' => 'file|max:1024'
            ]);

            $validatedFileData['forum_id'] = $forum->id;
            $validatedFileData['creator_name'] = $forum->creator_name;
            $validatedFileData['creator_id'] = $forum->creator_id;

            $specified_forum = Forum::find($forum->id);

            foreach($classroom as $c) {
                $specified_forum_title = strtolower($specified_forum->title);
                $specified_forum_title = str_replace(' ', '-', $specified_forum_title);
                $validatedFileData['file'] = $request->file("teacher_file_attachment")->store("forum-teacher-file-attachment/" . $c->slug . "/" . $specified_forum_title);
            }

            ForumTeacherFileAttachment::create($validatedFileData);
        }

        return redirect('/mc');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $specified_forum = Forum::find($id);

        // validate registrar

        $isRegistar = ClassroomRegistrar::where("access_code", $specified_forum->classroom_access_code)->where("registrar_id", auth()->user()->id)->count();

        if($isRegistar == 0) {
            abort(403);
        }

        $classroom = Classroom::where("access_code", $specified_forum->classroom_access_code)->get();

        $student_file_attachment = ForumStudentFileAttachment::where("forum_id", $id)->where("sender_id", auth()->user()->id)->get();
        $teacher_file_attachment = ForumTeacherFileAttachment::where("forum_id", $id)->get();

        return view('forum.show', [
            "classroom" => $classroom,
            "specified_forum" => $specified_forum,
            "creator_id" => $specified_forum->creator_id,
            "student_file_attachment" => $student_file_attachment,
            "teacher_file_attachment" => $teacher_file_attachment
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
        $forum = Forum::find($id);

        return view('forum.edit', compact("forum"));
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
        $forum = Forum::find($id);
        $classroom = Classroom::where("access_code", $forum->classroom_access_code)->get();

        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'caption' => 'required',
            'isAttachFile' => 'required'
        ]);
        $validatedData['isEdited'] = true;

        $forum->update($validatedData);

        if($request->file("teacher_file_attachment")) {
            $validatedFileData = $request->validate([
                'file' => 'file|max:1024'
            ]);

            $validatedFileData['forum_id'] = $forum->id;
            $validatedFileData['creator_name'] = $forum->creator_name;
            $validatedFileData['creator_id'] = $forum->creator_id;
            
            $specified_forum = Forum::find($forum->id);

            foreach($classroom as $c) {
                $specified_forum_title = strtolower($specified_forum->title);
                $specified_forum_title = str_replace(' ', '-', $specified_forum_title);
                
                // delete old stored files

                $specified_file = ForumTeacherFileAttachment::where("forum_id", $specified_forum->id)->get();
                
                foreach($specified_file as $file) {
                    if(file_exists("storage/".$file->file))
                    {
                        Storage::delete($file->file);
                    }
                }
                
                $validatedFileData['file'] = $request->file("teacher_file_attachment")->store("forum-teacher-file-attachment/" . $c->slug . "/" . $specified_forum_title);
            }

            ForumTeacherFileAttachment::where("forum_id", $id)->update($validatedFileData);
        }

        return redirect('/c/' . $forum->classroom_access_code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $specified_forum = Forum::find($id);
        $affected_student_file_attachments = ForumStudentFileAttachment::where("forum_id", $id)->get();
        $affected_teacher_file_attachments = ForumTeacherFileAttachment::where("forum_id", $id)->get();

        Forum::destroy($specified_forum->id);
        ForumStudentFileAttachment::destroy($affected_student_file_attachments);
        ForumTeacherFileAttachment::destroy($affected_teacher_file_attachments);

        foreach($affected_student_file_attachments as $file) {
            if(file_exists("storage/".$file->file))
            {
                Storage::delete($file->file);
            }
        }

        foreach($affected_teacher_file_attachments as $file) {
            if(file_exists("storage/".$file->file))
            {
                Storage::delete($file->file);
            }
        }

        return redirect("/c/" . $specified_forum->classroom_access_code);
    }
}
