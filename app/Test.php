<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = [
    	'name',
    	'phone',
    	'description',
    	'image',
    	'date',
    	'start_date_time',
    	'status',
    ];
}
