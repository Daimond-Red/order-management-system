<?php

namespace App\Basecode\Classes\Transformers;

use App\Basecode\Classes\Transformers\VehicleTrans;
use App\Basecode\Classes\Transformers\DriverTrans;
use App\Basecode\Classes\Transformers\BookingBidTrans;
use App\Basecode\Classes\Transformers\UserTrans;

use App\User;

class BookingTrans extends TransformerAbstract {

    public function parseModel ( $model, $attrs = null ) {

        $arr = []; // amount // vehicle type // cargo type //
        try {
            $arr['booking_id']                 = (string) $this->get('id', $model);
            $arr['order_no']                   = (string) $this->get('order_no', $model);
            $arr['order_type']                 = (string) $this->get('order_type', $model);
            $arr['logistic_type']              = (string) $this->get('logistic_type', $model);
            $arr['start_date_time']            = (string) $this->get('start_date_time', $model);
            $arr['end_date_time']              = (string) $this->get('end_date_time', $model);
            $arr['address']                    = (string) $this->get('address', $model);
            $arr['lat']                        = (string) $this->get('lat', $model);
            $arr['lng']                        = (string) $this->get('lng', $model);
            $arr['city']                       = (string) optional($model->cityRel)->title;
            $arr['drop_location_address']      = (string) $this->get('drop_location_address', $model);
            $arr['drop_location_lat']          = (string) $this->get('drop_location_lat', $model);
            $arr['drop_location_lng']          = (string) $this->get('drop_location_lng', $model);
            $arr['drop_location_city']         = (string) optional($model->dropLocationCityRel)->title;
            $arr['status']                     = (string) $this->get('status', $model);
            $arr['distance']                   = (string) $this->get('distance', $model);
            $arr['estimate_weight']            = (string) $this->get('estimate_weight', $model);
            $arr['booking_amount']             = (string) $this->get('booking_amount', $model);
            $arr['cargo_type']                 = (string) optional($model->cargoRel)->title;
            $arr['vehicle_type']               = (string) optional($model->vehicleRel)->title;
            $arr['is_rated_by_customer']       = (string) $this->get('is_rated_by_customer', $model);
            $arr['is_rated_by_vendor']         = (string) $this->get('is_rated_by_vendor', $model);
            $arr['vendor_rating']              = (string) $this->get('vendor_rating', $model);
            $arr['customer_rating']            = (string) $this->get('customer_rating', $model);
            $arr['customer_review_title']      = (string) $this->get('customer_review_title', $model);
            $arr['vendor_review_title']        = (string) $this->get('vendor_review_title', $model);
            $arr['customer_review']            = (string) $this->get('customer_review', $model);
            $arr['vendor_review']              = (string) $this->get('vendor_review', $model);
            $arr['custom_name']                = (string) $this->get('custom_name', $model);
            $arr['custom_phone']               = (string) $this->get('custom_phone', $model);


            $collection = $model->vehicleDriverRel;

            $arr['vehicles'] = [];
            $arr['drivers'] = [];

            if(count($collection)) { 
                foreach ($collection as $m) {
                    $arr['vehicles'][] = (new VehicleTrans)->parseModel($m->vehicleRel);
                    $arr['drivers'][] = (new DriverTrans)->parseModel($m->driverRel);
                } 
            }

            $arr['booking_bid'] = [];
            

            $collection = $model->bookingBidRel()->where('vendor_id', auth()->user()->id)->get();
            


            if(count($collection)) {
                $arr['booking_bid'] = (new BookingBidTrans)->parseCollection($collection);
                $arr['is_bid'] = 1;
            } else {
                $arr['is_bid'] = 0;
            }
            $arr['accepted_bid'] = [];
            $bidModel = $model->bookingBidRel()->where('status', 2)->first();

            if($bidModel) $arr['accepted_bid'][] = (new BookingBidTrans)->parseModel($bidModel);
 

            $arr['customer'] = (new UserTrans)->parseModel($model->customerRel);

            if($model->vendor_id) $arr['vendor'] = (new UserTrans)->parseModel($model->vendorRel);

            $arr['booking_logs'] = (new BookingBidTrans)->parseLogsCollection($model->bookingLogsRel);
            
            $arr['is_allocated'] = false;
            
            $allocateModel = $model->bookingAllocationRel()->where('vendor_id', auth()->user()->id)->first();

            if($allocateModel) $arr['is_allocated'] = true;

            $arr['is_chatable'] = false;

            $chatModel = $model->chatRel()->where('vendor_id', auth()->user()->id)->first();

            if($chatModel) $arr['is_chatable'] = true;
 
            return $arr;
        } catch (\Exception $e) {
            return $arr;
        }

    }

    public function parseCityCollection($collection, $fields = []) {
        $data = [];
        foreach($collection as $model) $data[] = $this->parseCityModel($model, $fields);
        return $data;
    }

    public function parseCityModel($model, $attrs = null ) {
        $arr = [];

        $arr['city_id'] = (string) $this->get('id', $model);
        $arr['name'] = (string) $this->get('title', $model);

        return $arr;
    }

    public function parseBidCollection($collection, $fields = []) {
        $data = [];
        foreach($collection as $model) $data[] = $this->parseBidModel($model, $fields);
        return $data;
    }

    public function parseBidModel($model, $attrs = null ) {
        $arr = [];

        $arr['bid_id']          = (string) $this->get('id', $model);
        $arr['company']         = (string) optional($model->vendorRel)->company;
        $arr['vendor_name']     = (string) optional($model->vendorRel)->name;
        $arr['order_no']        = (string) optional($model->bookingRel)->order_no;
        $arr['amount']          = (string) $this->get('amount', $model);

        // rating remains

        return $arr;
    }

    public function parseStateCollection($collection, $fields = []) {
        $data = [];
        foreach($collection as $model) $data[] = $this->parseStateModel($model, $fields);
        return $data;
    }

    public function parseStateModel($model, $attrs = null ) {
        $arr = [];

        $arr['state_id'] = (string) $this->get('id', $model);
        $arr['name'] = (string) $this->get('title', $model);

        return $arr;
    }
}
