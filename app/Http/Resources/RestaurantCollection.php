<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RestaurantCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data'=> $this->collection->transform(function ($data) {
                return [
                    'id' => $data->id,
                    'name' => $data->translate('name'),
                    'logo' => url('/uploads/restaurants/logos/'.($data->logo?$data->logo:'default.png')),
                    'banner' => url('/uploads/restaurants/banners/'.($data->banner?$data->banner:'default.jpg')),
                    'status' => $data->status,
                    'status_text' => ($data->status_text?$data->status_text->translate('display_text'):null),
                    'manager_id' => $data->manager_id,
                    'manager_name' => ($data->manager?$data->manager->name:null),
                    'latitude' => $data->latitude,
                    'longitude' => $data->longitude,
                    'working_details' => $data->translate('working_details'),
                    'extra_info' => $data->translate('extra_info'),
                    'phone1' => $data->phone1,
                    'phone2' => $data->phone2,
                    'phone3' => $data->phone3,
                    'mobile1' => $data->mobile1,
                    'mobile2' => $data->mobile2,
                    'email' => $data->email,
                    'branch_of_name' => ($data->main_branch?$data->main_branch->translate('name'):null),
                    'ranks_sum'=>$data->reviews->sum('review_rank'),
                    'reviews_count'=>$data->reviews->count(),
                    //'average_rating' => $this->reviews->avg('review_rank')

                ];
                        
            }),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
    
    
}
