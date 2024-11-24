<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'subject_id',
        'score',
        'exam_type_id',
        'semester_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // Định nghĩa mối quan hệ với ExamType
    public function exam_type()
    {
        return $this->belongsTo(ExamType::class, 'exam_type_id'); // 'exam_type_id' là khóa ngoại trong bảng Score
    }

    // Định nghĩa mối quan hệ với Semester
    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id'); // 'semester_id' là khóa ngoại trong bảng Score
    }

}
