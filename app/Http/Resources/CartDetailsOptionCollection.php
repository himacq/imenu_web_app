<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CartDetailsOptionCollection extends ResourceCollection
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
                        //'qty'=>$data->qty,
                        'product_option_id'=>$data->product_option_id,
                        'product_option_name'=>$data->option->translate('name'),
                    ] ;

            });
    }
}
