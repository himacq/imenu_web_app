<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductFavourite extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'product_id'=>$this->id,
            'created_at'=>$this->created_at->format('Y-m-d H:i:s'),
            'name'=>$this->translate('name'),
            'image'=> url('/uploads/products/'.($this->image?$this->image:'default.jpg')),
            'isActive'=>$this->isActive,
            'price'=>$this->price,
            'description'=>$this->description,
            'minutes_required'=>$this->minutes_required,
            'category_id'=>$this->category_id,
            'category_name'=>$this->category->translate('name'),
            'restaurant_id'=>$this->category->restaurant_id,
            'restaurant_name'=>$this->category->restaurant->name,
        ];
    }
}
