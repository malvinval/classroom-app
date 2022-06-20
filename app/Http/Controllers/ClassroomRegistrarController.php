<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\ClassroomRegistrar;

class ClassroomRegistrarController extends Controller
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
        // check if the requested classroom exist.

        $classrooms = Classroom::all();
        $isClassroomExist = 0;
        
        foreach($classrooms as $classroom) {
            if ($request->access_code == $classroom->raw_access_code) {
                $isClassroomExist = 1;
            }
        }

        // check if the requested classroom is not duplication entry

        $classroom_registrars = ClassroomRegistrar::all();
        $duplicateEntry = 0;

        foreach($classroom_registrars as $classroom_registrar) {
            if ($classroom_registrar->registrar_id == auth()->user()->id && $request->access_code == $classroom_registrar->raw_access_code) {
                $duplicateEntry = 1;
            }
        }

        // store the data

        if($isClassroomExist == 1 && $duplicateEntry == 0) {
            $classrooms = Classroom::all();
            $validatedData = $request->validate([
                "access_code" => "required|min:8|max:8"
            ]);
            
            foreach($classrooms as $classroom) {
                if ($request->access_code == $classroom->raw_access_code) {
                    $validatedData["raw_access_code"] = $classroom->raw_access_code;
                    $validatedData["access_code"] = $classroom->access_code;
                    $validatedData["name"] = $classroom->name;
                    $validatedData["slug"] = $classroom->slug;
                    $validatedData["description"] = $classroom->description;
                    $validatedData["creator_id"] = $classroom->creator_id;
                    $validatedData["creator_name"] = $classroom->creator_name;
                    $validatedData["registrar_id"] = auth()->user()->id;
                    $validatedData["registrar_name"] = auth()->user()->name;
                }
            }
            
            ClassroomRegistrar::create($validatedData);
            return redirect("/c")->with("success", "You joined a new class !");
        }
        return redirect("/c")->with("failed", "Classroom not found !");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy(Request $request, $registrar_id)
    {
        $specified_registrar = ClassroomRegistrar::where("access_code", $request->classroom_access_code)->where("registrar_id", $registrar_id)->get();
        
        ClassroomRegistrar::destroy($specified_registrar);

        return redirect("/c");
    }
}
