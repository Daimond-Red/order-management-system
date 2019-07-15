<?php

namespace App\Basecode\Classes\Repositories;
use App\VehicleLocationLog;
use Auth;
use App\User;

class VehicleRepository extends Repository {

    public $model = '\App\Vehicle';

    public $viewIndex = 'admin.vehicles.index';
    public $viewCreate = 'admin.vehicles.create';
    public $viewEdit = 'admin.vehicles.edit';
    public $viewShow = 'admin.vehicles.show';

    public $storeValidateRules = [
        'vehicle_type_id' => 'required',
        'vehicle_name' => 'required',
        'capacity' => 'required',
        'no_of_tyres' => 'required',
        'length' => 'required',
        'breadth' => 'required',
        'hieght' => 'required',
        'permit_type' => 'required',
        'expire_date' => 'required|after:today',
        'fitness_validity' => 'required|after:today',
        'insurance_validity' => 'required|after:today',
    ];

    public $updateValidateRules = [

    ];

    public function save( $attrs ) {

        $attrs = $this->getValueArray($attrs);

        $model = new $this->model;
        $model->fill($attrs);
        $model->save();

        if(auth()->user()->type != User::SUPERADMIN) {
            if($val = \request('permits')) $model->permitRel()->sync(explode(',', $val));

            if($val = \request('cities') ) $model->serviceAreaRel()->sync(explode(',', $val));
        } else {
            if($val = \request('permits')) $model->permitRel()->sync( $val );

            if($val = \request('cities') ) $model->serviceAreaRel()->sync( $val );
        }

        return $model;
    }

    public function update($model, $attrs = null) {
        if(! $attrs ) $attrs = $this->getAttrs();
        $model->fill($attrs);
        $model->update();

        if(auth()->user()->type != User::SUPERADMIN) {
            if($val = \request('permits')) $model->permitRel()->sync(explode(',', $val));

            if($val = \request('cities') ) $model->serviceAreaRel()->sync(explode(',', $val));
        } else {
            if($val = \request('permits')) $model->permitRel()->sync( $val );

            if($val = \request('cities') ) $model->serviceAreaRel()->sync( $val );
        }
        
        return $model;
    }


