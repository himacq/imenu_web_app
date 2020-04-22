<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\OrderDetailsCollection;

class OrderRestaurantsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return  $this->collection->transform(function ($data) {
             $products = new OrderDetailsCollection($data->products);
             $result_distance_time = $this->calculate_distance_time($data->address->latitude,$data->address->longitude,
                 $data->restaurant->latitude ,$data->restaurant->longitude);
            $distance = trans('main.undefined');
            $duration = trans('main.undefined');

             if($result_distance_time){
                 $distance = $result_distance_time['distance']->text;
                 $duration = $result_distance_time['duration']->text;
             }


            return [
                            'id'=>$data->id,
                            'restaurant_id'=>$data->restaurant_id,
                            'sub_total'=>$data->sub_total,
                            'restaurant_name'=>$data->restaurant->translate('name'),
                            'logo' => url('/uploads/restaurants/logos/'.($data->restaurant->logo?$data->restaurant->logo:'default.png')),
                            'payment_method_id'=>$data->payment_id,
                            'payment_method_name'=>($data->payment_id?$data->payment_method->translate('name'):trans('main.undefined')),
                            'address_id'=>$data->address_id,
                            'address'=>$data->address,
                            'distance_text'=>$distance,
                            'duration_text'=>$duration,
                            'status'=>new OrderStatusCollection($data->status),
                            'items'=>$products

                    ] ;

            });
    }

    private function calculate_distance_time($lat1,$long1,$lat2,$long2){
        $result = array();


        $url = "https://maps.googleapis.com/maps/api/directions/json?origin=$lat1,$long1"
            ."&destination=$lat2,$long2&key=".\Config::get('settings.google_map_key');
        $request = json_decode(file_get_contents($url));

         if($request->status=='NOT_FOUND'){
            return false;
        }

        $result['distance'] = $request->routes[0]->legs[0]->distance;
        $result['duration'] = $request->routes[0]->legs[0]->duration;

        return $result;
    }
}
