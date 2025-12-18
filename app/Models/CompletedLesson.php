<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Sanctum\HasApiTokens;

class CompletedLesson extends Model
{
    use HasApiTokens,HasFactory;

    protected $fillable = ['user_id','lesson_id'];

    public function User():BelongsTo{
        return $this->belongsTo(User::class,'user_id');
    }

    public function Lesson(){
        return $this->belongsTo(Lesson::class,'lesson_id');
    }
}
