<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'student_code',
        'class_id',
        'course_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function class()
    {
        return $this->belongsTo(Classes::class); // Mối quan hệ với lớp học
    }

    public function course()
    {
        return $this->belongsTo(Course::class); // Mối quan hệ với khóa học
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
    }
}
