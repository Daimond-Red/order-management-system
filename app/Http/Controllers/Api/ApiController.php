<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Basecode\Classes\Repositories\Repository as Repository;
use App\Basecode\Classes\Permissions\Permission as Permission;

class ApiController extends Controller {

    public $repository, $permission;

    public function __construct(
        Repository $repository,
        Permission $permission
    ) {
        $this->repository = $repository;
        $this->permission = $permission;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        if(! $this->permission->index() ) return noAuth();

        if( request('withPagination') ) {
            $collection = $this->repository->getPaginated(5);
            $collection = [
                'page'      => $collection->currentPage(),
                'count'     => $collection->total(),
                'perPage'   => 5,
                'data'      => $this->repository->parseCollection($collection)
            ];
        } else {
            $collection = $this->repository->parseCollection($this->repository->getCollection()->get());
        }

        return appData($collection);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store() {

        if(! $this->permission->create() ) return noAuth();

        if( $err = cvalidate( getValidationRules($this->repository->storeValidateRules)) ) return appError($err->first());

        $model = $this->repository->save($this->repository->getAttrs());

        return appModelData($this->repository->parseModel($model),$this->repository->create_msg);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show() {

        if(! $this->permission->show() ) return noAuth();

        if( $err = cvalidate([$this->repository->primaryId => 'required']) ) return appError($err->first());

        $model = $this->repository->find( (request($this->repository->primaryId)) );

        return appModelData($this->repository->parseModel($model));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update() {

        if(! $this->permission->edit() ) return noAuth();

        $model = $this->repository->find( (request($this->repository->primaryId)) );

        if( $err = cvalidate( getValidationRules($this->repository->updateValidateRules, $model)) ) return appError($err->first());

        $model = $this->repository->update($model);

        return appModelData($this->repository->parseModel($model), $this->repository->update_msg);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy() {

        if(! $this->permission->destroy() ) return noAuth();

        if( $err = cvalidate( getValidationRules([ $this->repository->primaryId => 'required'])) ) return appError($err->first());

        $model = $this->repository->find( (request($this->repository->primaryId)) );

        $this->repository->delete($model);

        return appModelData([],$this->repository->delete_msg);

    }

    public function search() {

        $data = [];

        $collection = $this->repository->getCollection()->where(function ($q){
            $q->orWhere('id', 'like', '%'. request('q'). '%');
        })->take(50)->get(['id', 'id', 'last_name', 'email']);

        foreach($collection as $model) $data['items'][] = ['id' => $model->id, 'text' => $model->id ];

        return $data;

    }


}
