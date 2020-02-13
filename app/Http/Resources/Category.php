<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Category extends JsonResource
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
            'id'=>$this->id,
            'name'=>$this->translate('name'),
            'image'=> url('/uploads/categories/'.($this->image?$this->image:'default.jpg')),
            'isActive'=>$this->isActive,
            'restaurant_id'=>$this->restaurant_id,
            'restaurant_name'=>$this->restaurant->translate('name')
        ];
    }
}
