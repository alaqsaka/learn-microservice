<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyCourse extends Model
{
    use HasFactory;

    protected $table = 'my_courses';
    protected $fillable = [
        'course_id',
        'user_id'
    ];

    // method digunakan untuk mengambil data course
    public function course()
    {
        return $this->belongsTo('App\Course');
    }
}
