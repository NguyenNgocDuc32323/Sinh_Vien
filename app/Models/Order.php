<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    protected $fillable = [
        'code',
        'user_id',
        'shipping_method',
        'status',
        'amount',
        'discount_amount',
        'shipping_amount',
        'sub_total',
        'is_finished',
        'payment_id',
        'address',
        'description',
    ];

    protected $dates = [
        'completed_at'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function payments(): BelongsToMany
    {
        return $this->belongsToMany(Payment::class, 'order_payments', 'order_id', 'payment_id')
                    ->withTimestamps();
    }

    public function order_details(){
        return $this->hasMany(OrderDetail::class,'');
    }
    public function transaction(){
        return $this->hasOne(Transaction::class);
    }
}
