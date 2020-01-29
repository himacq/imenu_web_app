<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {     
        $cart_items = 0;
        
        if($this->getCart->getDetails)
            $cart_items = $this->getCart->getDetails->sum('qty');
        
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'email'=> $this->email,
            'isActive'=>$this->isActive,
            'username'=>$this->username,
            'phone'=>$this->phone,
            'mobile'=>$this->mobile,
            'language_id'=>$this->language_id,
            'restaurant_id'=>$this->restaurant_id,
            'latitude'=>$this->latitude,
            'longitude'=>$this->longitude,
            'news_letter'=>$this->news_letter,
            'api_token'=>$this->api_token,
            'cart_items'=>$cart_items,
            'favourites'=>$this->getFavourites->count(),
        ];
    }
}
