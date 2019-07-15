<?php

namespace App\Basecode\Classes\Transformers;




class BookingBidTrans extends TransformerAbstract {

    public function parseModel ( $model, $attrs = null ) {

        $arr = [];
        try {
            $arr['amount']              = (string) $this->get('amount', $model);
            $arr['status']              = (string) $this->get('status', $model);
            $arr['pickup_date_time']    = (string) $this->get('pickup_date_time', $model);
            return $arr;
        } catch (\Exception $e) {
            return $arr;
        }

    }

    public function parseLogsCollection($collection, $fields = []) {
        $data = [];
        foreach($collection as $model) $data[] = $this->parseLogModel($model, $fields);
        return $data;
    }

    public function parseLogModel ( $model, $attrs = null ) {

        $arr = [];
        try {
            // $arr['data']                = (string) $this->get('data', $model);
            $arr['status']              = (string) $this->get('status', $model);
            $arr['created_at']          = (string) $this->get('created_at', $model);
            return $arr;
        } catch (\Exception $e) {
            return $arr;
        }

    }
}