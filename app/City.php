<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    

    public static function getCities() {

    	return City::whereIn('state_id', State::getStateIds())->take(30)->pluck('title', 'id')->toArray();
    }

    public function vehicleRel() {
        return $this->belongsToMany(Vehicle::class, 'vehicle_city', 'city_id', 'vehicle_id');
    }
}
