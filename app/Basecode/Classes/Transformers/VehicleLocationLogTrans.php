<?php

namespace App\Basecode\Classes\Transformers;

class VehicleLocationLogTrans extends TransformerAbstract
{
	public function parseModel ( $model, $attrs = null ) {
        // dd($model->toArray());
        $arr = [];
        try {

            $arr['vehicle_type']        = (string) optional(optional($model->vehicleRel)->vehicleTypeRel)->title;
            $arr['vehicle_num']         = (string) optional($model->vehicleRel)->vehicle_num;
            
            $arr['start_city']  = (string) optional($model->cityRel)->title;
	        $arr['start_state'] = (string) optional($model->stateRel)->title;
	        $arr['start_date']  = (string)$this->get('start_date', $model);
	        $arr['end_date']    = (string)$this->get('end_date', $model);
            return $arr;
            
        } catch (\Exception $e) {
            return $arr;
        }

    }
}