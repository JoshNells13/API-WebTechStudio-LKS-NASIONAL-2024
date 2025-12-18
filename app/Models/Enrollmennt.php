<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Sanctum\HasApiTokens;

class Enrollmennt extends Model
{
    use HasApiTokens,HasFactory;

    protected $fillable = ['user_id','course_id'];

    public function User():BelongsTo{
        return $this->belongsTo(User::class,'user_id');
    }

    public function Course():BelongsTo{
        return $this->belongsTo(Course::class,'course_id');
    }
}
