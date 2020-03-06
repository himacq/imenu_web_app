<?php

namespace App\Models;


class MessageReply extends BaseModel
{
    protected $fillable = ['message_id','sender_id','message','isSeen'];
    
    public function sender(){
        return $this->belongsTo('App\Models\User','sender_id','id');
    }
}
