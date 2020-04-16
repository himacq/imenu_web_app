<?php

namespace App\Http\Resources;

use App\Http\Resources\PaymentMethod as PaymentMethodResource;
use App\Models\RestaurantPaymentMethod;
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
                            'restaurant_id'=>$data->restaurant_id,
                            'sub_total'=>$data->sub_total,
                            'restaurant_name'=>$data->restaurant->translate('name'),
                            'restaurant_payment_methods'=> PaymentMethodResource::Collection($data->restaurant->payment_methods),
                            'items'=>$products

                    ] ;

            });
    }
}
