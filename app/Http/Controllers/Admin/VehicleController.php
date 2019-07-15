<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Basecode\Classes\Repositories\VendorRepository;
use App\Basecode\Classes\Repositories\VehicleRepository;
use App\Basecode\Classes\Repositories\VehicleTypeRepository;
// use App\Basecode\Classes\Repositories\VehicleCategoryRepository;
use App\Basecode\Classes\Permissions\Permission as Permission;
use App\State;
use App\City;

class VehicleController extends BackendController {

    public $repository, $vendorRepository, $vehicleRepository, $vehicleTypeRepository, $permission;

    public function __construct(
        VendorRepository $vendorRepository,
        VehicleRepository $vehicleRepository,
        VehicleTypeRepository $vehicleTypeRepository,
        Permission $permission) {

        $this->vendorRepository = $vendorRepository;
        $this->vehicleTypeRepository = $vehicleTypeRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->repository = $vehicleRepository;
        $this->permission = $permission;

    }

    public function index_vehicle($user_id) {

        $vendor = $this->vendorRepository->find($user_id);

        $collection = $this->vehicleRepository->getCollection()->where('user_id', $vendor->id)->get();

        return view($this->vehicleRepository->viewIndex, compact('collection', 'vendor'));

    }

    public function add_vehicle($user_id) {

        $vendor = $this->vendorRepository->find($user_id);

        $vehicletypes = $this->vehicleTypeRepository->getCollection()->pluck('title', 'id');
        // $vehiclecategories = $this->vehicleCategoryRepository->getCollection()->pluck('title', 'id');
        $states = State::getStates();

        return view($this->vehicleRepository->viewCreate, compact('vendor', 'vehicletypes', 'states'));
    }

    public function store_vehicle($user_id) {

        $vendor = $this->vendorRepository->find($user_id);

        request()->validate($this->vehicleRepository->storeValidateRules);

        $this->vehicleRepository->save(array_merge($this->vehicleRepository->getAttrs(), ['user_id' => $user_id]));

        return $this->vehicleRepository->redirectBackWithSuccess($this->vehicleRepository->create_msg);

    }

    public function edit_vehicle($user_id, $vehicle_id) {

        $vendor = $this->vendorRepository->find($user_id);

        $model = $this->vehicleRepository->find($vehicle_id);

        $vehicletypes = $this->vehicleTypeRepository->getCollection()->pluck('title', 'id');
        // $vehiclecategories = $this->vehicleCategoryRepository->getCollection()->pluck('title', 'id');
        $states = State::getStates();
        
        $stateIds = State::getStateIds();

        $cities = City::whereIn('state_id', $stateIds)->pluck('title', 'id')->toArray();

        $servicesAreas = $model->serviceAreaRel()->pluck('title', 'cities.id')->toArray();
        
        $permitTypes = $model->permitRel()->pluck('permits.id')->toArray();
        
        return view($this->vehicleRepository->viewEdit, compact('vendor', 'model', 'vehicletypes', 'states', 'cities', 'servicesAreas', 'permitTypes'));

    }

    public function update_vehicle($user_id, $vehicle_id) {

        $vendor = $this->vendorRepository->find($user_id);
        $model = $this->vehicleRepository->find($vehicle_id);

        $this->vehicleRepository->update($model);

        return $this->vendorRepository->redirectBackWithSuccess($this->vendorRepository->update_msg);

    }

    public function delete_vehicle($user_id, $vehicle_id) {

        $vendor = $this->vendorRepository->find($user_id);
        $model = $this->vehicleRepository->find($vehicle_id);

        $this->vehicleRepository->delete($model);

        return $this->vehicleRepository->redirectBackWithSuccess($this->vehicleRepository->delete_msg);
    }

    public function show_vehicle($vendorId, $vehicle_id) {

        if(! $this->permission->show() ) return;
        $vendor = $this->vendorRepository->find($vendorId);
        $model = $this->vehicleRepository->find($vehicle_id);

        $collection = [];

        return view($this->vehicleRepository->viewShow, [
            'model'         => $model,
            'repository'    => $this->vehicleRepository,
            'collection'    => $collection,
            'vendor'        => $vendor
        ]);

    }

}