<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantBranches extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $ranks = 0;
                if($this->reviews){
                    if($this->reviews->count())
                    $ranks = number_format($this->reviews->sum('review_rank')/$this->reviews->count(),2);
                }
                
        return [
                    'id' => $this->id,
                    'name' => $this->translate('name'),
                    'logo' => url('/uploads/restaurants/logos/'.($this->logo?$this->logo:'default.png')),
                    'banner' => url('/uploads/restaurants/banners/'.($this->banner?$this->banner:'default.jpg')),
                    'category' => $this->category,
                    'category_text' => ($this->category_text?$this->category_text->translate('display_text'):null),
                    'owner_id' => $this->owner_id,
                    'owner_name' => ($this->owner?$this->owner->name:null),
                    'latitude' => $this->latitude,
                    'longitude' => $this->longitude,
                    'extra_info' => $this->translate('extra_info'),
                    'phone1' => $this->phone1,
                    'phone2' => $this->phone2,
                    'phone3' => $this->phone3,
                    'mobile1' => $this->mobile1,
                    'mobile2' => $this->mobile2,
                    'email' => $this->email,
                    'branch_of' => $this->branch_of,
                    'branch_of_name' => ($this->main_branch?$this->main_branch->translate('name'):null),
                    'created_at'=>date('d-m-Y', strtotime($this->created_at)),
                    'reviews_count'=>$this->reviews->count(),
                    'rank' => $ranks,
                    

                ];
        
 
    }
    
    
}
