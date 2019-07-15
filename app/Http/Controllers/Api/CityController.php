<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Basecode\Classes\Transformers\BookingTrans;

class CityController extends Controller
{
    

    public function index() {

    	$collection = new \App\City;

    	$stateIds = \App\State::where('country_id', 101)->pluck('id')->toArray();

    	if( $val = request('title') ) $collection = $collection->where('title', 'like', '%'. $val. '%');

        $collection = $collection->orderBy('title');

        $collection = $collection->whereIn('state_id', $stateIds)->take(30)->get();

    	$collection = ( new BookingTrans )->parseCityCollection($collection);

    	return appData($collection);
    }

    public function stateList() {
    	
    	$collection = new \App\State;

        if( $val = request('title') ) $collection = $collection->where('title', 'like', '%'. $val. '%');

        $collection = $collection->where('country_id', 101)->orderBy('title')->get(); 

    	$collection = ( new BookingTrans )->parseStateCollection($collection);

    	return appData($collection);
    }


}
