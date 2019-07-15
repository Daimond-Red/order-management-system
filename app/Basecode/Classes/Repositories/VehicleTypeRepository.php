<?php

namespace  App\Basecode\Classes\Repositories;


class VehicleTypeRepository extends Repository {
	
	public $model = '\App\VehicleType';

    public $viewIndex = 'admin.masters.vehicleTypes.index';
    public $viewCreate = 'admin.masters.vehicleTypes.create';
    public $viewEdit = 'admin.masters.vehicleTypes.edit';
    public $viewShow = 'admin.masters.vehicleTypes.show';

    public $storeValidateRules = [
       	'title' => 'required|unique:vehicle_types,title',
       	// 'title_hindi' => 'unique:vehicle_types,title_hindi', 
    ];

    public $updateValidateRules = [
        'title' => 'required|unique:vehicle_types,title',
       	// 'title_hindi' => 'unique:vehicle_types,title_hindi', 
    ];
    
    public function save( $attrs ) {

        $attrs = $this->getAttrs();

        $model = new $this->model;
        $model->fill($attrs);
        $model->save();
        return $model;
    }

    public function update($model, $attrs = null) {
        if(! $attrs ) $attrs = $this->getAttrs();

        $model->fill($attrs);
        $model->update();
        return $model;
    }

    public function getAttrs() {
        $attrs = request()->all();

        $attrs['tag'] = str_slug(request('title'), '_');
        
        return $attrs;
    }

    public function parseModel($model) {
        $arr = [];

        $arr['vehicle_type_id'] = (Int)$this->prepare_field('id', $model);
        $arr['title']           = (string)$this->prepare_field('title', $model);

        return $arr;
    }
}