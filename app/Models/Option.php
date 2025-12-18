<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Sanctum\HasApiTokens;

class Option extends Model
{
    use HasApiTokens,HasFactory;

    protected $fillable = ['lesson_content_id','option_text','is_correct'];

    public function LessonContent():BelongsTo{
        return $this->belongsTo(LessonContent::class,'lesson_content_id');
    }

    
}
