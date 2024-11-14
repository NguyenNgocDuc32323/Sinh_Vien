<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [ 'payment_method', 'payment_date'];

    protected $dates = [
        'payment_date',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
    public function orders()
    {
        return $this->belongsToMany(Payment::class, 'order_payments', 'order_id', 'payment_id')
                    ->withTimestamps();
    }
}
