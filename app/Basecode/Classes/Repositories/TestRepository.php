<?php

namespace  App\Basecode\Classes\Repositories;


class TestRepository extends Repository {
	
	public $model = '\App\Test';

    public $viewIndex = 'admin.tests.index';
    public $viewCreate = 'admin.tests.create';
    public $viewEdit = 'admin.tests.edit';
    public $viewShow = 'admin.tests.show';

    public $storeValidateRules = [ 
    ];

    public $updateValidateRules = [
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

        $uploads = ['image'];

        if (filter_var(request('image'), FILTER_VALIDATE_URL)) {
            $attrs['image'] = $this->download_image(request('image'));
        } else {
            foreach ( $uploads as $upload ) {
                if( request()->hasFile($upload) ){
                    $attrs[$upload] = self::upload_file($upload);
                } elseif( $attrs && count($attrs) && array_key_exists($upload, $attrs) ) {
                    unset($attrs[$upload]);
                }
            }
        }

        return $attrs;
    }
}