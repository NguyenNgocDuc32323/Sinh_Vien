<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductColor extends Pivot
{
    protected $table = 'product_color';

    protected $fillable = [
        'color_id', 'product_id'
    ];

    /**
     * Get the color that owns the product-color relationship.
     */
    public function colors()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }

    /**
     * Get the product that owns the product-color relationship.
     */
    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
