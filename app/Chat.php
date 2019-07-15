<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = [
    	'booking_id',
    	'customer_id',
    	'vendor_id'
    ];

    public function bookingRel() {
    	return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function customerRel() {
    	return $this->belongsTo(User::class, 'customer_id');
    }

    public function vendorRel() {
    	return $this->belongsTo(User::class, 'vendor_id');
    }

    public function chatRel() {
        return $this->hasMany(ChatLog::class, 'chat_id');
    }
}
