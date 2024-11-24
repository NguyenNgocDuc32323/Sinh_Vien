<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    protected $table = 'teachers';
    protected $fillable = [
        'user_id',
        'salary',
        'subject_id',
        'status',
        'teacher_code'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
}
