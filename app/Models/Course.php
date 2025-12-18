<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class Course extends Model
{
    use HasFactory,HasApiTokens;


    protected $fillable = ['name','slug','description','is_published'];


    public function Enrollmennt():HasMany{
        return $this->hasMany(Enrollmennt::class,'course_id');
    }

    public function Set():HasMany{
        return $this->hasMany(Set::class,'course_id');
    }

}
