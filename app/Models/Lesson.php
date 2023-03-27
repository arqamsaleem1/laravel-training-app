<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'course_id',
        'section_id',
        'slug',
        'description',
        'video',
    ];

    public function currentLessonSection()
    {
        return $this->belongsTo("App\Models\LessonSection");
    }
}
