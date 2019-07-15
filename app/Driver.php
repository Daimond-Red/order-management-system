<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = [
    	'vendor_id',
    	'name',
    	'address',
    	'city_id',
    	'state_id',
    	'country_id',
    	'postcode',
    	'mobile_no',
    	'license_no',
    	'expire_date',
    	'dl_type',
    ];

    public function setExpireDateAttribute() {
        try{
            $this->attributes['expire_date'] = date('Y-m-d H:i:s', strtotime($value));
        } catch (\Exception $e) {

        }
    }
    
    public function vendorRel() {
    	return $this->belongsTo(User::class, 'vendor_id');
    }

    public function cityRel() {
    	return $this->belongsTo(City::class, 'city_id');
    }

    public function stateRel() {
    	return $this->belongsTo(State::class, 'state_id');
    }

    public function countryRel() {
    	return $this->belongsTo(Country::class, 'country_id');
    }

    // public function driverBookingsRel() {

    //     return $this->hasMany(AssignVehicleDriver::class, 'driver_id');
    // }
}
