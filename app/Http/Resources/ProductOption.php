<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductOption extends JsonResource
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
            'option_id' => $this->id,
            'name' => $this->translate('name'),
            'isActive' => $this->isActive,
            'minutes_required' => $this->minutes_required,
            'price' => $this->price,
            ];
    }
}
