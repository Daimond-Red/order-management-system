<?php

namespace App\Basecode\Classes\Repositories;

use App\City;
use App\ServiceableArea;
use App\Vehicle;

class VendorRepository extends Repository {

    public $model = '\App\User';

    public $viewIndex = 'admin.vendors.index';
    public $viewCreate = 'admin.vendors.create';
    public $viewEdit = 'admin.vendors.edit';
    public $viewShow = 'admin.vendors.show';

    public $storeValidateRules = [
        'name'          => 'required',
        'email'         => 'required|email|unique:users,email',
        'mobile_no'     => 'required|numeric|unique:users,mobile_no',
        'aadhar'        => 'required|unique:users,aadhar',
        'pan'           => 'required|unique:users,pan',
        'password'      => 'required',
        'company'       => 'required',
    ];

    public $updateValidateRules = [
        // 'name'    => 'required',
        // 'email'         => 'required',
    ];

    public function getCollection( $withFilters = true ) {
        $model = new $this->model;
        $model = $model->orderBy('created_at', 'desc')->where('type', \App\User::VENDOR);


        if( $withFilters ) {

            $whereLikefields = ['name',  'email', 'pan', 'company', 'gstin' ];

            foreach ($whereLikefields as $field) {
                if( $value = request($field) ) $model = $model->where($field, 'like', '%'.$value.'%');
            }

            if(  array_key_exists('status', request()->all()) && request('status') == 0 ) $model = $model->where('status', 0);
            if( request('status') == 1 ) $model = $model->where('status', 1);

        }

        return $model;
    }

    public function find( $id ) {
        $model = $this->model;
        $model = $model::find($id);
        if( $model->type != \App\User::VENDOR ) throw new  \Illuminate\Database\Eloquent\ModelNotFoundException;
        return $model;
    }

    public function save( $attrs ) {
        
        $attrs = $this->getValueArray($attrs);

        $model = new $this->model;
        $model->fill($attrs);

        $attrs['status'] = 0;
        
        if( isset($attrs['type']) ) $model->type = $attrs['type']; // it's needed
        
        $model->save();

        // if( $areas = request('areas') ) $model->areas()->sync(explode(',', $areas));

        return $model;

    }

    public function update($model, $attrs = null) {

        if(! $attrs ) $attrs = $this->getAttrs();

        $notify = false;

        if( $model->status != '1' ) $notify = true;

        if( $areas = request('areas') ) {
            $model->areas()->sync(explode(',', $areas));
        } elseif( (!$areas = request('areas')) && array_key_exists('areas', $attrs) ) {
            $model->areas()->sync([]);
        }

        $model->fill($attrs);
        $model->update();

        if((\request('status') && \request('status') == 1) && $notify) {
            
            $msg =  _t('account_activated_4');

            sendPushNotification($model->id, [
                'user_id'   => $model->id,
                'category'  => 'account_created',
                'body'      => $msg,
                'title'     => _t_title('account_activated_4')
            ]);
        }
        
        return $model;

    }

    public function getAttrs()
    {

        $attrs = request()->all();

        $attrs['type'] = \App\User::VENDOR;

        if( $pass = request('password') ) {
            $attrs['password'] = bcrypt($pass);
        } elseif( array_key_exists('password', $attrs) ) {
            unset($attrs['password']);
        }

        $uploads = ['image'];

        foreach ( $uploads as $upload ) {

            if( request()->hasFile($upload) ){
                $attrs[$upload] = self::upload_file($upload, 'vendors');
            } elseif( $attrs && count($attrs) && array_key_exists($upload, $attrs) ) {
                unset($attrs[$upload]);
            }
        }
        return $attrs;

    }

    public function getRatting($id){
        // $ids = \App\Driver::where('vendor_id', $id)->pluck('id')->toArray();
        $ratting = \App\ReviewRating::where('rated_id', $id)->avg('rating');
        return number_format($ratting, 1, '.', '');
    }

    public function parseModel($model)
    {
        $arr = [];

        $areas = [];
        foreach( $model->areas as $area ) {
            $areas[] = ['area_id' => $area->id, 'area_name' => $area->name, 'zipcode' => $area->zipcode];
        }

        $arr['vendor_id'] = (int)$this->prepare_field('id', $model);
        
        
        $arr['status'] = (string) $this->prepare_field('status', $model);
        $arr['created_at'] = (string)$this->prepare_field('created_at', $model);

        $areasCollection = $collection = [];

        $areas = $model->serviceableArea()->get(['base_state_id', 'drop_state_id']);

        $arr['serviceable_areas'] = $this->parseServiceableAreas($areas);

        return $arr;
    }

    public function parseServiceableAreas($areas, $withDropCityIds = false) {

        $areasCollection = $collection = [];

        foreach( $areas as $area ) $areasCollection[$area->base_state_id][] = $area->drop_state_id;

        foreach( $areasCollection as $baseStateId => $dropStateIds ) {

            $row = [
                'base_state_id'      => $baseStateId,
                'base_state_name'    => City::getStatesNames($baseStateId),
                'drop_state_name'    => City::getStatesNames($dropStateIds, true)
            ];

            if( $withDropCityIds ) $row['drop_state_id'] = $dropStateIds;
            $collection[] = $row;
        }

        return $collection;
    }

    public function isValidDriver($vendor_id, $driver_id) {

    }

    public function isValidVehicle($vendor_id, $driver_id) {

    }

    public function whereNearestVendors($orig_lat, $orig_lon, $distanceInMiles = 70) {

        return ServiceableArea::select('*', \DB::raw(" round( 3956 * 2 * ASIN(SQRT( POWER(SIN(($orig_lat - abs( lat)) * pi()/180 / 2),2) + COS($orig_lat * pi()/180 ) * COS( abs (lat) *  pi()/180) * POWER(SIN(($orig_lon - lng) *  pi()/180 / 2), 2) )), 1) as gDistance"))
            ->having('gDistance', '<=', $distanceInMiles)
            ;

    }

    public function getBasedOnBaseNDropCity( $baseCityId, $dropCityId, $vehicleTypeId = null, $addUserIds = null ) {

        $baseCity = City::where('id', $baseCityId)->first(); // must be valid
        $dropCity = City::where('id', $dropCityId)->first(); // must be valid

        if(! ($baseCity || $dropCity) ) return $this->getCollection()->whereIn('id', []);

        $userIds = ServiceableArea::where('base_state_id', $baseCity->state_id)
                        ->where('drop_state_id', $dropCity->state_id)
                        ->pluck('user_id')
                        ->toArray();

        if($vehicleTypeId) $userIds = Vehicle::whereIn('vendor_id', $userIds)->where('vehicle_type_id', $vehicleTypeId)->pluck('vendor_id')->toArray();
        if( $addUserIds ) $userIds = array_merge($userIds, $addUserIds);

        return $this->getCollection()->whereIn('id', $userIds);

    }

    public function updateServiceableAreas($userId, $baseStateId, $dropStateIds) {

        // where we will delete previous entries
        ServiceableArea::where('user_id', $userId)->where('base_state_id', $baseStateId)->delete();

        $arr = [];
        // and add new entries based on drop locations
        foreach( $dropStateIds as $dropStateId ) {

            $arr[] = [
                'user_id'           => $userId,
                'base_state_id'     => $baseStateId,
                'drop_state_id'     => $dropStateId,
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s')
            ];

        }

        ServiceableArea::insert($arr);

    }

}