<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingAllocate extends Model
{
    protected $fillable = [
    	'booking_id',
		'vendor_id',
		'status',
    ];

    public function bookingRel() {
    	return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function vendorRel() {
    	return $this->belongsTo(User::class, 'vendor_id');
    }
}
