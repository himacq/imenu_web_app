<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Message extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if($this->message_type==1)
              $message_type = trans('messages.system_admin');
        if($this->message_type==2)
              $message_type = trans('messages.restaurants');
        if($this->message_type==3)
              $message_type = trans('messages.users');
        
        $receiver = trans('messages.system_admin');
        if($this->receiver)
            $receiver = $this->receiver->name;
        
        if($this->replies)
                $replies = $this->replies->count();
        
        return [
            'sender_id'=>$this->sender_id,
            'sender_name'=>$this->sender->name,
            'receiver_id'=>$this->receiver_id,
            'receiver_name'=>$receiver,
            'title'=>$this->title,
            'message'=>$this->message,
            'isSeen'=>$this->isSeen,
            'message_type'=>$message_type,
            'replies_count'=>$replies,
            'sent_at'=>$this->created_at->format('Y-m-d H:i:s'),
            'replies'=>new MessageRepliesCollection($this->replies)
        ];
    }
}
