<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Order extends JsonResource
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
            'grand_total' =>$this->grand_total,
            'payment_method_id'=>$this->payment_id,
            'payment_method_name'=>$this->payment_method->translate('name'),
            'address_id'=>$this->address_id,
            'address'=>$this->address,
            'items'=> new OrderRestaurantsCollection($this->orderRestaurants)
            ];
    }
}
