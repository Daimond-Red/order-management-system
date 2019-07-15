<?php

namespace App\Http\Controllers\Admin;

use App\Basecode\Classes\Repositories\Repository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Basecode\Classes\Repositories\VendorRepository as VendorRepository;
use App\Basecode\Classes\Repositories\DriverRepository as DriverRepository;
use App\Basecode\Classes\Permissions\Permission as Permission;
use App\City;
use App\State;

class DriverController extends BackendController {

    public $repository, $vendorRepository, $driverRepository, $permission;

    public function __construct(
        VendorRepository $vendorRepository,
        DriverRepository $driverRepository,
        Permission $permission) {

        $this->vendorRepository = $vendorRepository;
        $this->driverRepository = $driverRepository;
        $this->permission = $permission;
        $this->repository = $driverRepository;

    }

    public function index() {

        if(! $this->permission->index()) return;
        
        $collection = $this->repository->getCollection()->where('vendor_id', '!=', null)->get();
        
        return view('admin.drivers.driverList', [
           'collection' => $collection,
           'repository' => $this->repository
        ]);
    }

    public function index_driver($vendor_id) {

        $vendor = $this->vendorRepository->find($vendor_id);

        $collection = $this->driverRepository->getCollection()->where('vendor_id', $vendor->id)->get();

        return view($this->driverRepository->viewIndex, compact('collection', 'vendor'));

    }

    public function add_driver($vendor_id) {
        
        $vendor = $this->vendorRepository->find($vendor_id);

        $states = State::getStates();

        $cities = City::getCities();

        return view($this->driverRepository->viewCreate, compact('vendor', 'cities', 'states'));
    }

    public function store_driver($vendor_id) {

        $vendor = $this->vendorRepository->find($vendor_id);

        request()->validate($this->driverRepository->storeValidateRules);

        $attrs = array_merge($this->driverRepository->getAttrs(), ['vendor_id' => $vendor_id]);

        $this->driverRepository->save($attrs);

        return $this->driverRepository->redirectBackWithSuccess($this->driverRepository->create_msg);

    }

    public function edit_driver($vendor_id, $driver_id) {

        $vendor = $this->vendorRepository->find($vendor_id);
        $model = $this->driverRepository->find($driver_id);
        $states = State::getStates();

        return view($this->driverRepository->viewEdit, compact('vendor', 'model', 'states'));

    }

    public function update_driver($vendor_id, $driver_id) {

        $vendor = $this->vendorRepository->find($vendor_id);
        $model = $this->driverRepository->find($driver_id);

        $this->driverRepository->update($model);

        return $this->vendorRepository->redirectBackWithSuccess($this->vendorRepository->update_msg);

    }

    public function delete_driver($vendor_id, $driver_id) {

        $vendor = $this->vendorRepository->find($vendor_id);
        $model = $this->driverRepository->find($driver_id);

        $this->driverRepository->delete($model);

        return $this->driverRepository->redirectBackWithSuccess($this->driverRepository->delete_msg);
    }

    public function show_driver($vendorId, $driverId) {

        if(! $this->permission->show() ) return;
        $vendor = $this->vendorRepository->find($vendorId);
        $model = $this->driverRepository->find($driverId);

        $collection = [];

        return view($this->driverRepository->viewShow, [
            'model'         => $model,
            'repository'    => $this->driverRepository,
            'collection'    => $collection,
            'vendor'        => $vendor
        ]);

    }

}
