<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
    	'order_no',
    	'customer_id',
		'driver_id',
		'vehicle_id',
		'vehicle_type_id',
		'cargo_type_id',
        'custom_name',
        'custom_phone',
		'logistic_type',
		'start_date_time',
		'end_date_time',
		'address',
		'lat',
		'lng',
		'city_id',
		'state',
		'drop_location_address',
		'drop_location_lat',
		'drop_location_lng',
		'drop_location_city_id',
		'drop_location_state',
		'status',
		'distance',
		'signature',
        'is_rated_by_customer',
        'is_rated_by_vendor',
        'customer_rating',
        'vendor_rating',
        'customer_review',
        'vendor_review',
        'booking_amount',
        'estimate_weight',
        'order_type',
        'customer_review_title',
        'vendor_review_title',
    ];

    const PENDING = 1;
    const BOOKING_HAS_BID = 2;
    const CANCEL  = 3;
    const BID_CONFIRM = 4;
    const ASSIGN_DRIVER_VEHICLE = 5;
    const OUT_FOR_DELIVERY = 6;
    const CONFIRMED = 7;
    const RESCHEDULE_BOOKING = 8;
    const CONFIRMED_RESCHEDULE_BOOKING = 9;
    const EXPIRED = 10;
    const COMPLETED = 11;
    const LIVE = 12;
    const ALLOCATE = 13;

    const INTER_CITY = 1;
    const INTRA_CITY = 2;

    const PREPAID = 1;
    const TOPAY = 2;

    public function setStartDateTimeAttribute($value) {
        try{
            $this->attributes['start_date_time'] = date('Y-m-d H:i:s', strtotime($value));
        } catch (\Exception $e) {

        }
    }
    public function setEndDateTimeAttribute($value) {
        try{
            $this->attributes['end_date_time'] = date('Y-m-d H:i:s', strtotime($value));
        } catch (\Exception $e) {

        }
    }

    public function bookingLogsRel() {

        return $this->hasMany(BookingLog::class, 'booking_id');
    }

    public function bookingBidRel() {

        return $this->hasMany(BookingBid::class, 'booking_id');
    }


    public function cityRel() {
    	return $this->belongsTo(City::class, 'city_id');
    }

    public function dropLocationCityRel() {
    	return $this->belongsTo(City::class, 'drop_location_city_id');
    }

    public function customerRel() {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function vendorRel() {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function vehicleDriverRel() {

        return $this->hasMany(AssignVehicleDriver::class, 'booking_id');
    }

    public function vehicleRel() {
        return $this->belongsTo(VehicleType::class, 'vehicle_type_id');
    }

    public function cargoRel() {
        return $this->belongsTo(CargoType::class, 'cargo_type_id');
    }

    public function mapLogsRel() {
        return $this->hasMany(MapAddressLog::class, 'booking_id');
    }

    public function chatRel() {
        return $this->hasMany(Chat::class, 'booking_id');
    }

    public function bookingAllocationRel() {
        return $this->hasMany(BookingAllocate::class, 'booking_id');
    }
     
}
