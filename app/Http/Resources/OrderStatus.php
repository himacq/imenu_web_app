<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderStatus extends JsonResource
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
            'status' => $this->status,
            'status_text' => $this->status_text->translate('display_text'),
            'created_at' =>\Carbon\Carbon::parse($this->created_at)->format('d-M H:i')
            ];
    }
}
