<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RatingReview extends Model
{
    protected $fillable = [
    	'booking_id',
    	'rated_by_id',
    	'rated_id',
    	'rating',
    	'review',
    ];
}
