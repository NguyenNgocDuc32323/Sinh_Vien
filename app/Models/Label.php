<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $table = 'labels';

    protected $fillable = [
        'name'
    ];

    public function products(){
        return $this->belongsToMany(Product::class, 'products','product_id');
    }
}
