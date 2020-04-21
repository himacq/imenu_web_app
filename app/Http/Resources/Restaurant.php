<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Owner as OwnerResource;
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
        $ranks = 0;
        if($this->reviews){
            if($this->reviews->where('isActive',1)->count()>0)
            $ranks = number_format($this->reviews->where('isActive',1)->sum('review_rank')/$this->reviews->where('isActive',1)->count(),2);

        }

        return [
            'id' => $this->id,
            'name' => $this->translate('name'),
            'isFavourite'=>$this->isFavourite,
            'logo' => url('/uploads/restaurants/logos/'.($this->logo?$this->logo:'default.png')),
            'banner' => url('/uploads/restaurants/banners/'.($this->banner?$this->banner:'default.jpg')),
            'classification' =>new RestaurantClassificationCollection($this->classifications),
            'owner_id' => $this->owner_id,
            'owner' => new OwnerResource($this->owner),
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
            'branch_of' =>new Restaurant($this->main_branch),
            'rank'=>$ranks,
            'reviews_count'=>$this->reviews->where('isActive',1)->count(),
            'reviews'=>new RestaurantReviewsCollection($this->reviews->where('isActive',1)),
            'categories'=> new CategoryCollection($this->categories->where('isActive',1)),
            'working_details'=> new WorkingDetailsCollection($this->working_details),
            'branches' =>new RestaurantBranchesCollection($this->branches)
        ];


    }


}
