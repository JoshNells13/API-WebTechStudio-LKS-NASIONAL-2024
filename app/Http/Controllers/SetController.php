<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Set;
use App\Models\User;
use Illuminate\Http\Request;

class SetController extends Controller
{
    public function AddSet(Request $request, $slug)
    {

        $checkuser = User::where('username', $request->user()->username)->first();

        if ($checkuser) {
            return response([
                "status" => "insufficient_permissions",
                "message" => "Access forbidden"
            ], 403);
        }



        $Courses = Course::where('slug', $slug)->first();

        if (!$Courses) {
            return response([
                'message' => 'Course not found'
            ]);
        }

        $request->validate([
            'name' => 'required'
        ]);

        $lastSet = $Courses->Set()->max('order') ?? 0;


        $Set = Set::create([
            'name' => $request->name,
            'course_id' => $Courses->id,
            'order' => $lastSet + 1
        ]);

        return response([
            'status' => 'success',
            'message' => 'Set successfully added',
            'data' => [
                'name' => $Set->name,
                'order' => $Set->order,
                'id' => $Set->id
            ]
        ],201);
    }

    public function DeleteSet(Request $request, $slug, $idset) {

        $checkuser = User::where('username', $request->user()->username)->first();

        if ($checkuser) {
            return response([
                "status" => "insufficient_permissions",
                "message" => "Access forbidden"
            ], 403);
        }



        $Courses = Course::where('slug', $slug)->first();

        if(!$Courses){
            return response([
                'message' => 'Course Not Found'
            ]);
        }


        $set = Set::where('id', $idset)->where('course_id', $Courses->id)->first();

        if(!$set){
            return response([
                'message' => 'Set Not Found'
            ]);
        }

        $set->delete();


        return response([
            "status"=> "success",
            "message"=> "Set successfully deleted"
        ],200);
    }
}
