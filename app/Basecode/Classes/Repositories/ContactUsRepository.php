<?php

namespace  App\Basecode\Classes\Repositories;


class ContactUsRepository extends Repository {
	
	public $model = '\App\ContactUs';

    public $viewIndex = 'admin.contactUs.index';
    public $viewCreate = 'admin.contactUs.create';
    public $viewEdit = 'admin.contactUs.edit';
    public $viewShow = 'admin.contactUs.show';

    public $storeValidateRules = [ 
        'title' => 'required',
        'message' => 'required'
    ]; 
    
    public function save( $attrs ) {

        $attrs = $this->getValueArray($attrs);
        
        $attrs['user_id'] = auth()->user()->id;
        $attrs['status'] = \App\ContactUs::PENDING_RESOLUTION;

        $model = new $this->model;
        $model->fill($attrs);
        $model->save();

        $model->ticket_id = 'TID'.str_pad($model->id, 3, "0", STR_PAD_LEFT);

        $model->save();

        return $model;
    }

    public function parseModel($model) {
        $arr = [];

        $arr['title']         = (string)$this->prepare_field('title', $model);
        $arr['message']       = (string)$this->prepare_field('message', $model);
        $arr['booking_id']    = (string)$this->prepare_field('booking_id', $model);
        $arr['alternate_no']  = (string)$this->prepare_field('alternate_no', $model);
        $arr['ticket_id']     = (string)$this->prepare_field('ticket_id', $model);
        // $arr['vehicle_id']  = (Int)$this->prepare_field('vehicle_id', $model);

        return $arr;
    }

    public function saveCustomerChat($contactModel) {
        
        $model = new \App\CustomerChat;

        $model->contact_us_id = $contactModel->id;
        $model->sender_id = $contactModel->user_id;
        $model->receiver_id = 1;
        $model->message = \request('message');

        $model->save();
        return $model;
    }
}