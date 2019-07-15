<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignVehicleDriver extends Model
{
    protected $fillable = [
    	'booking_id',
		'driver_id',
		'vehicle_id',
    ];

    public function bookingRel() {
    	return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function driverRel() {
    	return $this->belongsTo(User::class, 'driver_id');
    }

    public function vehicleRel() {
    	return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
}
