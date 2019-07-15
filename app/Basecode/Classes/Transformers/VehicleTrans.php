<?php

namespace App\Basecode\Classes\Transformers;

class VehicleTrans extends TransformerAbstract {

    public function parseModel ( $model, $attrs = null ) {
        // dd($model->toArray());
        $arr = [];
        try {
            
            $arr['name']                = (string) $this->get('name', $model);
            $arr['address']             = (string) $this->get('address', $model);
            $arr['city']                = (string) optional($model->cityRel)->title;
            $arr['state']               = (string) optional($model->stateRel)->title;
            $arr['postcode']            = (string) $this->get('postcode', $model);
            $arr['mobile_no']           = (string) $this->get('mobile_no', $model);
            $arr['aadhar']              = (string) $this->get('aadhar', $model);
            $arr['pan']                 = (string) $this->get('pan', $model);
            $arr['capacity']            = (string) $this->get('capacity', $model);
            $arr['vehicle_names']       = (string) $this->get('vehicle_names', $model);
            $arr['permit_type']         = (string) $this->get('permit_type', $model);

            $arr['vehicle_type']        = (string) optional($model->vehicleTypeRel)->title;
            $arr['vehicle_num']         = (string) $this->get('vehicle_num', $model);
            $arr['is_verified']         = (string) $this->get('is_verified', $model);
            $arr['is_available'] = true;

            $bookingCollection = $model->bookingVehicleRel;

            foreach ($bookingCollection as $bookingModel) {
                $check = $bookingModel->bookingRel()->whereDate('start_date_time', "=", date('Y-m-d'))->first();
                if($check) $arr['is_available'] = false;
            }
            return $arr;
            
        } catch (\Exception $e) {
            return $arr;
        }

    }
}