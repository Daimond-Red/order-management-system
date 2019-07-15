<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Basecode\Classes\Repositories\CustomerRepository as Repository;
use App\Basecode\Classes\Repositories\DocumentRepository;
use App\Basecode\Classes\Permissions\Permission as Permission;

class CustomerController extends BackendController {

    public $repository;
    public $permission;
    public $documentRepository;

    public function __construct(
        Repository $repository,
        DocumentRepository $documentRepository,
        Permission $permission
    ) {
        $this->repository = $repository;
        $this->documentRepository = $documentRepository;
        $this->permission = $permission;
    }

    public function search() {

        $data = [];

        $collection = $this->repository->getCollection()->where(function ($q){
            $q->orWhere('name', 'like', '%'. request('q'). '%');
            $q->orWhere('email', 'like', '%'. request('q'). '%');
        })->take(50)->get(['id', 'name',  'email']);

        foreach($collection as $model) $data['items'][] = ['id' => $model->id, 'text' => $model->first_name. ' '. $model->last_name. ' ('. $model->email. ')' ];

        return $data;

    }

    public function documents($userId) {
        if(! $this->permission->index()) return;
        
        $userModel = $this->repository->find($userId);

        $collection = $this->documentRepository->getCollection()->where('user_id', $userId)->get();
        
        return view('admin.customers.document', [
           'collection' => $collection,
           'repository' => $this->repository,
           'userModel' => $userModel
        ]);
    }

}
