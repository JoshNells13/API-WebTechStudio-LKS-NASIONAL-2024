<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class Set extends Model
{
    use HasFactory,HasApiTokens;

    protected $fillable = ['name','course_id','order'];

    public function Course():BelongsTo{
        return $this->belongsTo(Course::class,'course_id');
    }

    public function Lesson():HasMany{
        return $this->hasMany(Lesson::class,'set_id');
    }
}
