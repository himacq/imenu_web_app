<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantReviews extends JsonResource
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
            'id'=>$this->id,
            'user_id'=>$this->user_id,
            'user_name'=>$this->user->name,
            'avatar'=> url('/uploads/avatars/'.($this->user->avatar?$this->user->avatar:'default.png')),
            'review_text'=> $this->review_text,
            'review_rank'=>$this->review_rank,
            'created_at'=>date('d-m-Y', strtotime($this->created_at))
        ];
    }
}
