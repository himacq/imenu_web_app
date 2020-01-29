<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\ProductFavourite as ProductFavouriteResource;
use App\Http\Resources\CartDetailsOptionCollection;

class CartDetailsCollection extends ResourceCollection
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
                        'id'=>$data->id,
                        'price'=>$data->price,
                        'qty'=>$data->qty,
                        'product'=> new ProductFavouriteResource($data->product),
                        'options'=>new CartDetailsOptionCollection($data->options)
                    ] ;
                        
            });
    }
}
