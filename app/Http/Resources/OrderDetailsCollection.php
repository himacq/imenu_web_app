<?php

namespace App\Http\Resources;

use App\Http\Resources\OrderDetailsOptionCollection;
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
                return [
                        'item_id'=>$data->id,
                        'price'=>$data->price,
                        'qty'=>$data->qty,
                        'product'=> new ProductFavouriteResource($data->product),
                    'options'=>new OrderDetailsOptionCollection($data->options),
                    'ingredients'=>new OrderDetailsIngredientCollection($data->ingredients)
                    ] ;

            });
    }
}
