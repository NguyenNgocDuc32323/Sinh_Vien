<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamType extends Model
{
    use HasFactory;
    protected $table = 'exam_types';
    protected $fillable = [
        'name',
    ];
    public function scores(){
        return $this->hasMany(Score::class,'exam_type_id', 'id');
    }
}
