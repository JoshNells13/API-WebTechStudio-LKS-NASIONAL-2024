<?php

namespace App\Http\Controllers;

use App\Models\CompletedLesson;
use App\Models\Course;
use App\Models\Enrollmennt;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function RegisterCourses(Request $request, $slug)
    {
        $Course = Course::where('slug', $slug)->first();

        if (!$Course) {
            return response([
                'message' => 'Course not Found'
            ], 401);
        }

        $checkcourse = Enrollmennt::where('user_id', $request->user()->id)->where('course_id', $Course->id)->exists();


        if ($checkcourse) {
            return response([
                "status" => "error",
                "message" => "The user is already registered for this course"
            ], 400);
        }

        Enrollmennt::create([
            'user_id' => $request->user()->id,
            'course_id' => $Course->id
        ]);


        return response([
            "status" => "success",
            "message" => "User registered successful"
        ], 201);
    }

    public function GetUserProgress(Request $request)
    {
        $UserID = $request->user()->id;

        $enrollment = Enrollmennt::where('user_id', $UserID)->with('course')->first();

        if (!$enrollment) {
            return response([
                "status" => "error",
                "message" => "User is not enrolled in any course"
            ], 404);
        }

        $course = $enrollment->course;

        $completedLessons = CompletedLesson::where('user_id', $UserID)->with('lesson')->get();

        // Format completed lessons
        $completed = $completedLessons->map(function ($item) {
            return [
                'id' => $item->lesson->id,
                'name' => $item->lesson->name,
                'order' => $item->lesson->order,
            ];
        });

        return response([
            "status" => "success",
            "message" => "User progress retrieved successfully",
            'data' => [
                'progress' => [
                    'course' => [
                        'id' => $course->id,
                        'name' => $course->name,
                        'slug' => $course->slug,
                        'description' => $course->description,
                        'is_published' => $course->is_published,
                        'created_at' => $course->created_at,
                        'updated_at' => $course->updated_at,
                    ],
                    'completed_lessons' => $completed
                ]
            ]
        ], 201);
    }
}
