<?php

namespace App\Http\Controllers\Api;

use App\Basecode\Classes\Repositories\DocumentRepository as Repository;
use App\Basecode\Classes\Permissions\Permission as Permission;

class DocumentController extends ApiController
{
	public $repository, $permission;

    function __construct(Repository $repository, Permission $permission)
    {
        $this->repository = $repository;
        $this->permission = $permission;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store() {

        if(! $this->permission->create() ) return noAuth();

        if( $err = cvalidate( getValidationRules($this->repository->storeValidateRules)) ) return appError($err->first());

        $vehicleId = null;
        $driverId = null;
        $userId = auth()->user()->id;
        
        $attrs = $this->repository->getAttrs();

        $model = $this->repository->getModel()->where('name', \request('name'))->where('site', \request('site'));

        if($vehicleId = \request('vehicle_id')) {
            $model = $model->where('vehicle_id', $vehicleId);
            $userId = null;
        } else if($driverId = \request('driver_id')) {
            $userId = $driverId;
            $model = $model->where('user_id', $driverId);
        } else {
            $model = $model->where('user_id', $userId);
        }
        

        $model = $model->first();

        if(!$model) $model = $this->repository->getModel();

        $model->name = \request('name'); 
        $model->site = \request('site');
        $model->user_id = $userId;
        $model->vehicle_id = $vehicleId; 
        $model->driver_id = null; 
        $model->image = $attrs['image'];

        $model->save();

        if(!auth()->user()->status && ($this->repository->checkDocsCount()) ) {
            $userModel = \App\User::where('id', auth()->user()->id)->first();

            $userModel->status = 2;

            $userModel->save();
        }
        

        return appModelData($this->repository->parseModel($model), $this->repository->create_msg);
    }
}
