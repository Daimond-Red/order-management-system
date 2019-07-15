<?php

namespace App\Http\Controllers\Admin;

use App\Basecode\Classes\Repositories\BookingRepository as Repository;
use App\Basecode\Classes\Permissions\Permission as Permission;
use App\Booking;

class BookingController extends BackendController
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

    public function pendingBooking(){

        $collection = $this->repository->getCollection()->whereIn('status', [Booking::PENDING, Booking::BOOKING_HAS_BID])->orderBy('updated_at', 'desc')->get();
        
        return view('admin.bookings.pendingBooking', [
            'collection' => $collection,
            'repository' => $this->repository
        ]);
    }

    public function completedBooking(){
        
        $collection = $this->repository->getCollection()->where('status', Booking::COMPLETED)->get();

        return view('admin.bookings.completedBooking', [
            'collection' => $collection,
            'repository' => $this->repository
        ]);
    }

    public function confirmedBooking(){

        $collection = $this->repository->getCollection()->whereIn('status', [
            Booking::BID_CONFIRM,
            Booking::ASSIGN_DRIVER_VEHICLE,
            Booking::OUT_FOR_DELIVERY,
            Booking::CONFIRMED
             ])->get();

        return view('admin.bookings.confirmedBooking', [
            'collection' => $collection,
            'repository' => $this->repository
        ]);
    }

    public function expiredBooking(){
        
        $collection = $this->repository->getCollection()->where('status', Booking::EXPIRED)->get();
        
        return view('admin.bookings.expiredBooking', [
            'collection' => $collection,
            'repository' => $this->repository
        ]);
    }

    public function cancelBooking(){
        
        $collection = $this->repository->getCollection()->where('status', Booking::CANCEL)->get();
        
        return view('admin.bookings.cancelBooking', [
            'collection' => $collection,
            'repository' => $this->repository
        ]);
    }

    public function liveBooking(){
        
        $collection = $this->repository->getCollection()->where('status', Booking::LIVE)->get();

        return view('admin.bookings.liveBooking', [
            'collection' => $collection,
            'repository' => $this->repository
        ]);
    }
    
    public function bookingDetail($id){
        $model = $this->repository->find($id);

        return view('admin.bookings.bookingDetail', [
            'id'=> $id,
            'model' => $model
        ]);
    }

    public function map($bookingId) {
        
        $model = $this->repository->find($bookingId);

        $data[] = [
            'lat' => (float)$model->lat,
            'lng' => (float)$model->lng
        ];
        

        $collection = $model->mapLogsRel;

        if(count($collection)) {
            foreach ($collection as $mapModel) {
                $data[] = [
                    'lat' => (float)$mapModel->lat,
                    'lng' => (float)$mapModel->lng
                ];
            }
        }

        $data[] = [
            'lat' => (float)$model->drop_location_lat,
            'lng' => (float)$model->drop_location_lng
        ];

        return view('admin.bookings.bookingMap', [
            'data' => $data
        ]);

    }
    
}
