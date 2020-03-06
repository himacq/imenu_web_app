<?php

namespace App\Models;


class Message extends BaseModel
{
    protected $fillable = ['message_type','sender_id','receiver_id','title','message','isSeen'];
    
    public function sender(){
        return $this->belongsTo('App\Models\User','sender_id','id');
    }
    
    public function receiver(){
        return $this->belongsTo('App\Models\User','receiver_id','id');
    }
    
    public function replies(){
        return $this->hasMany('App\Models\MessageReply','message_id','id');
    }
}
