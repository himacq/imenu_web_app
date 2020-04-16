<?php

namespace App\Http\Resources;

use App\Http\Resources\CartDetailsIngredientCollection;
use App\Http\Resources\CartDetailsOptionCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\ProductFavourite as ProductFavouriteResource;

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
            $options = new CartDetailsOptionCollection($data->options);
            $ingredients = new CartDetailsIngredientCollection($data->ingredients);

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
                            'ingredients'=>$ingredients

                    ] ;

            });
    }
}
