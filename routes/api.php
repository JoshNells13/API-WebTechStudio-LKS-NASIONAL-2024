<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\SetController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');





    Route::post('register',[AuthController::class,'Register']);
    Route::post('login',[AuthController::class,'Login']);

    Route::middleware('auth:sanctum')->group(function(){
        Route::post('logout',[AuthController::class,'Logout']);

        Route::controller(CourseController::class)->group(function(){
            Route::post('courses','AddCourse');
            Route::put('courses/{slug}','EditCourse');
            Route::delete('courses/{slug}','DeleteCourse');

            Route::get('courses','GetAllCourses');
            Route::get('courses/{slug}','GetDetailCourses');
        });

        Route::controller(SetController::class)->group(function(){
            Route::post('courses/{courses}/sets','AddSet');
            Route::delete('courses/{courses}/sets/{id}','DeleteSet');
        });

        Route::controller(LessonController::class)->group(function(){
            Route::post('lessons','AddLesson');
            Route::delete('lessons/{id}','DeleteLesson');
            Route::post('lessons/{id}/content/{idcontent}/check','CheckLesson');
            Route::put('lessons/{id}/complete','UpdateLesson');
        });

        Route::controller(UserController::class)->group(function(){
            Route::post('courses/{slug}/register','RegisterCourses');
            Route::get('users/progress','GetUserProgress');
        });


    });


