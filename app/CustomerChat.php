<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerChat extends Model
{
    protected $fillable = [
    	'contact_us_id',
		'sender_id',
		'receiver_id',
		'message',
        'is_admin',
    ];

    public function contactRel() {
    	return $this->belongsTo(ContactUs::class, 'contact_us_id');
    }

    public function senderRel() {
    	return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiverRel() {
    	return $this->belongsTo(User::class, 'receiver_id');
    }
}
