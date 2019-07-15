<?php

namespace App\Http\Controllers\Admin;

use App\Basecode\Classes\Repositories\ContactUsRepository as Repository;
use App\Basecode\Classes\Permissions\Permission as Permission;

class ContactUsController extends BackendController
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
}
