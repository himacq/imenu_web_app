<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MessageCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        
        
        return  $this->collection->transform(function ($data) {
             if($data->message_type==1)
              $message_type = trans('messages.system_admin');
            if($data->message_type==2)
                  $message_type = trans('messages.restaurants');
            if($data->message_type==3)
                  $message_type = trans('messages.users');

            $receiver = trans('messages.system_admin');
            if($data->receiver)
                $receiver = $data->receiver->name;
            
            if($data->replies)
                $replies = $data->replies->count();
            
                return [
                        'id'=>$data->id,
                        'sender_id'=>$data->sender_id,
                        'sender_name'=>$data->sender->name,
                        'receiver_id'=>$data->receiver_id,
                        'receiver_name'=>$receiver,
                        'title'=>$data->title,
                        'message'=>$data->message,
                        'isSeen'=>$data->isSeen,
                        'message_type'=>$message_type,
                        'replies_count'=>$replies,
                        'sent_at'=>$data->created_at->format('Y-m-d H:i:s')
                    ];
                        
            });
    }
}
