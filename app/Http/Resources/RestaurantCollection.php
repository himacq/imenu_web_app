<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RestaurantCollection extends ResourceCollection
{
    private  $lat,$long;

    public function __construct($resource,$lat,$long)
    {
        parent::__construct($resource);

        $this->lat = $lat;
        $this->long = $long;
    }
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
                $ranks = 0;
                if($data->reviews){
                    if($data->reviews->count())
                    $ranks = number_format($data->reviews->sum('review_rank')/$data->reviews->count(),2);
                }

                return [

                    'id' => $data->id,
                    'name' => $data->translate('name'),
                    /*'logo' => url('/uploads/restaurants/logos/'.($data->logo?$data->logo:'default.png')),
                    'banner' => url('/uploads/restaurants/banners/'.($data->banner?$data->banner:'default.jpg')),
                    'classification' =>new RestaurantClassificationCollection($data->classifications),
                    'categories'=> new CategoryCollection($data->categories->where('isActive',1)),
                    'owner_id' => $data->owner_id,
                    'owner_name' => ($data->owner?$data->owner->name:null),
                    'latitude' => $data->latitude,
                    'longitude' => $data->longitude,
                    'extra_info' => $data->translate('extra_info'),
                    'phone1' => $data->phone1,
                    'phone2' => $data->phone2,
                    'phone3' => $data->phone3,
                    'mobile1' => $data->mobile1,
                    'mobile2' => $data->mobile2,
                    'email' => $data->email,
                    'branch_of' => $data->branch_of,
                    'branch_of_name' => ($data->main_branch?$data->main_branch->translate('name'):null),
                    'created_at'=>date('d-m-Y', strtotime($data->created_at)),
                    //'ranks_sum'=>$data->reviews->sum('review_rank'),
                    'reviews_count'=>$data->reviews->count(),
                    'rank' => $ranks,
                    'allowed_distance'=> number_format($data->distance,2),*/
                    'duration_value'=>$this->calculate_distance_time($data->latitude,$data->longitude)['duration']->value


                ];

            }),

        ];
    }

    public function calculate_distance_time($lat,$long){
        $url = "https://maps.googleapis.com/maps/api/directions/json?origin=$lat,$long"
            ."&destination=$this->lat,$this->long&key=".\Config::get('settings.google_map_key');
        $request = json_decode(file_get_contents($url));

        $result['distance'] = $request->routes[0]->legs[0]->distance;
        $result['duration'] = $request->routes[0]->legs[0]->duration;

        return $result;
    }


}
