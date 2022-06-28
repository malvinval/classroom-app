<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use App\Models\ForumComment;
use Illuminate\Http\Request;

class CommentController extends Controller
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
        $validatedData = $request->validate([
            "forum_id" => "required",
            "caption" => "required"
        ]);

        $validatedData["sender_id"] = auth()->user()->id;
        $validatedData["sender_name"] = auth()->user()->name;

        if($request->reply_to_id) {
            $validatedData["reply_to_id"] = $request->reply_to_id;
        }

        ForumComment::create($validatedData);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($forum_id, $sender_id)
    {
        $comments = ForumComment::where("reply_to_id", $sender_id)->orWhere("sender_id", $sender_id)->get();
        // dd($comments);
        return view("reply.create", [
            "comments" => $comments,
            "forum_id" => $forum_id
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
        $specified_comment = ForumComment::find($id);

        ForumComment::destroy($specified_comment->id);

        return redirect("/f/" . $specified_comment->forum_id);
    }
}
