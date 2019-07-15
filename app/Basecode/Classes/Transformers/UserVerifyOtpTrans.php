<?php

namespace App\Basecode\Classes\Transformers;


use App\User;
use App\Basecode\Classes\Repositories\DocumentRepository;

class UserVerifyOtpTrans extends TransformerAbstract {

    public function parseModel ( $model, $attrs = null ) {

        $arr = [];
        try {
            $arr['name']        = (string)$this->get('name', $model);
            $arr['email']       = (string)$this->get('email', $model);
            $arr['mobile_no']   = (string) $this->get('mobile_no', $model);
            $arr['is_verified'] = (int)$this->get('is_verified', $model);

            if( $model->type == User::INDIVIDUAL_CUSTOMER ) {
                $arr['user_type'] = 'individual_customer';
            } elseif( $model->type == User::COMMERCIAL_CUSTOMER ) {
                $arr['user_type'] = 'commercial_customer';
            } elseif( $model->type == User::VENDOR) {
                $arr['user_type'] = 'vendor';
                $arr['vendor_id'] = $this->get('id', $model);
            } elseif($model->type == User::DRIVER ) {
                $arr['user_type'] = 'driver';
            } else {
                $arr['user_type'] = '';
            }

            if(in_array($model->type, [User::INDIVIDUAL_CUSTOMER, User::COMMERCIAL_CUSTOMER])) {
                $referedByCode = optional(optional(optional($model->referralCodeRel)->referredByRel)->referralCodeRel)->referral_code;
                $arr['referral_code'] = optional($model->referralCodeRel)->referral_code;
                $arr['referred_by_code'] = !($referedByCode) ? '' : $referedByCode;
            }

            $arr['aadhar']        = (string) $this->get('aadhar', $model);
            $arr['pan']           = (string) $this->get('pan', $model);
            $arr['company']       = (string) $this->get('company', $model);
            $arr['gstin']         = (string) $this->get('gstin', $model);
            $arr['image']         = (string) getImageUrl($this->get('image', $model));
            $arr['address']       = (string) $this->get('address', $model);
            $arr['city']          = (string) optional($model->cityRel)->title;
            $arr['state']         = (string) optional($model->stateRel)->title;
            $arr['postcode']      = (string) $this->get('postcode', $model);
            $arr['license_no']    = (string) $this->get('license_no', $model);
            
            $arr['status']        = (string) $this->get('status', $model);
            $arr['created_at']    = (string) $this->get('created_at', $model);
            $arr['document_arr']  = $model->documentsRel()->get(['name', 'image', 'site']);

            $count = (new DocumentRepository)->checkDocsCount();

            if( $count ) {
                $arr['is_document_uploaded'] = true;
            } else {
                $arr['is_document_uploaded'] = false;
            }

            return $arr;
        } catch (\Exception $e) {
            return $arr;
        }

    }


}
