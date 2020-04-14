<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantFavourite extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $ranks = 0;
        if($this->reviews){
            if($this->reviews->where('isActive',1)->count()>0)
                $ranks = number_format($this->reviews->where('isActive',1)->sum('review_rank')/$this->reviews->where('isActive',1)->count(),2);

        }

        return [
            'restaurant_id'=>$this->id,
            'name' => $this->translate('name'),
            'logo' => url('/uploads/restaurants/logos/'.($this->logo?$this->logo:'default.png')),
            'phone1' => $this->phone1,
            'phone2' => $this->phone2,
            'phone3' => $this->phone3,
            'mobile1' => $this->mobile1,
            'mobile2' => $this->mobile2,
            'email' => $this->email,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'rank'=>$ranks,
        ];
    }
}
