<?php

namespace App\Basecode\Classes\Transformers;




class ContactUsTrans extends TransformerAbstract {

    public function parseModel ( $model, $attrs = null ) {

        $arr = [];
        try {
            
            $arr['contact_us_id']        = (string) $this->get('id', $model);
            $arr['status']               = (string) $this->get('status', $model);
            $arr['query']                = (string) $this->get('message', $model);
            $arr['created_at']           = (string) $this->get('created_at', $model);
            

            return $arr;
        } catch (\Exception $e) {
            return $arr;
        }

    }
}