<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetail extends Model
{
    protected $table = 'order_details'; // Đặt tên bảng đúng với tên bảng trong cơ sở dữ liệu

    protected $fillable = [
        'order_id', 'product_id', 'quantity', 'price',
        'product_name', 'product_image', 'color', 'size'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
