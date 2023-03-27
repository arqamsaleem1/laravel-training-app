<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWithCourse extends Model
{
    use HasFactory;

    public function getCourse()
    {
        //return 'hello';
        return $this->belongsTo("App\Models\Course", 'id');
    }
    
    public function courses()
    {
        //return 'hello';
        return $this->belongsTo("App\Models\User", 'id');
    }
}
