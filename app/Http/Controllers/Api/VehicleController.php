<?php

namespace App\Http\Controllers\Api;

use App\Basecode\Classes\Repositories\VehicleRepository as Repository;
use App\Basecode\Classes\Permissions\Permission as Permission;
use App\Basecode\Classes\Transformers\VehicleTrans;
use App\Basecode\Classes\Transformers\VehicleLocationLogTrans;
use App\User;
use App\VehicleLocationLog;
use Auth;
use App\Booking;

class VehicleController extends ApiController
{
    public $repository, $permission;

    function __construct(Repository $repository, Permission $permission)
    {
        $this->repository = $repository;
        $this->permission = $permission;
    }

    public function store() {

        if(! $this->permission->create() ) return noAuth();

        if( $err = cvalidate( getValidationRules($this->repository->storeValidateRules)) ) return appError($err->first());

        if(auth()->user()->type != User::VENDOR) appError('Invalid User.');

        $attrs = $this->repository->getAttrs();

        $attrs['user_id'] = auth()->user()->id;

        $model = $this->repository->save($attrs);

        return appModelData($this->repository->parseModel($model),$this->repository->create_msg);

    }

    public function update() {
        
        $rules = [
            'vehicle_id'  => 'required|exists:vehicles,id',
            'start_city'  => 'required|exists:cities,id',
            'start_date'  => 'required'
        ];

        if( $err = cvalidate( $rules ) )return appError($err->first());

        if(auth()->user()->type != User::VENDOR) appError('Invalid User.');



        $model = $this->repository->find(\request('vehicle_id'));

        if(!$model) return appError('Bad request');

        if($val = \request('start_state')) $model->start_state = $val;

        $model->start_city = \request('start_city');
        $model->start_date = date('Y-m-d', strtotime(\request('start_date')));

        if($val = \request('end_date')) {
            $model->end_date = date('Y-m-d', strtotime($val));
        } else {
            $model->end_date = date('Y-m-d');
        }

        if($val = \request('end_cities')) $model->end_cities = $val;

        $model->save();
        
        $this->repository->saveLocationLogs($model);

        return appModelData([], 'Successfully set location');    
    }
    
    public function vehicleList() {
    	$collection = $this->repository->getCollection()
            ->where('user_id', auth()->user()->id)
            ->get();

        return appData($this->repository->parseCollection($collection));
    }

    public function availableVehicleList() {
        $collection = $this->repository->getCollection()
            ->where('user_id', auth()->user()->id)
            ->whereDate('start_date', '<=', date('Y-m-d'))
            ->whereDate('end_date', '>=', date('Y-m-d'))
            ->get();

        return appData($this->repository->parseCollection($collection));
    }

    public function availablePastVehicleList() {
        $collection = VehicleLocationLog::where('user_id', auth()->user()->id)
            ->whereDate('end_date', '<', date('Y-m-d'))
            ->groupBy('vehicle_id')
            ->get();

        return appData((new VehicleLocationLogTrans)->parseCollection($collection));
    }

    // vehicle list against booking

    public function vehiclesAgainstBooking() {

        $rules = [
            'booking_id' => 'required|exists:bookings,id'
        ];

        if( $err = cvalidate( $rules ) )return appError($err->first());

        $booking = Booking::find(\request('booking_id'));

        if(!$booking) return appError('Bad Request.');

        $collection = $this->repository->getCollection()
            ->where('start_city', $booking->city_id)
            ->get();

        return appData($this->repository->checkVehicleAgainstBooking($collection, $booking));
    } 
}
