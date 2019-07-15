<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
    	'name',
        'user_id',
        'address',
        'mobile_no',
        'aadhar',
        'pan',
        'vehicle_type_id',
        'capacity',
        'no_of_tyres',
        'length',
        'breadth',
        'hieght',
        'vehicle_name',
        'vehicle_num',
        'permit_type',
        'expire_date',
        'fitness_validity',
        'insurance_validity',
        'is_verified',
        'city_id',
        'state_id',
        'postcode',
        'start_state',
        'start_city',
        'start_date',
        'end_date',
        'end_cities'
    ];

    const PERMIT_TYPE = [
    	'type_one' => 'Type One',
    	'type_two' => 'Type Two'
    ];

    const VERIFIED = 1;
    const SELF_VERIFIED = 2; 

    public function setExpireDateAttribute($value) {
        try{
            $this->attributes['expire_date'] = date('Y-m-d H:i:s', strtotime($value));
        } catch (\Exception $e) {

        }
    }

    public function setFitnessValidityAttribute($value) {
        try{
            $this->attributes['fitness_validity'] = date('Y-m-d H:i:s', strtotime($value));
        } catch (\Exception $e) {

        }
    }

    public function setInsuranceValidityAttribute($value) {
        try{
            $this->attributes['insurance_validity'] = date('Y-m-d H:i:s', strtotime($value));
        } catch (\Exception $e) {

        }
    }

    public function userRel() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function documentsRel () {
        return $this->hasMany(Document::class, 'vehicle_id');
    }

    public function vehicleTypeRel() {
        return $this->belongsTo(VehicleType::class, 'vehicle_type_id');
    }

    public function serviceAreaRel() {
        return $this->belongsToMany(City::class, 'vehicle_city', 'vehicle_id', 'city_id');
    }

    public function bookingVehicleRel() {
        return $this->hasMany(AssignVehicleDriver::class, 'vehicle_id');
    }

    public function cityRel() {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function stateRel() {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function startCityRel() {
        return $this->belongsTo(City::class, 'start_city');
    }

    public function startStateRel() {
        return $this->belongsTo(State::class, 'start_state');
    }

    public function permitRel() {
        return $this->belongsToMany(Permit::class, 'vehicle_permit', 'vehicle_id', 'permit_id');
    }

    public function locationLogRel() {
        return $this->hasMany(VehicleLocationLog::class, 'vehicle_id');
    }
}
