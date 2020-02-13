<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\CartDetailsCollection;

class CartRestaurantsCollection extends ResourceCollection
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
             $products = new CartDetailsCollection($data->products);
                return [
                            'restaurant_id'=>$data->id,
                            'sub_total'=>$data->sub_total,
                            'restaurant_name'=>$data->restaurant->translate('name'),
                            'items'=>$products
                       
                    ] ;
                        
            });
    }
}
