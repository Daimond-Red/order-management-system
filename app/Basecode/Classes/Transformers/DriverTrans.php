<?php

namespace App\Basecode\Classes\Transformers;




class DriverTrans extends TransformerAbstract {

    public function parseModel ( $model, $attrs = null ) {

        $arr = [];
        try {
            $arr['name']             = (string) $this->get('name', $model);
            $arr['driver_id']        = (string) $this->get('id', $model);
            // $arr['email']            = (string)$this->get('email', $model);
            $arr['mobile_no']        = (string) $this->get('mobile_no', $model);
            $arr['is_verified']      = (string)(int)$this->get('is_verified', $model);
            $arr['created_at']       = (string) $this->get('created_at', $model);
            $arr['current_lat']      = (string) $this->get('current_lat', $model);
            $arr['current_lng']      = (string) $this->get('current_lng', $model);
            $arr['license_no']       = (string) $this->get('license_no', $model);
            $arr['status']           = (string) $this->get('status', $model);

            $arr['expire_date']      = (string) getDateValue($this->get('expire_date', $model));
            $arr['dl_type']          = (string) $this->get('dl_type', $model);


            $arr['address']          = (string) $this->get('address', $model);
            $arr['city_name']        = (string) optional($model->cityRel)->title;
            $arr['state_name']       = (string) optional($model->stateRel)->title;
            $arr['postcode']         = (string) $this->get('postcode', $model);

            $count = \App\Document::where('user_id', $model->id)->count();

            if( $count ) {
                $arr['is_document_uploaded'] = true;
            } else {
                $arr['is_document_uploaded'] = false;
            }
            
            $arr['is_available'] = true;

            $bookingCollection = $model->driverBookingsRel;

            foreach ($bookingCollection as $bookingModel) {
                $check = $bookingModel->bookingRel()->whereDate('start_date_time', "=", date('Y-m-d'))->first();
                if($check) $arr['is_available'] = false;
            }



            $arr['document_arr'] = \App\Document::where('user_id', $model->id)->get(['name', 'image', 'site']);

            return $arr;
        } catch (\Exception $e) {
            return $arr;
        }

    }
}