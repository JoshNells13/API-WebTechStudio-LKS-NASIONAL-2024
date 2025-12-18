<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use App\Models\Course;
use App\Models\Enrollmennt;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function AddCourse(Request $request)
    {
        $checkuser = User::where('username', $request->user()->username)->first();


        if ($checkuser) {
            return response([
                "status" => "insufficient_permissions",
                "message" => "Access forbidden"
            ], 403);
        }

        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'slug' => 'required|unique:courses,slug'
        ]);

        $Courses = Course::create([
            'name' => $request->name,
            'description' => $request->description,
            'slug' => $request->slug
        ]);

        return response([
            'status' => 'success',
            'message' => 'Course successfully added',
            'data' => [
                'name' => $Courses->name,
                'description' => $Courses->description,
                'slug' => $Courses->slug,
                'updated_at' => $Courses->updated_at,
                'created_at' => $Courses->created_at,
                'id' => $Courses->id,
            ]
        ], 201);
    }

    public function EditCourse(Request $request, $slug)
    {

        $checkuser = User::where('username', $request->user()->username)->first();

        if ($checkuser) {
            return response([
                "status" => "insufficient_permissions",
                "message" => "Access forbidden"
            ], 403);
        }



        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'is_publised' => 'nullable|boolean'
        ]);


        $Courses = Course::where('slug', $slug)->first();

        if (!$Courses) {
            return response([
                'status' => 'not_found',
                'message' => 'Resource not found',
            ], 404);
        }

        $Courses->name = $request->name;
        $Courses->description = $request->description;
        $Courses->is_publised = $request->boolean('is_publised');

        $Courses->save();

        return response([
            'status' => 'success',
            'message' => 'Course successfully updated',
            'data' => [
                'id' => $Courses->id,
                'name' => $Courses->name,
                'slug' => $Courses->slug,
                'description' => $Courses->description,
                'is_published' => $Courses->is_publised,
                'created_at' => $Courses->created_at,
                'updated_at' => $Courses->updated_at
            ]
        ]);
    }


    public function DeleteCourse(Request $request, $slug)
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
                'status' => 'not found',
                'message' => 'Resource not found'
            ], 404);
        }


        $Courses->delete();

        return response([
            "status" => "success",
            "message" => "Course successfully deleted"
        ], 200);
    }



    public function GetAllCourses(Request $request)
    {
        $courses = Course::where('is_publised', true)->get();

        return response([
            'status' => 'success',
            'message' => 'Courses retrieved successfully',
            'data' => [
                'courses' => $courses
            ]
        ]);
    }

    

    public function GetDetailCourses(Request $request, $slug)
    {
        $courses = Course::where('slug', $slug)->first();


        if (!$courses) {
            return response([
                'message' => 'Course Not Found'
            ]);
        }

        $courses->load('Set.Lesson');

        return response([
            'status' => 'success',
            'message' => 'Course details retrieved successfully',
            'data' => [
                'id' => $courses->id,
                'name' => $courses->name,
                'slug' => $courses->slug,
                'description' => $courses->description,
                'is_publised' => $courses->is_publised,
                'created_at' => $courses->created_at,
                'updated_at' => $courses->updated_at,
                'sets' => $courses->Set->map(function ($set) {
                    return [
                        'id' => $set->id,
                        'name' => $set->name,
                        'order' => $set->order,
                        'lesson' => $set->Lesson
                    ];
                })
            ]
        ], 200);
    }
}
