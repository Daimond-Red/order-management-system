<?php

namespace  App\Basecode\Classes\Repositories;

use App\Document;
use App\User;

class DocumentRepository extends Repository {
	
	public $model = '\App\Document';

    public $viewIndex = 'admin.documents.index';
    public $viewCreate = 'admin.documents.create';
    public $viewEdit = 'admin.documents.edit';
    public $viewShow = 'admin.documents.show';

    public $storeValidateRules = [ 
        'name' => 'required'
    ];

    public $updateValidateRules = [
        'name' => 'required'
    ];
    
    public function save( $attrs ) {

        $attrs = $this->getValueArray($attrs);
        
        if(\request('userId')) $attrs['user_id'] = \request('userId');

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

    public function parseModel($model) {
        $arr = [];

        $arr['name']        = (string)$this->prepare_field('name', $model);
        $arr['image']       = (string)$this->prepare_field('image', $model);
        $arr['site']        = (string)$this->prepare_field('site', $model);
        $arr['driver_id']   = (Int)$this->prepare_field('driver_id', $model);
        $arr['vehicle_id']  = (Int)$this->prepare_field('vehicle_id', $model);

        return $arr;
    }

    public function checkDocsCount () {

        $count = 0;

        if(auth()->user()->type == User::INDIVIDUAL_CUSTOMER) $count = Document::INDIVIDUAL_CUSTOMER_DOCS_COUNT;

        if(auth()->user()->type == User::COMMERCIAL_CUSTOMER) $count = Document::COMMERCIAL_CUSTOMER_DOCS_COUNT;

        if(auth()->user()->type == User::VENDOR) $count = Document::VENDOR_DOCS_COUNT;

        if(auth()->user()->type == User::DRIVER) $count = Document::DRIVER_DOCS_COUNT;

        $docsCount = $this->getModel()->where('user_id', auth()->user()->id)->count();

        if($docsCount >= $count && $count != 0) return true;

        return false; 
        
    }
 }