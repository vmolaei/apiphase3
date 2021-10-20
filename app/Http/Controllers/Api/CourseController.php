<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\Course;


class CourseController extends Controller
{
    //Course Enrollment Api --POST
    public function courseEnrollment(Request $request){
        //validation
        $request->validate([
            "title" =>"required",
            "description"=>"required",
            "total_videos"=>"required"
         ]);
        //create data
        $course = new Course();

        $course->user_id = auth()->user()->id;
        $course->title = $request->title;
        $course->description = $request->description;
        $course->total_videos = $request->total_videos;

        $course->save();

        //send response
        return response()->json([
            "status"=>1,
            "message"=>"Course enrolled successfully"

        ]);


    }
    //total course Api -GET
    public function totalCourses(){
        $id = auth()->user()->id;
        $courses = User::find($id)->courses;
        return response()->json([
            "status"=>1,
            "message"=>"total courses enrolled",
            "data"=>$courses
        ]);

    }
    //delete Course Api --GET
    public function deleteCourse($id){
        $user_id = auth()->user()->id;
        if(Course::where([
            "id"=>$id,
            "user_id"=>$user_id
        ])->exists()){
            $course=Course::find($id);
            $course->delete();
            return response()->json([
                "status"=>1,
                "message"=>"course deleted successfully"
            ]);

        }else{
            return response()->json([
                "status"=>0,
                "message"=>"course not found"
            ]);
        }

    }
}
