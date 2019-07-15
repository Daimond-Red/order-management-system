<?php

namespace App\Http\Controllers\Api;

use App\Basecode\Classes\Repositories\ChatRepository as Repository;
use App\Basecode\Classes\Permissions\Permission as Permission;
use App\Basecode\Classes\Repositories\BookingRepository;
use App\User;

class ChatController extends ApiController
{
   	public $repository, $bookingRepository, $permission;

    function __construct(Repository $repository, Permission $permission, BookingRepository $bookingRepository)
    {
        $this->repository = $repository;
        $this->bookingRepository = $bookingRepository;
        $this->permission = $permission;
    }

    public function store() {

        if(! $this->permission->create() ) return noAuth();

        if( $err = cvalidate( getValidationRules($this->repository->storeValidateRules) ) ) return appError($err->first());

        $bookingModel = $this->bookingRepository->getModel()
            ->where('id', \request('booking_id'))
            ->first();

       	if(!$bookingModel) return appError('Invalid booking.');

        $model = $this->repository->getModel()
        	->where('booking_id', \request('booking_id'))
        	->where('customer_id', $bookingModel->customer_id)
        	->where('vendor_id', \request('vendor_id'))
        	->first();

        if(!$model) $model = $this->repository->save($this->repository->getAttrs());

        return appModelData($this->repository->parseModel($model), '');
    }

    public function logStore() {
    	$rules = [
    		'chat_id'     => 'required|exists:chats,id',
    		'receiver_id' => 'required',
    		'message'     => 'required'
    	];

    	if( $err = cvalidate( $rules ) ) return appError($err->first());

    	$chatModel = $this->repository->find(\request('chat_id'));

    	if(!$chatModel) return appError('Bad Request.');

    	$model = $this->repository->saveChatLogs($chatModel);

    	if(!$model) return appError('Bad Request');

        $msg = $model->message;

        sendPushNotification($model->receiver_id, [
            'chat_id'       => $model->chat_id,
            'category'      => 'chat',
            'body'          => $msg,
            'title'         => 'Chat Message'
        ]);

    	return appModelData($this->repository->parseLogModel($model), 'Send Successfully.'); 
    }


    public function chatList() {

        if( !in_array(auth()->user()->type, [User::VENDOR]) ) return appError('Invalid user');

        $collection = $this->repository->getCollection()->where('vendor_id', auth()->user()->id)->get();

        return appData($this->repository->parseCollection($collection));
    }

    public function chats() {

        if( $err = cvalidate( ['chat_id' => 'required|exists:chats,id'] ) ) return appError($err->first());

        $model = $this->repository->find(\request('chat_id'));

        if(!$model) return appError('Bad Request');

        $collection = $model->chatRel()->get();

        return appData($this->repository->parseLogCollection($collection));

    }
}
