<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products'; // Đặt tên bảng products

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'quantity',
        'image',
        'images',
        'price',
        'order_number',
        'label_id',
    ];

    /**
     * Get the categories that belong to the product.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category', 'product_id', 'category_id');
    }


    /**
     * Get the label associated with the product.
     */

    /**
     * Get the tags associated with the product.
     */
    /**
     * Get the images for the product.
     */

    /**
     * Get the flash sales associated with the product.
     */

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_size', 'product_id', 'size_id')
                    ->withTimestamps();
    }
    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_color', 'product_id', 'color_id')
                    ->withTimestamps();
    }
    public function label()
    {
        return $this->belongsTo(Label::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product')
            ->withPivot('quantity', 'price', 'discount_amount', 'product_name', 'product_image', 'color', 'size');
    }
}
