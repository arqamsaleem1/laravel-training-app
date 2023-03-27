<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonSection extends Model
{
    use HasFactory;

    public function lessons()
    {
        return $this->hasMany("App\Models\Lesson");
    }
}