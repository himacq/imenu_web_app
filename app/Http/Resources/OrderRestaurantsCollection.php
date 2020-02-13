<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\OrderDetailsCollection;

class OrderRestaurantsCollection extends ResourceCollection
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
             $products = new OrderDetailsCollection($data->products);
                return [
                            'id'=>$data->id,
                            'restaurant_id'=>$data->restaurant_id,
                            'sub_total'=>$data->sub_total,
                            'restaurant_name'=>$data->restaurant->translate('name'),
                            'status'=>new OrderStatusCollection($data->status),
                            'products'=>$products
                       
                    ] ;
                        
            });
    }
}
