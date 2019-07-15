<?php

namespace App\Basecode\Classes\Permissions;

/**
 * In Method We will return True if you has permissions to view this
 * Otherwise false
 */

class Permission {

    protected function checkAuthNPer($permission = '', $authId = null ){
        if(!auth()->check()) return false;

        return true;
        try{
           if(auth()->user()->type == \App\User::SUPERADMIN) return true;
           return auth()->user()->hasDirectPermission($permission);
        } catch (\Exception $e) {
           return false;
        }
    }

    public function index() {
        return true;
    }

    public function create() {
        return true;
    }

    public function edit() {
        return true;
    }

    public function destroy() {
        return true;
    }

    public function show() {
        return true;
    }

    public function import() {
        return true;
    }

}
