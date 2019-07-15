<?php

namespace App\Basecode\Classes\Repositories;

use App\AppConfig;
use App\ReferralCode;

class CustomerRepository extends Repository {

    public $model = '\App\User';

    public $viewIndex = 'admin.customers.index';
    public $viewCreate = 'admin.customers.create';
    public $viewEdit = 'admin.customers.edit';
    public $viewShow = 'admin.customers.show';

    public $storeValidateRules = [
        'name'          => 'required',
        'email'         => 'required|email|unique:users,email',
        'password'      => 'required',
    ];

    public $updateValidateRules = [
        'name'          => 'required',
    ];

    public function getCollection($withFilters = true) {
        $model = new $this->model;
        $model = $model->orderBy('created_at', 'desc')->whereIn('type', [\App\User::INDIVIDUAL_CUSTOMER, \App\User::COMMERCIAL_CUSTOMER]);

        $whereLikefields = ['first_name', 'last_name', 'email', 'pancard_no', 'signup_type' ];

        foreach ($whereLikefields as $field) {
            if( $value = request($field) ) $model = $model->where($field, 'like', '%'.$value.'%');
        }

        if(  array_key_exists('status', request()->all()) && request('status') == 0 ) $model = $model->where('status', 0);
        if( request('status') == 1 ) $model = $model->where('status', 1);

        return $model;
    }

    public function find( $id ) {
        $model = $this->model;
        $model = $model::find($id);
        if( !in_array($model->type, [\App\User::INDIVIDUAL_CUSTOMER, \App\User::COMMERCIAL_CUSTOMER])) throw new  \Illuminate\Database\Eloquent\ModelNotFoundException;
        return $model;
    }

    public function save( $attrs ) {

        $model = new $this->model;
        $model->fill($attrs);
        
        if( isset($attrs['type']) ) $model->type = $attrs['type']; // it's needed

        $model->save();

        return $model;

    }

    public function update($model, $attrs = null) {
        
        if(! $attrs ) $attrs = $this->getAttrs();
        
        $notify = false;

        if( $model->status != '1' ) $notify = true;
        
        $model->fill($attrs);

        $model->update();
        
        if((\request('status') && \request('status') == 1) && $notify) {
            
            $msg =  _t('account_activated_4');

            sendPushNotification($model->id, [
                'user_id'   => $model->id,
                'category'  => 'account_activated',
                'body'      => $msg,
                'title'     => _t_title('account_activated_4')
            ]);
        }

        return $model;
    }

    public function getAttrs()
    {
        $attrs = parent::getAttrs();
        // $attrs['type'] = \App\User::CUSTOMER;

        if( $pass = request('password') ) {
            $attrs['password'] = bcrypt($pass);
        } elseif( array_key_exists('password', $attrs) ) {
            unset($attrs['password']);
        }

        $uploads = ['pan_image', 'aadhar_image', 'gstin_image', 'cin_image'];
        
        
        foreach ( $uploads as $upload ) {
            if( request()->hasFile($upload) ){
                $attrs[$upload] = self::upload_file($upload, 'customers');
            } elseif( $attrs && count($attrs) && array_key_exists($upload, $attrs) ) {
                unset($attrs[$upload]);
            }
        }
        // dd($attrs);
        return $attrs;

    }

    public function getRatting($id){
        $ratting = \App\ReviewRating::where('rated_id', $id)->avg('rating');
        return number_format($ratting, 1, '.', '');
    }

    public function parseModel($model) {

        $arr = [];
        $arr['customer_id'] = (int)$this->prepare_field('id', $model);
        $arr['name'] = (string)$this->prepare_field('name', $model);
        $arr['email'] = (string)$this->prepare_field('email', $model);
        $arr['mobile_no'] = (string) $this->prepare_field('mobile_no', $model);
        $arr['status'] = (string)$this->prepare_field('status', $model);
        $arr['created_at'] = (string)$this->prepare_field('created_at', $model);
        // $arr['aadhar_no'] = (string)$this->prepare_field('aadhar_no', $model);
        // $arr['company_name'] = (string)$this->prepare_field('company_name', $model);
        // $arr['business_type'] = (string)$this->prepare_field('business_type', $model);
        // $arr['customer_type'] = (string)$this->prepare_field('customer_type', $model);
        $arr['gstin'] = (string)$this->prepare_field('gstin', $model);
        // $arr['dashboard_text'] = (string) Appconfig::get_config_value('appCustomer', 'customer_dashboard_text');
        return $arr;
    }


    public function saveReferralCode($userModel, $referredModel = null) {
        
        $permitted_chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $prefix = substr(str_shuffle($permitted_chars), 0, 3);

        $model = new ReferralCode;
        
        $model->user_id = $userModel->id;
        $model->referral_code = $prefix.str_pad($userModel->id, 3, "0", STR_PAD_LEFT);

        // if($referredModel) $model->referred_by_id = optional($referredModel->userRel)->id;

        $model->save();
    }

    public function referredBy($referredModel) {
        
        $model = ReferralCode::where('user_id', auth()->user()->id)->first();

        $model->referred_by_id = optional($referredModel->userRel)->id;

        $model->save();

    }
}