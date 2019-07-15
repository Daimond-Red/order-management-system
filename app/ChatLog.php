<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatLog extends Model
{
    protected $fillable = [
    	'chat_id',
    	'sender_id',
    	'receiver_id',
    	'receiver_id_2',
    	'message'
    ];

    public function senderRel() {
    	return $this->belongsTo(User::class, 'sender_id');
    }
}
