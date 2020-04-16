<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\ProductFavourite as ProductFavouriteResource;

class OrderDetailsCollection extends ResourceCollection
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

            $options = new OrderDetailsOptionCollection($data->options);
            $price = ($data->price*$data->qty);
            if($options){
                foreach ($options as $option){
                    $price+=$option['price']*$option['qty'];
                }
            }

                return [
                        'item_id'=>$data->id,
                        'price'=>$price,
                        'qty'=>$data->qty,
                        'product'=> new ProductFavouriteResource($data->product),
                    'options'=>$options,
                    'ingredients'=>new OrderDetailsIngredientCollection($data->ingredients)
                    ] ;

            });
    }
}
