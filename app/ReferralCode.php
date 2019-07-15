<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReferralCode extends Model
{
    protected $fillable = [
    	'user_id',
		'referral_code',
		'referred_by_id',
    ];

    public function userRel() {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function referredByRel() {
    	return $this->belongsTo(User::class, 'referred_by_id');
    }

    // public static function get
}
