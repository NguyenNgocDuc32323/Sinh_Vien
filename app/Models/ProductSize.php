<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductSize extends Pivot
{
    protected $table = 'product_size';

    protected $fillable = [
        'size_id', 'product_id'
    ];
    public function sizes(){
        return $this->belongsTo(Size::class,'size_id');
    }
    public function products(){
        return $this->belongsTo(Product::class,'product_id');
    }
}
