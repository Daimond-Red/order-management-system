<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Basecode\Classes\Repositories\DocumentRepository as Repository;
use App\Basecode\Classes\Permissions\Permission as Permission;

class DocumentController extends BackendController
{
    public $repository, $permission;

    function __construct(Repository $repository, Permission $permission)
    {
        $this->repository = $repository;
        $this->permission = $permission;
    }

    public function store(Request $request) {

        if(! $this->permission->create() ) return;

        $request->validate( getValidationRules($this->repository->storeValidateRules));
        
        $model = $this->repository->getModel()
            ->where('name', \request('name'))
            ->where('site', \request('site'))
            ->where('user_id', \request('userId'))
            ->first();

        if($model) return $this->repository->redirectBackWithErrors('Already Exist.');

        $this->repository->save($this->repository->getAttrs());

        return $this->repository->redirectBackWithSuccess($this->repository->create_msg);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function documents($userId) {

        if(! $this->permission->index()) return;

        $collection = $this->repository->getCollection()->where('user_id', $userId)->get();
        
        $userModel = \App\User::find($userId);
        
        return view($this->repository->viewIndex, [
           'collection' => $collection,
           'repository' => $this->repository,
           'userModel' => $userModel
        ]);
    }
}
