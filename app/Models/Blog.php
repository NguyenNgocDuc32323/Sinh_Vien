<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class Blog extends Model
{
    protected $table = 'blogs';

    protected $fillable = [
        'title','content', 'image', 'name','category_id'
    ];
    use HasFactory;
    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }
}
