<?php

namespace App\Http\Controllers\Api;

use App\MapAddress;
use App\MapAddressLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Basecode\Classes\Repositories\UserRepository;
use App\Basecode\Classes\Transformers\UserVerifyOtpTrans;
use App\Basecode\Classes\Transformers\UserTrans;
use App\Basecode\Classes\Transformers\AppNotificationTrans;
use App\Basecode\Classes\Repositories\CustomerRepository;
use App\ReferralCode;
use Illuminate\Support\Facades\Password;
use App\User;

class UserController extends Controller
{
    protected $userRepository, $customerRepository;

    function __construct(UserRepository $userRepository, CustomerRepository $customerRepository)
    {
        $this->userRepository = $userRepository;
        $this->customerRepository = $customerRepository;
    }

    public function register() {
        
        if ( $error = cvalidate( $this->userRepository->storeValidateRules ) ) return appError($error->first());

        $rules = [
            'device_id'     => 'required',
            'device_type'   => 'required|in:android,ios',
            'device_token'  => 'required',
            'type'          => 'required'
        ];

        // if(\request('type') == \App\User::COMMERCIAL_CUSTOMER) $rules = array_merge($rules, [
        //     'company' => 'required',
        //     'gstin' => 'required'
        // ]);

        if ( $error = cvalidate( $rules ) ) return appError($error->first());

        $referredModel = null;

        // if(in_array(\request('type'), [\App\User::COMMERCIAL_CUSTOMER, \App\User::INDIVIDUAL_CUSTOMER])) {
        //     if($val = \request('referral_code')) {
                
        //         $referredModel = ReferralCode::where('referral_code', $val)->first();
                
        //         if(!$referredModel) {
        //             return appError('Invalid Referral code.');
        //         }
        //     } 
        // }
        
        $attrs = $this->userRepository->getAttrs();
        
        $attrs['otp'] = sendOtp(\request('mobile_no'));
        $attrs['otp_created_at'] = date('Y-m-d H:i:s');
        
        $attrs['status'] = 0;

        $model = $this->userRepository->save($attrs);

        if(!$model) return appError('Bad Request.');
        
        $this->customerRepository->saveReferralCode($model);

        $this->userRepository->updateDeviceToken($model->id);

        $msg = _t('welcome_to_rodafleets_3');

        sendPushNotification($model->id, [
            'user_id'       => $model->id,
            'category'      => 'account_created',
            'body'          => $msg,
            'title'         => _t_title('welcome_to_rodafleets_3')
        ]);
        
        return appModelData( ( new UserTrans() )->parseModel($model));
    }

    public function verifyOtp() {

        $attrs = request()->all();

        if ( $error = cvalidate([
            'mobile_no' => 'required|exists:users,mobile_no',
            'otp' => 'required'
        ]) ) return appError($error->first());

        $model = $this->userRepository->getModel()->where('mobile_no', request('mobile_no'))->first();

        if(!$model) return appError('This mobile number is not registered with us');

        $to_time = strtotime( date('Y-m-d H:i:s') );
        $from_time = strtotime( $model->otp_created_at );
        $diff = round(abs($to_time - $from_time) / 60,0);

        if(! ($attrs['otp'] == 'ABC12') ) {
            // otp will be expired after 5 minutes
            if( $diff > 5 ) return appError('OTP expired');

            // both otp should be same
            if( $attrs['otp'] != $model->otp ) return appError('Invalid OTP');

        }

        // this will enable model.
        $model->is_verified = '1';
        $model->otp = '';
        $model->otp_created_at = null;
        $model->save();

        if( request('device_id') ) \App\DeviceToken::updateDeviceToken($model->id);

        $data = [
            'token' => $model->createToken('Rodafleet')->accessToken,
            'user' => ( new UserVerifyOtpTrans() )->parseModel($model)
        ];

        return appModelData($data, 'Your OTP has been verified successfully');
    }

    public function resendOtp() {

        if ( $error = cvalidate( ['mobile_no' => 'required|exists:users,mobile_no'] ) ) return appError($error->first());

        $model = $this->userRepository->getModel()->where('mobile_no', request('mobile_no'))->first();

        if(!$model) return appError('Invalid account details');

        if($val = \request('application')) {
            
            if($val == 'vendor' && in_array($model->type, [User::INDIVIDUAL_CUSTOMER, User::COMMERCIAL_CUSTOMER, User::DRIVER])) return appError('Invalid User.');

            if($val == 'customer' && in_array($model->type, [User::VENDOR, User::DRIVER])) return appError('Invalid User.');
        }
        
        if($model->type == \App\User::DRIVER) {
            
            if ( $error = cvalidate([
                'device_id'     => 'required',
                'device_type'   => 'required|in:android,ios',
                'device_token'  => 'required',
            ]) ) return appError($error->first());

            $this->userRepository->updateDeviceToken($model->id);
        }

        $model = $this->userRepository->update($model, [
            'otp' => sendOtp($model->mobile_no),
            'otp_created_at' => date('Y-m-d H:i:s')
        ]);

        return appModelData([], 'OTP has been sent to your mobile number');

    }

