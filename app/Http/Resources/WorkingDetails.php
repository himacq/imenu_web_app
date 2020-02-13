<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkingDetails extends JsonResource
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
            'day'=>$this->translate('display_text'),
            'start_at'=>\Carbon\Carbon::createFromFormat('H:i:s',$this->start_at)->format('H:i'),
            'end_at'=>\Carbon\Carbon::createFromFormat('H:i:s',$this->end_at)->format('H:i'),
            
        ];
    }
}
