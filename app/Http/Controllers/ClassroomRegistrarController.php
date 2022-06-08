<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\ClassroomRegistrar;
use Illuminate\Http\Request;

class ClassroomRegistrarController extends Controller
{
    public function store(Request $request) {
        // check if the requested classroom exist.
        
        $classrooms = Classroom::all();
        $isClassroomExist = 0;
        
        foreach($classrooms as $classroom) {
            if (password_verify($request["access_code"], $classroom->access_code)) {
                $isClassroomExist = 1;
            }
        }

        // check if the requested classroom is not duplication entry

        $classroom_registrars = ClassroomRegistrar::all();
        $duplicateEntry = 0;

        foreach($classroom_registrars as $classroom_registrar) {
            if ($classroom_registrar->registrar_id == auth()->user()->id && password_verify($request["access_code"], $classroom->access_code)) {
                $duplicateEntry = 1;
            }
        }

        // store the data

        $classrooms = Classroom::all();

        if($isClassroomExist == 1 && $duplicateEntry == 0) {
            $validatedData = $request->validate([
                "access_code" => "required|min:8|max:8"
            ]);
            
            foreach($classrooms as $classroom) {
                if (password_verify($request["access_code"], $classroom->access_code)) {
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
}
