<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CartDetailsCollection;

class Cart extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $products = new CartDetailsCollection($this->details);
        if(count($products)==0)
            $products = null;
        return [
            'id' =>$this->id,
            'grand_total' =>$this->grand_total,
            'products'=> $products
            ];
    }
}
