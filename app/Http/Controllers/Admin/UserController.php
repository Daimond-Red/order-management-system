<?php

namespace App\Http\Controllers\Admin;

use App\Basecode\Classes\Repositories\UserRepository as Repository;
use App\Basecode\Classes\Permissions\Permission as Permission;
use App\City;


class UserController extends BackendController
{
    public $repository, $permission;

    function __construct(Repository $repository, Permission $permission)
    {
        $this->repository = $repository;
        $this->permission = $permission;
    }

    public function customerIndex() {

    	if(! $this->permission->index()) return;

        $collection = $this->repository->getCollection()->whereIn('type', [\App\User::INDIVIDUAL_CUSTOMER, \App\User::COMMERCIAL_CUSTOMER])->paginate(15);
        
        return view($this->repository->viewIndex, [
           'collection' => $collection,
           'repository' => $this->repository
        ]);
    }

    public function searchCities() {

        $data = [];

        $collection = new City();

        if( $val = request('state_id') ) $collection = $collection->where('state_id', $val);

        if( request('q') ) $collection = $collection->where('title', 'like', '%'. request('q'). '%');

        $collection = $collection->take(20)->get(['id', 'title']);

        foreach($collection as $model) $data['items'][] = [
            'id' => $model->id,
            'text' => $model->title
        ];

        return $data;

    }

}
