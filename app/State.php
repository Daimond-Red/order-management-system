<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{

	public static $india_id = 101;
	
    public static function getStateIds($countryId = '101') {

    	return State::where('country_id', $countryId)->pluck('id')->toArray();
    }

    public static function getStates($countryId = '101') {

    	return State::where('country_id', $countryId)->pluck('title', 'id')->toArray();
    }
}
