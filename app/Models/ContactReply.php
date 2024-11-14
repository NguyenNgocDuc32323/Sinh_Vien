<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactReply extends Model
{
    protected $fillable = [
        'contact_id', 'message',
    ];

    public function contacts()
    {
        return $this->belongsTo(Contact::class);
    }
}
