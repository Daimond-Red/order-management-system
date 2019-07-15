<?php

namespace App\Basecode\Classes\Transformers;

class AppNotificationTrans extends TransformerAbstract {

    public function parseModel ( $model, $attrs = null ) {

        $arr = [];
        try {
            $arr['title']         = (string)$this->get('title', $model);
            $arr['message']       = (string)$this->get('message', $model);
           
            $arr['created_at']    = (string) $this->get('created_at', $model);

            return $arr;
        } catch (\Exception $e) {
            return $arr;
        }

    }


}
