<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\ClassroomRegistrar;
use App\Models\Forum;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        return view("home"); 
    }
    
    public function classrooms() {
        
        $classrooms = ClassroomRegistrar::search(request("search"))->where("registrar_id", auth()->user()->id)->get();

    
        return view("classrooms", compact("classrooms"));
    }

    public function classroom(Classroom $classroom) {
        
        // user validation

        $validateRegistrar = ClassroomRegistrar::where("access_code", $classroom->access_code)->where("registrar_id", auth()->user()->id)->count();
        // $validateCreator = Classroom::where("access_code", $classroom->access_code)->where("creator_id", auth()->user()->id)->count();
        
        if($validateRegistrar == 0) {
            abort(403);
        }
        
        // show forums data

        $forums = Forum::where("classroom_access_code", $classroom->access_code)->get();

        return view("classroom", [
            "classroomName" => $classroom->name,
            "classroomDescription" => $classroom->description,
            "forums" => $forums
        ]);
    }
}
