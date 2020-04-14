<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\RestaurantFavourite as RestaurantResource;


class FavouriteRestaurant extends JsonResource
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
            'id' =>$this->id,
            'created_at'=>$this->created_at->format('Y-m-d H:i:s'),
            'restaurant'=> new RestaurantResource($this->restaurant)
            ];
    }
}
