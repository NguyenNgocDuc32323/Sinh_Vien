<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $table = 'colors';

    protected $fillable = [
        'name', 'ratio_price'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_color', 'color_id', 'product_id')
                    ->withTimestamps();
    }
}
