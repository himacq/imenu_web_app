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

        $ranks = 0;
        if($this->reviews){
            if($this->reviews->where('isActive',1)->count()>0)
                $ranks = number_format($this->reviews->where('isActive',1)->sum('review_rank')/$this->reviews->where('isActive',1)->count(),2);

        }

        return [
            'product_id'=>$this->id,
            'name'=>$this->translate('name'),
            'image'=> url('/uploads/products/'.($this->image?$this->image:'default.jpg')),
            'isActive'=>$this->isActive,
            'price'=>$this->price,
            'minutes_required'=>$this->minutes_required,
            'rank'=>$ranks,
            'reviews_count'=>$this->reviews->where('isActive',1)->count(),
            'reviews'=>$this->reviews->where('isActive',1),
            'category_id'=>$this->category_id,
            'category_name'=>$this->category->translate('name'),
            'restaurant_id'=>$this->category->restaurant_id,
            'restaurant_name'=>$this->category->restaurant->name,
            'ingredients'=>$this->ingredients->where('isActive',1),
            'option_groups'=>new ProductOptionGroupCollection($this->option_groups->where('isActive',1)),
        ];
    }
}
