<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Classification extends JsonResource
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
            'image'=> url('/uploads/classifications/'.($this->image?$this->image:'default.jpg')),
            'isActive'=>$this->isActive
        ];
    }
}
