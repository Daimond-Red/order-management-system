<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    // for more field (image, expire_date, license_no, dl_type, vendor_id)
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile_no',
        'aadhar',
        'pan',
        'company',
        'gstin',
        'type',
        'status',
        'address',
        'is_verified',
        'otp',
        'otp_created_at',
        'pan_image',
        'aadhar_image',
        'gstin_image',
        'cin_image',
        'vendor_id',
        'image',
        'expire_date',
        'license_no',
        'dl_type',
        'current_lat',
        'current_lng',
        'state_id',
        'city_id',
        'postcode',
        'is_set_location',
    ];

    const SUPERADMIN = 1;
    const INDIVIDUAL_CUSTOMER = 2;
    const COMMERCIAL_CUSTOMER = 3;
    const VENDOR = 4;
    const DRIVER = 5;


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setOtpCreatedAtAttribute($value) {
        try{
            $this->attributes['otp_created_at'] = date('Y-m-d H:i:s', strtotime($value));
        } catch (\Exception $e) {

        }
    }

    // expire_date
    public function setExpireDateAtAttribute($value) {
        $this->attributes['expire_date'] = date('Y-m-d', strtotime($value));
    }

    public function getExpireDateAtAttribute($value) {
        return getDateValue($this->attributes['expire_date']);
    }

    public function documentsRel () {
        return $this->hasMany(Document::class, 'user_id');
    }

    public function stateRel() {
        return $this->belongsTo(State::class, 'state_id');
    }

    // public function cityRel() {
    //     return $this->belongsTo(City::class, 'state_id');
    // }

    public function cityRel() {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function vendorRel() {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function customerBookingRel() {
        return $this->hasMany(Booking::class, 'customer_id');
    }

    public function vendorBookingRel() {
        return $this->hasMany(Booking::class, 'vendor_id');
    }


    public function queryRel() {
        return $this->hasMany(ContactUs::class, 'user_id');
    }

    public function driverBookingsRel() {

        return $this->hasMany(AssignVehicleDriver::class, 'driver_id');
    }
    

    public function notifications() {
        return $this->belongsToMany(AppNotification::class);
    }

    public function referralCodeRel() {
        return $this->hasOne(ReferralCode::class, 'user_id');
    }

    public function vehiclesRel () {
        return $this->hasMany(Vehicle::class, 'user_id');
    }
}
