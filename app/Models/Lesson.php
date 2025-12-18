<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class Lesson extends Model
{
    use HasFactory,HasApiTokens;

    protected $fillable = ['set_id','name','order'];

    public function Set():BelongsTo{
        return $this->belongsTo(Set::class,'set_id');
    }

    public function CompletedLesson():HasMany{
        return $this->hasMany(CompletedLesson::class,'lesson_id');
    }


    public function LessonContent():HasMany{
        return $this->hasMany(LessonContent::class,'lesson_id');
    }
}
