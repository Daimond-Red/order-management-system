<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Basecode\Classes\Repositories\CustomerChatRepository as Repository;
use App\Basecode\Classes\Permissions\Permission as Permission;
use App\ContactUs;

class CustomerChatController extends BackendController
{
    public $repository;
    public $permission;

    public function __construct(
        Repository $repository,
        Permission $permission
    ) {
        $this->repository = $repository;
        $this->permission = $permission;
    }

    public function index() {

        if(! $this->permission->index()) return;
        
        $model = ContactUs::find(\request('contactId'));

        $collection = $this->repository->getPaginated(15);
    	
        return view($this->repository->viewIndex, [
           'collection' => $collection,
           'repository' => $this->repository,
           'model' => $model
        ]);
    }

    public function store(Request $request) {

        if(! $this->permission->create() ) return;

        $request->validate( getValidationRules($this->repository->storeValidateRules));

        $attrs = $this->repository->getAttrs();
        $attrs['sender_id'] = auth()->user()->id;
        $attrs['contact_us_id'] = \request('contactId');

        $this->repository->save($attrs);

        $model = ContactUs::find(\request('contactId'));
        $model->status = \App\ContactUs::CUSTOMER_ACTION_PENDING;
        $model->save();

        $msg = "Admin reply on our query.";
        sendPushNotification($model->user_id, [
            // 'booking_id'    => $bookingModel->id,
            'category'      => 'query_reply',
            'body'          => $msg
        ]);

        return $this->repository->redirectBackWithSuccess($this->repository->create_msg);

    }
}
