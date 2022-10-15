<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $table = 'courses';
    protected $fillable = [
        'name',
        'certificate',
        'thumbnail',
        'type',
        'status',
        'price',
        'level',
        'description',
        'mentor_id'
    ];

    // mendapatkan data dari model mentors
    public function mentor()
    {
        return $this->belongsTo('App\Mentor');
    }

    // mendapatkan dari chapters
    public function chapters()
    {
        return $this->hasMany('App\Chapter')->orderBy('id', 'ASC');
    }

    public function images()
    {
        return $this->hasMany('App\ImageCourse')->orderBy('id', 'DESC');
    }
}
