<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingLog extends Model
{
    protected $fillable = [
    	'booking_id',
    	'customer_id',
    	'vendor_id',
    	'status',
    ];
}
