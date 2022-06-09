<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Forum;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        // dd($request);
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'caption' => 'required',
            'isAttachFile' => 'required'
        ]);

        $validatedData['classroom_access_code'] = $request['classroom_access_code'];
        $validatedData['creator_name'] = auth()->user()->name;
        $validatedData['creator_id'] = auth()->user()->id;

        Forum::create($validatedData);

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

        $classroom = Classroom::where("access_code", $specified_forum->classroom_access_code)->get();

        return view('forum.show', [
            "classroom" => $classroom,
            "specified_forum" => $specified_forum
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
        //
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
        //
    }
}
