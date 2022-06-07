<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\ClassroomRegistrar;
use App\Models\Creator;
use Faker\Factory;
use Illuminate\Http\Request;

class MyClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $myclassrooms = Classroom::where("creator_id", auth()->user()->id)->get();

        return view("myclassroom.index", compact("myclassrooms"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("myclassroom.create");
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
            "name" => "required|max:255",
            "slug" => "required",
            "description" => "required|max:255"
        ]);

        $faker = Factory::create();

        $raw_access_code = strtoupper($faker->bothify('?##??##?'));
        $access_code = password_hash($raw_access_code, PASSWORD_DEFAULT);

        $validatedData["raw_access_code"] = $raw_access_code;
        
        $validatedData["access_code"] = str_replace("/","x", $access_code);

        $validatedData["creator_id"] = auth()->user()->id;
        $validatedData["creator_name"] = auth()->user()->name;
        
        Classroom::create($validatedData);
        
        ClassroomRegistrar::create([
            "name" => $validatedData["name"],
            "slug" => $validatedData["slug"],
            "raw_access_code" => $validatedData["raw_access_code"],
            "access_code" => $validatedData["access_code"],
            "creator_id" => auth()->user()->id,
            "creator_name" => auth()->user()->name,
            "registrar_id" =>auth()->user()->id,
            "registrar_name" =>auth()->user()->name,
            "description" => $validatedData["description"],
        ]);

        return redirect("/mc")->with("success", "Your new classroom has been published !");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($access_code)
    {
        $classrooms = ClassroomRegistrar::where("access_code", $access_code)->get();

        // dd($classroom);
        return view("myclassroom.details", compact("classrooms"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($access_code)
    {
        $classroom = Classroom::where("access_code", $access_code)->get();

        // "classroom_name" => $classroom->name,
        // "classroom_id" => $classroom->id,
        // "classroom_slug" => $classroom->slug,
        // "classroom_description" => $classroom->description

        return view("myclassroom.edit", compact("classroom"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

    public function update(Request $request, $access_code)
    {
        $classroom = Classroom::where("access_code", $access_code)->get();

        // dd($classroom[0]->slug);

        $validatedData = $request->validate([
            "name" => "required|max:255",
            "slug" => "required",
            "description" => "required|max:255"
        ]);

        // if($request->slug != $classroom[0]->slug) {
        //     $validatedData = $request->validate([
        //         "name" => "required|max:255",
        //         "slug" => "required|unique:classrooms",
        //         "description" => "required|max:255"
        //     ]);
        // }

        $validatedData["id"] = $classroom[0]->id;

        $validatedData["creator_id"] = auth()->user()->id;
        $validatedData["creator_name"] = auth()->user()->name;
        
        Classroom::where("access_code", $access_code)->update($validatedData);
        ClassroomRegistrar::where("access_code", $access_code)->update($validatedData);

        return redirect("/mc")->with("success", "Your classroom has been updated publicly !");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($access_code)
    {
        $classroom = Classroom::where("access_code", $access_code)->get();
        $classroom_registrar = ClassroomRegistrar::where("access_code", $access_code)->get();
    
        Classroom::destroy($classroom);
        ClassroomRegistrar::destroy($classroom_registrar);

        return redirect("/mc")->with("warning", "Your classroom has been deleted permanently !");
    }
}
