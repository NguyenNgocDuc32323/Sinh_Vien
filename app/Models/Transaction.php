<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $fillable = [
        'user_id',
        'order_id',
        'code',
        'amount',
        'payment_method',
        'status',
        'description',
        'admin_check'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }

}
