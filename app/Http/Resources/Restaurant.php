<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App;

use App\Http\Resources\Manager as ManagerResource;
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
        /*$ranks = ($this->reviews->sum('review_rank')/$this->reviews->count());
        dd($ranks);*/
        return [
            'id' => $this->id,
            'name' => $this->translate('name'),
            'logo' => url('/uploads/restaurants/logos/'.($this->logo?$this->logo:'default.png')),
            'banner' => url('/uploads/restaurants/banners/'.($this->banner?$this->banner:'default.jpg')),
            'status' => $this->status,
            'status_text' => ($this->status_text?$this->status_text->translate('display_text'):null),
            'category' =>$this->category,
            'category_text' => ($this->category_text?$this->category_text->translate('display_text'):null),
            'manager_id' => $this->manager_id,
            'manager' => new ManagerResource($this->manager),
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'extra_info' => $this->translate('extra_info'),
            'phone1' => $this->phone1,
            'phone2' => $this->phone2,
            'phone3' => $this->phone3,
            'mobile1' => $this->mobile1,
            'mobile2' => $this->mobile2,
            'email' => $this->email,
            'branch_of_name' => ($this->main_branch?$this->main_branch->translate('name'):null),
            'ranks_sum'=>$this->reviews->sum('review_rank'),
            'reviews_count'=>$this->reviews->count(),
            'branch_of' =>new Restaurant($this->main_branch),
            'reviews'=>$this->reviews->where('isActive',1),
            'categories'=> new CategoryCollection($this->categories->where('isActive',1)),
            'working_details'=> new WorkingDetailsCollection($this->working_details)
        ];
         
         
    }
    
    
}
