<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


use App;
use App\Models\Restaurant;


use App\Http\Resources\Restaurant as RestaurantResource;
use App\Http\Resources\RestaurantCollection ;

class RestaurantController extends Controller
{
    use AuthenticatesUsers;
    
    protected $user = null;
    public function __construct()
    {
      $this->user =  Auth::guard('api')->user();
      if($this->user)
        App::setLocale($this->user->language_id);
    }
    
    /**
     * restaurants api services
     */
    public function listRestaurants($language_id='en'){
        if($language_id)
            App::setLocale($language_id);
        
        $restaurants = new RestaurantCollection(
                Restaurant::where(['status'=>3])->paginate(\Config::get('settings.per_page'))
                );
        
        return $restaurants->additional(['status'=>true,'message'=>__('api.success')]);
        
    }
    
    /**
     * get restaurant details
     */
    public function Restaurant($id,$language_id = 'en'){
        if($language_id)
            App::setLocale($language_id);
      
            $restaurant = new RestaurantResource(Restaurant::findOrFail($id));
        return $restaurant->additional(['status'=>true,'message'=>__('api.success')]);

    }

}
