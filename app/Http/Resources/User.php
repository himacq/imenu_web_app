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

        // count cart items
        if($this->getCart->cartRestaurants){
            $restaurants = $this->getCart->cartRestaurants;
            foreach ($restaurants as $restaurant){
                $products = $restaurant->products;

                $cart_items+=$products->sum('qty');
            }

        }


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
            'news_letter'=>$this->news_letter,
            'api_token'=>$this->api_token,
            'cart_items'=>$cart_items,
            'favourites'=>$this->getFavourites->count(),
        ];
    }
}
