<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Sanctum\HasApiTokens;

class LessonContent extends Model
{
    use HasApiTokens,HasFactory;

    protected $fillable = ['lesson_id','type','content','order'];

    public function Lesson():BelongsTo{
        return $this->belongsTo(Lesson::class,'lesson_id');
    }
}
