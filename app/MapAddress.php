<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MapAddress extends Model {

    protected $fillable = [
        'booking_id',
        'user_id',
        'address',
        'lat',
        'lng',
    ];

}
