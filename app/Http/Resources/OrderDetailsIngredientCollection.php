<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderDetailsIngredientCollection extends ResourceCollection
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
                        'product_ingredient_id'=>$data->product_ingredient_id,
                        'product_ingredient_name'=>$data->ingredient->translate('name'),
                    ] ;

            });
    }
}
