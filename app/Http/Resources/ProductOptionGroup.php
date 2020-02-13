<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductOptionGroup extends JsonResource
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
            'id' => $this->id,
            'name' => $this->translate('name'),
            'isActive' => $this->isActive,
            'minimum' => $this->minimum,
            'maximum' => $this->maximum,
            'options'=>new ProductOptionCollection($this->options->where('isActive',1)),
            ];
    }
}
