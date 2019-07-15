<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    protected $fillable = [
    	'user_id',
    	'title',
        'message',
        'booking_id',
        'reply',
        'status',
    ];

    protected $table = "contact_uses";

    const PENDING_RESOLUTION = 1;
    const CUSTOMER_ACTION_PENDING = 2;
    const PENDING_ADMIN_REPLY = 3;
    const ISSUE_RESOLVED = 4;
    const CLOSED = 5; 

    public function bookigRel() {
    	return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function userRel() {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function queriesRel() {
        return $this->hasMany(CustomerChat::class, 'contact_us_id');
    }
} 
