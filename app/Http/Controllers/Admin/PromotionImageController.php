<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Basecode\Classes\Repositories\PromotionImageRepository as Repository;
use App\Basecode\Classes\Permissions\Permission as Permission;

class PromotionImageController extends BackendController {

    public $repository, $permission;

    public function __construct(
        Repository $repository,
        Permission $permission
    ) {
        $this->repository = $repository;
        $this->permission = $permission;
    }

}