<?php

namespace  App\Basecode\Classes\Repositories;

use App\DeviceToken;

class UserRepository extends Repository {

    public $model = '\App\User';

    public $viewIndex = 'admin.users.index';
    public $viewCreate = 'admin.users.create';
    public $viewEdit = 'admin.users.edit';
    public $viewShow = 'admin.users.show';

    public $storeValidateRules = [
        'mobile_no' => 'required|numeric|unique:users,mobile_no',
    ];

    public $updateValidateRules = [
        'name'      => 'required',
        'email'     => 'required|email|unique:users,email',
        'mobile_no' => 'required|numeric|unique:users,mobile_no',
        'aadhar'    => 'required|unique:users,aadhar',
        'pan'       => 'required|unique:users,pan',
        'password'  => 'required',
    ];

    public function updateDeviceToken($userId) {

        if (! request('device_id') ) return;

        $model = DeviceToken::where('device_id', request('device_id'))->where('user_id', $userId)->first();
        
        if(!$model) $model = new DeviceToken;

        $model->fill(request()->all());
        $model->user_id = $userId;
        $model->save();
    }


    public function save( $attrs ) {

        $attrs = $this->getValueArray($attrs);

        if( $pass = request('password') ) {
            $attrs['password'] = bcrypt($pass);
        } elseif( array_key_exists('password', $attrs) ) {
            unset($attrs['password']);
        }

        $model = new $this->model;
        $model->fill($attrs);
        $model->save();
        return $model;
    }

    public function update($model, $attrs = null) {
        if(! $attrs ) $attrs = $this->getAttrs();

        if( $pass = request('password') ) {
            $attrs['password'] = bcrypt($pass);
        } elseif( array_key_exists('password', $attrs) ) {
            unset($attrs['password']);
        }
        
        $model->fill($attrs);
        $model->update();

        return $model;
    }


    public function getVehicleStartCityList() {
        $collection = $this->vehicleCollection();
        
        $cities = [];
        
        foreach ($collection as $model) {
            $cities[] = $model->start_city;
        }
        return $cities;
        
    } 

    public function getVehicleEndCityList() {
        $collection = $this->vehicleCollection();
        
        $cities = [];
        
        foreach ($collection as $model) {
            
            $startCityModel = $model->locationLogRel()->latest()->first();
            
            if($startCityModel) {
                
                $cities = array_unique(array_merge($cities, $startCityModel->endCitiesRel()->pluck('cities.id')->toArray()));
            }
        }

        return $cities;
    }

    public function vehicleCollection () {
        $user = auth()->user();
        $collection = $user->vehiclesRel;

        return $collection;
    }
}