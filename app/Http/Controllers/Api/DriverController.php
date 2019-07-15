<?php

namespace App\Http\Controllers\Api;

use App\Basecode\Classes\Repositories\DriverRepository as Repository;
use App\Basecode\Classes\Permissions\Permission as Permission;
use App\Basecode\Classes\Transformers\DriverTrans;
use App\Basecode\Classes\Transformers\BookingTrans;
use App\User;

class DriverController extends ApiController
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

        $rules = [
            'city_id' => 'required',
            'state_id' => 'required',
            'postcode' => 'required',
            'dl_type' => 'required'
        ]; 
        
        if( $err = cvalidate( $rules ) ) return appError($err->first());

        if(auth()->user()->type != User::VENDOR) appError('Invalid User.');

        $model = $this->repository->save($this->repository->getAttrs());

        return appModelData((new DriverTrans)->parseModel($model), $this->repository->create_msg);

    }

    public function driverList() {
        
        if(auth()->user()->type != User::VENDOR) appError('Invalid User.');


        // driver list check where he/she available or not.
        $collection = User::where('type', User::DRIVER)
            ->where('vendor_id', auth()->user()->id)
            ->get();

        return appData((new DriverTrans)->parseCollection($collection));
    }

    
    public function currentPosition() {
        
        $rules = [
            'current_lat' => 'required',
            'current_lng' => 'required',
        ];

        if( $err = cvalidate( $rules ) ) return appError($err->first());

        $attrs = [
            'current_lat' => \request('current_lat'),
            'current_lng' => \request('current_lng')
        ];

        $model = $this->repository->getModel()->where('id', auth()->user()->id)->first();

        if(!$model) return appError('Invalid User');

        $model = $this->repository->update($model, $attrs);

        return appModelData((new DriverTrans)->parseModel($model));
    }

    public function driverBookings() {

        $collection = auth()->user()->driverBookingsRel()->whereDate('created_at', '>=', date('Y-m-d') )->get();
        $data = [];
        if(count($collection)) {
            foreach ($collection as $model) {
                $data['bookings'][] = (new BookingTrans)->parseModel(optional($model->bookingRel));
            }
        }

        return appData($data);
    }
}
