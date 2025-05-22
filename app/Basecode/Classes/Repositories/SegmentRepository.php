<?php

namespace  App\Basecode\Classes\Repositories;


class SegmentRepository extends Repository {
	
	public $model = '\App\Segment';

    public $viewIndex = 'admin.segments.index';
    public $viewCreate = 'admin.segments.create';
    public $viewEdit = 'admin.segments.edit';
    public $viewShow = 'admin.segments.show';

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