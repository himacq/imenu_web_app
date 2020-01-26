<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App;

class Restaurant extends JsonResource
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
            'logo' => $this->logo,
            'banner' => $this->banner,
            'status' => $this->status,
            'status_text' => $this->status_text->translate('display_text'),
            'manager_id' => $this->manager_id,
            'manager' => $this->manager->name,
            'branch_of' =>new Restaurant($this->main_branch),
            'branch_of_name' => ($this->main_branch?$this->main_branch->translate('name'):null),
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'working_details' => $this->translate('working_details'),
            'extra_info' => $this->translate('extra_info'),
            'phone1' => $this->phone1,
            'phone2' => $this->phone2,
            'phone3' => $this->phone3,
            'mobile1' => $this->mobile1,
            'mobile2' => $this->mobile2,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
         
         
    }
    
    
}
