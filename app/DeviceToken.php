<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceToken extends Model
{
    protected $fillable = [
    	'user_id',
    	'device_id',
    	'device_type',
    	'device_token',
    	'lat',
    	'lng',
    ];


    public static function updateDeviceToken($userId) {

        try{
            $model = DeviceToken::where('device_id', request('device_id'))->first();
            if(! $model ) $model = new DeviceToken;

            $model->device_id = request('device_id', '');
            $model->device_token = request('device_token', '');
            $model->device_type = request('device_type');
            $model->lat = request('lat', '');
            $model->lng = request('lng', '');
            $model->user_id = $userId;
            $model->save();
        } catch (\Exception $e) {

        }
    }

    public static function removeDeviceToken() {

        try{
            $model = DeviceToken::where('device_id', request('device_id'))->first();
            if( $model ) $model->delete();
        } catch (\Exception $e) {

        }
    }
}
