<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageReplies extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'reply_id'=>$this->id,
            'message_id'=>$this->message_id,
            'sender_id'=>$this->sender_id,
            'sender_name'=>$this->sender->name,
            'message'=>$this->message,
            'isSeen'=>$this->isSeen,
            'sent_at'=>$this->created_at->format('Y-m-d H:i:s')
        ];
    }
}
