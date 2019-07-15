<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
    	'user_id',
    	'vehicle_id',
    	'name',
    	'image',
    	'url',
    	'site',
    	'type',
    ];

    const IMAGE_NAME = [
    	'aadhar' => 'Aadhar',
    	'pan' => 'Pan',
    	'gstin' => 'GSTIN',
        'dl' => 'DL',
        'permit' => 'Permit',
        'fitness' => 'Fitness',
        'insurence' => 'Insurence'
    ];

    const INDIVIDUAL_CUSTOMER_DOCS_COUNT = 2;
    const COMMERCIAL_CUSTOMER_DOCS_COUNT = 3;
    const VENDOR_DOCS_COUNT = 3;
    const VEHICLE_DOCS_COUNT = 3;
    const DRIVER_DOCS_COUNT = 1;
    

}
