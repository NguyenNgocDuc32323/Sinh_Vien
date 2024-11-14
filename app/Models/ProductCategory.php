<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_category';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'category_id',
    ];

    /**
     * Get the product that owns the product-category relationship.
     */
    public function products()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    /**
     * Get the category that owns the product-category relationship.
     */
    public function categories()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
}
