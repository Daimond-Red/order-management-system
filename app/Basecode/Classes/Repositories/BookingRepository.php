<?php

namespace App\Basecode\Classes\Repositories;
use App\BookingAllocate;

class BookingRepository extends Repository {

    public $model = '\App\Booking';

    public $viewIndex = 'admin.bookings.index';
    public $viewCreate = 'admin.bookings.create';
    public $viewEdit = 'admin.bookings.edit';
    public $viewShow = 'admin.bookings.show';

    public $storeValidateRules = [
        'logistic_type' => 'required',
        'start_date_time' => 'required|after:yesterday',
        'address' => 'required',
        'lat' => 'required',
        'lng' => 'required',
        'city_id' => 'required',
        'drop_location_address' => 'required',
        'drop_location_lat' => 'required',
        'drop_location_lng' => 'required',
        'drop_location_city_id' => 'required',
        'vehicle_type_id' => 'required',
        'cargo_type_id' => 'required',
        'distance' => 'required',
        'estimate_weight' => 'required'

    ];

    public $updateValidateRules = [
        
    ];

    public function save( $attrs ) {

        $attrs = $this->getValueArray($attrs);

        $attrs['customer_id'] = auth()->user()->id;
        $attrs['status'] = \App\Booking::PENDING;

        $model = new $this->model;
        $model->fill($attrs);

        $model->save();

        $model->order_no = 'CRN'.str_pad($model->id, 5, "0", STR_PAD_LEFT);
        $model->save();

        $this->saveBookingLog($model);

        return $model;
    }


    public function saveBookingLog($bookingModel, $vendorId = null) {
        
        try {
            $model = new \App\BookingLog;   

            $model->booking_id = $bookingModel->id;
            $model->customer_id = $bookingModel->customer_id;
            $model->vendor_id = $vendorId;
            $model->status = $bookingModel->status;
            $model->data = serialize($bookingModel);
            
            $model->save();

        } catch(Exception $e) {

        }
    }

    public function saveBookingAllocation() {
        $model = new BookingAllocate;

        $model->booking_id = \request('booking_id');
        $model->vendor_id  = \request('vendor_id');

        $model->save();
    }

}