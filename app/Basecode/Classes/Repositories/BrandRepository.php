<?php

namespace  App\Basecode\Classes\Repositories;


class BrandRepository extends Repository {
	
	public $model = '\App\Brand';

    public $viewIndex = 'admin.brands.index';
    public $viewCreate = 'admin.brands.create';
    public $viewEdit = 'admin.brands.edit';
    public $viewShow = 'admin.brands.show';

    public $storeValidateRules = [
       	'name' => 'required',
    ];

    public $updateValidateRules = [
        'name' => 'required',
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
        
        return $attrs;
    }

}