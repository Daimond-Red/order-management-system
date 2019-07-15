<?php

namespace App\Basecode\Classes\Transformers;




class CustomerChatTrans extends TransformerAbstract {

    public function parseModel ( $model, $attrs = null ) {

        $arr = [];
        try {
            $arr['contact_us_id']        = (string) $this->get('contact_us_id', $model);
            $arr['is_admin']             = (string) $this->get('is_admin', $model);
            $arr['message']              = (string) $this->get('message', $model);
            

            return $arr;
        } catch (\Exception $e) {
            return $arr;
        }

    }
}