    public function getAttrs()
    {
        $attrs = parent::getAttrs();

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

    public function parseModel($model) {

        $arr = [];

        $arr['id'] = (string) $this->prepare_field('id', $model);
        $arr['vendor_id'] = (string) $this->prepare_field('user_id', $model);
        $arr['vendor_name'] = (string) optional($model->userRel)->name;
        $arr['vehicle_type_id'] = (string) $this->prepare_field('vehicle_type_id', $model);

        $arr['vehicle_name'] = (string) $this->prepare_field('vehicle_name', $model);
        $arr['length'] = (string) $this->prepare_field('length', $model);
        $arr['breadth'] = (string) $this->prepare_field('breadth', $model);
        $arr['hieght'] = (string) $this->prepare_field('hieght', $model);
        $arr['permit_type'] = (string) $this->prepare_field('permit_type', $model);

        $arr['address'] = (string) $this->prepare_field('address', $model);
        $arr['no_of_tyres'] = (string) $this->prepare_field('no_of_tyres', $model);
        $arr['postcode'] = (string) $this->prepare_field('postcode', $model);
        $arr['mobile_no'] = (string) $this->prepare_field('mobile_no', $model);
        $arr['fitness_validity'] = (string) getDateValue($this->prepare_field('fitness_validity', $model));
        $arr['vehicle_num'] = (string) $this->prepare_field('vehicle_num', $model);
        $arr['capacity'] = (string) $this->prepare_field('capacity', $model);

        $arr['insurance_validity'] = (string) getDateValue($this->prepare_field('insurance_validity', $model));
        $arr['expire_date'] = (string) getDateValue($this->prepare_field('expire_date', $model));
        $arr['name'] = (string) $this->prepare_field('name', $model);
        $arr['aadhar'] = (string) $this->prepare_field('aadhar', $model);
        $arr['pan'] = (string) $this->prepare_field('pan', $model);

        $arr['state_name'] = (string) optional($model->stateRel)->title;
        
        $arr['city_name'] = (string) optional($model->cityRel)->title;

        $arr['vehicle_name'] = (string) $this->prepare_field('vehicle_name', $model);

        $arr['document_arr'] = $model->documentsRel()->get(['name', 'image', 'site']);

        $count = count($arr['document_arr']);

        if( $count ) {
            $arr['is_document_uploaded'] = true;
        } else {
            $arr['is_document_uploaded'] = false;
        }

        // $arr['noentrypermit'] = (string) $this->prepare_field('noentrypermit', $model);

        // $arr['reg_validity'] = (string) $this->prepare_field('reg_validity', $model);
        // $arr['insurance_validity'] = (string) $this->prepare_field('insurance_validity', $model);
        // $arr['vehicle_payload'] = (string) $this->prepare_field('vehicle_payload', $model);

        $arr['created_at'] = (string) $this->prepare_field('created_at', $model);

        $arr['vehicle_type'] = (string) optional($model->vehicleTypeRel)->title;
        $arr['is_verified'] = (int) $this->prepare_field('is_verified', $model);
        // if( isset($model->vehicle_type) && $model->vehicle_type ) $arr['vehicle_type'] = $this->vehicleTypeRepository->parseModel($model->vehicle_type);
        $arr['is_available'] = true;

        $bookingCollection = $model->bookingVehicleRel;

        foreach ($bookingCollection as $bookingModel) {
            $check = $bookingModel->bookingRel()->whereDate('start_date_time', "=", date('Y-m-d'))->first();
            if($check) $arr['is_available'] = false;
        }
        $arr['start_city']  = (string)optional($model->startCityRel)->title;
        $arr['start_state'] = (string)optional($model->startStateRel)->title;
        $arr['start_date']  = (string)$this->prepare_field('start_date', $model);
        $arr['end_date']    = (string)$this->prepare_field('end_date', $model);
        $arr['end_cities']  = [];

        if(isset($model->start_city)) {
            $startCityModel = $model->locationLogRel()->latest()->first();
            
            if($startCityModel) {
                $endCityCollection = $startCityModel->endCitiesRel()->get();
                if(count($endCityCollection)) {
                    foreach ($endCityCollection as $city) {
                        $arr['end_cities'][] = $city->title;
                    }
                } 
            }
        }
        $arr['permits'] = [];
        $permitCollection = $model->permitRel;

        if($permitCollection) {
            foreach ($permitCollection as $permit) {
                $arr['permits'][$permit->tag] = $permit->id;
            }
        }
        $arr['services_area'] = [];
        $servicesAreas = $model->serviceAreaRel; 

        if($servicesAreas) {
            foreach ($servicesAreas as $area) {
                $arr['services_area'][] = $area->title;
            }
        }

        return $arr;

    }

    public function saveLocationLogs($vehicleModel) {

        

        $model = new VehicleLocationLog;

        $model->vehicle_id    = $vehicleModel->id;
        $model->user_id       = $vehicleModel->user_id;
        $model->city_id       = $vehicleModel->start_city;
        $model->state_id      = $vehicleModel->start_state;
        $model->start_date    = $vehicleModel->start_date;
        $model->end_date      = $vehicleModel->end_date;


        $model->save();
        
        if(!auth()->user()->is_set_location) $this->userLocationFlagUpdate();

        if($val = \request('end_cities')) $model->endCitiesRel()->sync(explode(',', $val));

    }

    public function userLocationFlagUpdate() {
        $user = Auth::user();

        $user->is_set_location = 1;

        $user->save();
    }


    public function checkVehicleAgainstBooking($collection, $booking) {
        $data = [];

        foreach ($collection as $model) {
            if($model->end_cities) {
                if(in_array($booking->drop_location_city_id, explode(',', $model->end_cities))) $data[] = $this->parseModel($model);
            } else {
                $data[] = $this->parseModel($model);
            }   
            
        }

        return $data;
    }
}