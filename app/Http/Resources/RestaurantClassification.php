<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantClassification extends JsonResource
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
            'classification_id'=>$this->classification->id,
            'name'=>$this->classification->translate('name'),
            'image'=> url('/uploads/classifications/'.($this->classification->image?$this->classification->image:'default.jpg'))
        ];
    }
}
