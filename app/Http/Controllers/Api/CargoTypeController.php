<?php

namespace App\Http\Controllers\Api;

use App\Basecode\Classes\Repositories\CargoTypeRepository as Repository;
use App\Basecode\Classes\Permissions\Permission as Permission;

class CargoTypeController extends ApiController
{
    public $repository, $permission;

    function __construct(Repository $repository, Permission $permission)
    {
        $this->repository = $repository;
        $this->permission = $permission;
    }
}
