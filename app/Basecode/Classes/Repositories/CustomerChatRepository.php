<?php

namespace  App\Basecode\Classes\Repositories;


class CustomerChatRepository extends Repository {
	
	public $model = '\App\CustomerChat';

    public $viewIndex = 'admin.customerChats.index';
    public $viewCreate = 'admin.customerChats.create';
    public $viewEdit = 'admin.customerChats.edit';
    public $viewShow = 'admin.customerChats.show';

    public $storeValidateRules = [ 
        
    ]; 
    
    public function save( $attrs ) {

        $attrs = $this->getValueArray($attrs);
        
        $attrs['user_id'] = auth()->user()->id;
        $attrs['status'] = \App\ContactUs::PENDING_RESOLUTION;
        $attrs['is_admin'] = 1;
        
        $model = new $this->model;
        $model->fill($attrs);
        $model->save();
        return $model;
    }

    public function parseModel($model) {
        $arr = [];

        // $arr['title']         = (string)$this->prepare_field('title', $model);
        // $arr['message']       = (string)$this->prepare_field('message', $model);
        // $arr['booking_id']    = (string)$this->prepare_field('booking_id', $model);
        // $arr['alternate_no']  = (string)$this->prepare_field('alternate_no', $model);
        // $arr['vehicle_id']  = (Int)$this->prepare_field('vehicle_id', $model);

        return $arr;
    }

    
}