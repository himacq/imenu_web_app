<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Models\Restaurant;
use App\Models\Lookup;
use App\Http\Resources\Restaurant as RestaurantResource;
use App\Http\Resources\RestaurantCollection ;
use Illuminate\Http\Request;
use App\Http\Resources\LookupCollection;

use Illuminate\Support\Facades\DB;

class RestaurantController extends ApiController
{  
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * categories of restaurants
     */
    public function restaurant_categories(){
            $categories = new LookupCollection(Lookup::where(['parent_id' =>\Config::get('settings.restaurant_categories')])->get());
        return $categories->additional(['status'=>true,'message'=>__('api.success')]);

    }
    /**
     * restaurants api services
     */
    
    public function withinMaxDistance(Request $request) {

        $restaurants = Restaurant::selectRaw('*, ( 111.045 * acos( cos( radians( ? ) ) * cos( radians( latitude ) )'
                . ' * cos( radians( longitude ) - radians( ? ) ) + sin( radians( ? ) )'
                . ' * sin( radians( latitude ) ) ) ) AS distance'
                , [$request->latitude, $request->longitude, $request->latitude])
                    ->having('distance', '<', $request->distance)
                    ->orderBy('distance')
                    ->get();
        
    return $restaurants;
    }

    public function listRestaurants(Request $request){
       $order = ($request->order?$request->order:"ASC");
       
        if($request->latitude && $request->longitude){
             $restaurants = Restaurant::selectRaw('*, ( 111.045 * acos( cos( radians( ? ) ) * cos( radians( latitude ) )'
                . ' * cos( radians( longitude ) - radians( ? ) ) + sin( radians( ? ) )'
                . ' * sin( radians( latitude ) ) ) ) AS distance '
                , [$request->latitude, $request->longitude, $request->latitude])
                    ->having('distance', '<', $request->distance)
                    ->having('status','=',\Config::get('settings.restaurant_status_accepted'));
                    //->paginate(\Config::get('settings.per_page'))
           if($request->category)
                $restaurants = $restaurants->having('category','=',$request->category);
           
          
           if($request->sort)
                    $restaurants = $restaurants->orderBy($request->sort,$order);
               
               $restaurants = $restaurants->simplePaginate(\Config::get('settings.per_page'));//(\Config::get('settings.per_page'));
        }
        else{
            $filter = ['status'=>\Config::get('settings.restaurant_status_accepted')];
       
            if($request->category)
               $filter['category'] =$request->category;

               $restaurants = Restaurant::where($filter);
               if($request->sort)
                    $restaurants = $restaurants->orderBy($request->sort,$order);
               
               $restaurants = $restaurants->paginate(\Config::get('settings.per_page'));
        }
        $restaurants = new RestaurantCollection($restaurants);

         
        return $restaurants->additional(['status'=>true,'message'=>__('api.success')]);
        
    }
    
    
     public function listRestaurantsX(Request $request){
       $order = ($request->order?$request->order:"ASC");
       
        if($request->latitude && $request->longitude){
           $restaurants = Restaurant::selectRaw('*, ( 111.045 * acos( cos( radians( ? ) ) * cos( radians( latitude ) )'
                . ' * cos( radians( longitude ) - radians( ? ) ) + sin( radians( ? ) )'
                . ' * sin( radians( latitude ) ) ) ) AS distance '
                , [$request->latitude, $request->longitude, $request->latitude])
                    ->having('distance', '<', $request->distance)
                    ->having('status','=',\Config::get('settings.restaurant_status_accepted'));
                    //->paginate(\Config::get('settings.per_page'))
           if($request->category)
                $restaurants = $restaurants->having('category','=',$request->category);
           
          
           $restaurants = $restaurants->get();
            
        }
        else{
            $filter = ['status'=>\Config::get('settings.restaurant_status_accepted')];
       
            if($request->category)
               $filter['category'] =$request->category;

               $restaurants = Restaurant::where($filter)->paginate(\Config::get('settings.per_page'));
        }
        $restaurants = new RestaurantCollection($restaurants);

         if($request->sort)
               $restaurants = $restaurants->sortBy($request->sort);
           
         
        return $restaurants->additional(['status'=>true,'message'=>__('api.success')]);
        
    }
    
    /**
     * get restaurant details
     */
    public function Restaurant($id){
            $restaurant = new RestaurantResource(Restaurant::findOrFail($id));
        return $restaurant->additional(['status'=>true,'message'=>__('api.success')]);

    }

}
