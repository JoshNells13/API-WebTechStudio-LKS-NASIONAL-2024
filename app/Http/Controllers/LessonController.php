<?php

namespace App\Http\Controllers;

use App\Models\CompletedLesson;
use App\Models\Lesson;
use App\Models\LessonContent;
use App\Models\Option;
use App\Models\User;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function AddLesson(Request $request)
    {

        $checkuser = User::where('username', $request->user()->username)->first();

        if ($checkuser) {
            return response([
                "status" => "insufficient_permissions",
                "message" => "Access forbidden"
            ], 403);
        }




        $validated = $request->validate([
            'name' => 'required|string',
            'set_id' => 'required|exists:sets,id',
            'contents' => 'required|array|min:1',

            'contents.*.type' => 'required|in:learn,quiz',
            'contents.*.content' => 'required|string|min:1',

            'contents.*.options' => 'required_if:contents.*.type,quiz|array',
            'contents.*.options.*.option_text' => 'required_if:contents.*.type,quiz|string',
            'contents.*.options.*.is_correct' => 'required_if:contents.*.type,quiz|boolean'
        ]);



        $lastLesson = Lesson::max('order') ?? 0;


        $Lesson = Lesson::create([
            'name' => $request->name,
            'set_id' => $request->set_id,
            'order' => $lastLesson + 1
        ]);

        $Lastcontentorder = LessonContent::max('order') ?? 0;

        foreach ($request->contents as $content) {
            $lessonContent = LessonContent::create([
                'lesson_id' => $Lesson->id,
                'type' => $content['type'],
                'content' => $content['content'],
                'order' => $Lastcontentorder + 1
            ]);

            if ($content['type'] === 'quiz' && isset($content['options'])) {
                foreach ($content['options'] as $option) {
                    Option::create([
                        'lesson_content_id' => $lessonContent->id,
                        'option_text' => $option['option_text'],
                        'is_correct' => $option['is_correct'],
                    ]);
                }
            }
        }



        return response([
            'status' => 'success',
            'message' => 'Lesson successfully added',
            'data' => [
                'name' => $Lesson->name,
                'order' => $Lesson->order,
                'id' => $Lesson->id
            ]
        ], 201);
    }



    public function CompletedLesson(Request $request, $id)
    {
        $Lesson = Lesson::where('id', $id)->first();

        CompletedLesson::create([
            'user_id' => $request->user()->id,
            'lesson_id' => $Lesson->id
        ]);


        return response([
            "status" => "success",
            "message" => "Lesson successfully completed"

        ],201);
    }

    public function CheckLesson(Request $request, $idlesson,$idlessoncontent) {
        $request->validate([
            'option_id' => 'required'
        ]);


        $Option = Option::where('id', $request->option_id)->first();


        if(!$Option){
            return response([
                'message' => 'Option Not Found'
            ],404);
        }

        $LessonContent = LessonContent::where('id', $idlessoncontent)->where('id', $idlesson)->first();

        if(!$LessonContent){
            return response([
                'message' => 'Lesson Content Not Found'
            ],404);
        }

        if($Option->lesson_content_id !== $LessonContent->id){
            return response([
                'message' => 'Invalid Option'
            ],400);
        }



        return response([
            'status' => 'success',
            'message' => 'Check answer success',
            'data' =>[
                'question' => $LessonContent->content,
                'user_answer' => $Option->option_text,
                'is_correct' => $Option->is_correct
            ]
        ],200);

    }

    public function DeleteLesson(Request $request, $id)
    {

        $checkuser = User::where('username', $request->user()->username)->first();

        if ($checkuser) {
            return response([
                "status" => "insufficient_permissions",
                "message" => "Access forbidden"
            ], 403);
        }



        $Lesson = Lesson::find($id);

        if (!$Lesson) {
            return response([
                "status" => "not_found",
                "message"  => "Resource not found"
            ], 404);
        }

        $Lesson->delete();

        return response([
            "status" => "success",
            "message" => "Lesson successfully deleted"
        ], 200);
    }
}
