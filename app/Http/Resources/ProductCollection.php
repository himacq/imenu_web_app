<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data'=> $this->collection->transform(function ($data) {
                return [
                        'id'=>$data->id,
                        'name'=>$data->translate('name'),
                        'image'=> url('/uploads/products/'.($data->image?$data->image:'default.jpg')),
                        'isActive'=>$data->isActive,
                        'price'=>$data->price,
                        'description'=>$data->description,
                        'minutes_required'=>$data->minutes_required,
                        'category_id'=>$data->category_id,
                        'category_name'=>$data->category->translate('name'),
                        'restaurant_id'=>$data->category->restaurant_id,
                        'restaurant_name'=>$data->category->restaurant->name,
                    ] ;

            }),

        ];
    }
}
