<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name','email', 'phone', 'title', 'content', 'status'
    ];

    protected $attributes = [
        'status' => 'unread',
    ];
    public function contactReplies(){
        return $this->hasMany(ContactReply::class);
    }
}
