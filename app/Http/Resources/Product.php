<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
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
            'name'=>$this->translate('name'),
            'image'=> url('/uploads/products/'.($this->image?$this->image:'default.jpg')),
            'isActive'=>$this->isActive,
            'price'=>$this->price,
            'minutes_required'=>$this->minutes_required,
            'category_id'=>$this->category_id,
            'category_name'=>$this->category->translate('name'),
            'ingredients'=>$this->ingredients->where('isActive',1),
            'option_groups'=>new ProductOptionGroupCollection($this->option_groups->where('isActive',1)),
        ];
    }
}
