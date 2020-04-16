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
            'start_at'=>($this->start_at?\Carbon\Carbon::createFromFormat('H:i:s',$this->start_at)
                ->format('H:i'):trans('main.undefined')),
            'end_at'=>($this->end_at?\Carbon\Carbon::createFromFormat('H:i:s',$this->end_at)->format('H:i')
            :trans('main.undefined')),

        ];
    }
}