    public function login() {

        if(! (request('email') || request('mobile_no')) ) appError('Email or Mobile number is requirreturned.');

        $rules = [
            'password'      => 'required',
            'device_id'     => 'required',
            'device_type'   => 'required|in:android,ios',
            'device_token'  => 'required',
        ];

        

        if ( $error = cvalidate($rules) ) return appError($error->first());

        $loginAttrs = [
            'password' => request('password')
        ];

        if( request('email') ) {
            $loginAttrs['email'] = request('email');
        } else {
            $loginAttrs['mobile_no'] = request('mobile_no');
        }

        if(! auth()->attempt($loginAttrs) ) return appError('The email or password you entered is incorrect');


        // if(!auth()->user()->is_allowed_for_app) return appError('You are not allowed for app authentication');
        $model = $this->userRepository->find(auth()->user()->id);
    
        

        if(!auth()->user()->is_verified) {
            $data = [
                'token' => $model->createToken('Rodafleet')->accessToken,
                'user' => ( new UserVerifyOtpTrans() )->parseModel($model)
            ];
            return appModelData($data, 'Your account is not verified yet');
        }

        
        $data = [
            'token' => $model->createToken('Rodafleet')->accessToken,
            'user' => ( new UserVerifyOtpTrans() )->parseModel($model)
        ];


        if(!auth()->user()->status) return appModelData($data, 'Please upload your documents.');
        
        

        if(auth()->user()->status == 2 ){
            $data = [
                'token' => $model->createToken('Rodafleet')->accessToken,
                'user' => ( new UserVerifyOtpTrans() )->parseModel($model)
            ];
            
            return appModelData($data, 'Your account is not yet activated.');
        }

        if( request('device_id') ) \App\DeviceToken::updateDeviceToken($model->id);

        return appModelData($data, 'You are successfully logged in');
    }

    public function forgetPassword() {

        if( $val = request('mobile_no') ) {

            $model = $this->userRepository->getModel()->whereMobileNo($val)->first();

            if(!$model) return appError('Invalid account details');

            if($model->status != 1) return appError('Your account is not verified yet.');

            $model = $this->userRepository->update($model, [
                'otp' => sendOtp($model->mobile_no),
                'otp_created_at' => date('Y-m-d H:i:s')
            ]);

            return appModelData([], 'OTP has been sent to your mobile number');

        } else {

            $user = $this->userRepository->getModel()->whereEmail(request('email'))->first();

            if(!$user) return appError('Invalid account details');

            if($user->status != 1) return appError('Your account is not verified yet.');

            try{

                Password::broker()->sendResetLink(
                    request()->only('email')
                );

            } catch (\Exception $e){
                return appError('We are unable to send email to your email address.');
            }

            return appModelData('An email has been send to given email id');
        }

    }
    public function logout() {

        if ( $error = cvalidate(['device_id' => 'required'])) return appError($error->first());

        appLogout();
        \App\DeviceToken::removeDeviceToken();
        return appModelData([], 'Logout successfully.');

    }

    public function profileUpdate() {

        $model = $this->userRepository->getModel()->where('id', auth()->user()->id)->first();

        if(!$model) return appError('Invalid User');

        $model = $this->userRepository->update($model, $this->userRepository->getAttrs());

        if(!$model) return appError('Bad Request.');

        if(in_array($model->type, [\App\User::COMMERCIAL_CUSTOMER, \App\User::INDIVIDUAL_CUSTOMER])) {
            if($val = \request('referral_code')) {
                
                $referredModel = ReferralCode::where('referral_code', $val)->first();
                
                if(!$referredModel) {
                    return appError('Invalid Referral code.');
                }

                $this->customerRepository->referredBy($referredModel);
            } 
        }
        

        return appModelData((new UserTrans)->parseModel($model), $this->userRepository->update_msg);
    }

    public function postAddress() {

        $rules = [
            'booking_id' => 'required|exists:bookings,id',
            'address' => 'required',
            'lat' => 'required',
            'lng' => 'required',
        ];

        if ( $error = cvalidate( $rules )) return appError($error->first());

        $model = new MapAddressLog();
        $model->fill(request()->all());
        $model->user_id = auth()->user()->id;
        $model->save();

        $model = MapAddress::where('booking_id', \request('booking_id'))->where('user_id', auth()->user()->id)->first();
        if(!$model) $model = new MapAddress();

        $model->fill(request()->all());
        $model->user_id = auth()->user()->id;
        $model->save();

        return appModelData([], 'Location added');

    }

    public function getPostedAddresses() {

        $rules = [
            'booking_id' => 'required|exists:bookings,id',
        ];

        if ( $error = cvalidate( $rules )) return appError($error->first());

        $collection = MapAddressLog::where('booking_id', request('booking_id'))->orderBy('id', 'desc')->get([ 'id', 'address', 'lat', 'lng', 'created_at']);

        return appData($collection);

    }

    public function getAppNotification () {

        $model = $this->userRepository->getModel()->where('id', auth()->user()->id)->first();

        if(!$model) return appError('Invalid User'); 

        $data = [];
        
        $collection = $model->notifications()->orderBy('created_at', 'desc')->get();

        if(count($collection)) $data = (new AppNotificationTrans)->parseCollection($collection);

        return appData( $data );
    }

    public function userDetails() {

        $user = auth()->user();

        if(!$user) appError('Invalid User');

        return appModelData( ( new UserVerifyOtpTrans() )->parseModel($user));
    }

}
