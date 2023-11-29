<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

use function Laravel\Prompts\error;

class CourseController extends Controller
{
    function createCourse(Request $request){
        // based on how the request was sent to the backend
        $request->validate([
            'name' => 'required', // the name is a MUST to be there.
            'amount'=> 'required',
        ]);
         
        // $course object is taking a function from the extended Controller class. We
        // we are taking the model
        $course = Course::create([
            'name' => $request->name, // the left side 'name'represents what comes from the db and on the right what is from the user
            'amount'=> $request->amount,
        ]);
//Go inside the course table, in the 
        $courseCheck = Course::find($course->id);
    

        if($courseCheck){
            return response()->json($courseCheck);
        }
    }

    function readAllCourses(){
        $courses = Course::all();

        if($courses){
            return response()->json($courses);
        }
        else{
            return response('No Course Was Found');
        }
    }

    function readCourse($id){
        try{
            $course = Course::findorfail($id);
            return response()->json($course);
        }
        catch(\Exception $e){
            return response()->json([
                'error'=>'Course not found'
            ], 404);
        }
    }

    function updateCourse(Request $request, $id){
        $request->validate([
            'name' => 'required'
        ]);

        $course = Course::find($id);

        if($course){
            $course->name = $request->name;

            $course->save();
            return response()->json($course);
        }
        else{
            return response("Update unsuccessful, no such course exists");
        }
    }

    function deleteCourse($id){
        try{
            $course = Course::findorfail($id);
            if($course){
                $deletedCourse = $course;
    
                $course->delete();
                return response()->json($deletedCourse);
            }
            else{
                return response("Delete unsuccessful, no such course exits");
            }
        }
        catch(\Exception $e){
            return response()->json([
                'error'=> 'Course not found!'
            ], 404);
        }
    }

    
    function searchCourse($name){
        try{
            $course = Course::where('name', 'like', '%'.$name.'%')->get();
            if($course){
    
                return response()->json($course);
            }
            else{
                return response("No such matches");
            }
        }
        catch(\Exception $e){
            return response()->json([
                'error'=> 'Match not found!'
            ], 404);
        }
    }
}
