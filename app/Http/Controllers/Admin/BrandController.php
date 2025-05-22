<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Basecode\Classes\Permissions\Permission;
use App\Http\Controllers\Admin\BackendController;
use App\Basecode\Classes\Repositories\BrandRepository as Repository;

class BrandController extends BackendController
{
    public $repository, $permission;

    public function __construct(Repository $repository, Permission $permission) {
        $this->repository = $repository;
        $this->permission = $permission;
    }
}
