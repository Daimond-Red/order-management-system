<?php

namespace App\Http\Controllers\Api;

use App\Basecode\Classes\Repositories\ContactUsRepository as Repository;
use App\Basecode\Classes\Permissions\Permission as Permission;
use App\Basecode\Classes\Transformers\CustomerChatTrans;
use App\Basecode\Classes\Transformers\ContactUsTrans;
class ContactUsController extends ApiController
{
    public $repository, $permission;

    function __construct(Repository $repository, Permission $permission)
    {
        $this->repository = $repository;
        $this->permission = $permission;
    }

    public function store() {

        if(! $this->permission->create() ) return noAuth();

        if( $err = cvalidate( getValidationRules($this->repository->storeValidateRules)) ) return appError($err->first());

        if(\request('booking_id')) {
        	if( $err = cvalidate( ['booking_id' => 'exists:bookings,id'] ) ) return appError($err->first());
        }

        $model = $this->repository->save($this->repository->getAttrs());

        $this->repository->saveCustomerChat($model);

        return appModelData($this->repository->parseModel($model),$this->repository->create_msg);

    }

    public function reply() {
        
        if( $err = cvalidate( ['contact_us_id' => 'required', 'message' => 'required'] ) ) return appError($err->first());


        if( !in_array(auth()->user()->type, [\App\User::INDIVIDUAL_CUSTOMER, \App\User::COMMERCIAL_CUSTOMER]) ) return appError('Invalid user.');

        $model = $this->repository->getModel()
            ->where('id', \request('contact_us_id'))
            // ->where('status', \App\ContactUs::CUSTOMER_ACTION_PENDING)
            ->first();

        if(!$model) return appError('Bad Request.');

        $chatModel = $this->repository->saveCustomerChat($model);

        $model->status = \App\ContactUs::PENDING_ADMIN_REPLY;

        $model->save();


        return appModelData((new CustomerChatTrans)->parseModel($chatModel), 'Your message received by admin. Admin reply you soon.');
    }

    public function customerChat() {

        if( $err = cvalidate( ['contact_us_id' => 'required'] ) ) return appError($err->first());

        $model = $this->repository->getModel()
            ->where('id', \request('contact_us_id'))
            ->first();

        if(!$model) return appError('Bad Request.');

        return appData( (new CustomerChatTrans)->parseCollection($model->queriesRel) );
    }


    public function queryList() {

        if( !in_array(auth()->user()->type, [\App\User::INDIVIDUAL_CUSTOMER, \App\User::COMMERCIAL_CUSTOMER]) ) return appError('Invalid user.');

        $collection = $this->repository->getCollection()->where('user_id', auth()->user()->id)->get();

        return appData( (new ContactUsTrans)->parseCollection($collection) );
    }
}
