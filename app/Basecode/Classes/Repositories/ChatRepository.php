<?php

namespace  App\Basecode\Classes\Repositories;


class ChatRepository extends Repository {
	
	public $model = '\App\Chat';

    public $viewIndex = 'admin.chats.index';
    public $viewCreate = 'admin.chats.create';
    public $viewEdit = 'admin.chats.edit';
    public $viewShow = 'admin.chats.show';

    public $storeValidateRules = [ 
        'booking_id' => 'required|exists:bookings,id',
        'vendor_id'  => 'required|exists:users,id' 
    ]; 
    
    public function save( $attrs ) {

        $attrs = $this->getValueArray($attrs);
        $attrs['customer_id'] = auth()->user()->id;
        
        $model = new $this->model;
        $model->fill($attrs);
        $model->save();

        return $model;
    }

    public function parseModel($model) {
        $arr = [];
        
        $arr['chat_id']      = (int) $this->prepare_field('id', $model);
        $arr['vendor_id']    = (int) $this->prepare_field('vendor_id', $model);
        $arr['customer_id']  = (int) $this->prepare_field('customer_id', $model);
        $arr['customer']     = (string) optional($model->customerRel)->name;
        $arr['booking_id']   = (string) optional($model->bookingRel)->id;
        $arr['order_no']     = (string) optional($model->bookingRel)->order_no;
        $arr['pickup_city']  = (string) optional(optional($model->bookingRel)->cityRel)->title;
        $arr['drop_city']    = (string) optional(optional($model->bookingRel)->dropLocationCityRel)->title;

        return $arr;
    }

    public function saveChatLogs($chatModel) {
        
        $model = new \App\ChatLog;

        $model->chat_id = $chatModel->id;
        $model->sender_id = auth()->user()->id;
        $model->receiver_id = \request('receiver_id');

        if($val = \request('receiver_id2')) $model->receiver_id_2 = $val;

        $model->message = \request('message');

        $model->save();

        return $model;
    }

    public function parseLogModel($model) {
        $arr = [];
        
        $arr['sender_id']      = (int) $this->prepare_field('sender_id', $model);
        $arr['user_id']        = (int) auth()->user()->id;
        $arr['receiver_id']    = (int) $this->prepare_field('receiver_id', $model);
        $arr['receiver_id_2']  = (int) $this->prepare_field('receiver_id_2', $model);
        $arr['message']        = (string) $this->prepare_field('message', $model);
        $arr['created_at']     = (string) $this->prepare_field('created_at', $model);
        
        return $arr;
    }

    public function parseLogCollection( $collection ) {
        $data = [];
        foreach($collection as $model) $data[] = $this->parseLogModel($model);
        return $data;
    }

}