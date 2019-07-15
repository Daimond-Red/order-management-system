<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingBid extends Model
{
    protected $fillable = [
    	'booking_id',
    	'customer_id',
    	'vendor_id',
    	'status',
    	'amount',
    ];

    const ACCEPTED = 2;
    const CANCEL = 3;

    public function bookingRel() {
    	return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function vendorRel() {
    	return $this->belongsTo(User::class, 'vendor_id');
    }
}
