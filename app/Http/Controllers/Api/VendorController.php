<?php

namespace App\Http\Controllers\Api;

use App\Basecode\Classes\Repositories\VendorRepository as Repository;
use App\Basecode\Classes\Permissions\Permission as Permission;

class VendorController extends ApiController
{
    public $repository, $permission;

    function __construct(Repository $repository, Permission $permission)
    {
        $this->repository = $repository;
        $this->permission = $permission;
    }

    
}
