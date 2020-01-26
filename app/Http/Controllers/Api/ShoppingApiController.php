<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App;
use App\Models\User;
use App\Models\Role;
use App\Models\UserAddress;
use App\Models\Restaurant;

use App\Http\Resources\Restaurant as RestaurantResource;
use App\Http\Resources\RestaurantCollection as RestaurantCollection;

class ShoppingApiController extends Controller
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
        
        $restaurants = RestaurantResource::collection(Restaurant::where(['status'=>3])->paginate(1));
        
        return $restaurants->additional(['status'=>true,'message'=>__('api.success')]);
        
    }
    
}
