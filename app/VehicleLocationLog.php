<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleLocationLog extends Model
{
    protected $fillable = [
    	'vehicle_id',
        'user_id',
    	'city_id',
    	'state_id',
    	'start_date',
    	'end_date'
    ];

    public function vehicleRel() {
    	return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function cityRel() {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function stateRel() {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function endCitiesRel() {
        return $this->belongsToMany(City::class, 'location_log_city', 'location_log_id', 'city_id');
    }
}
