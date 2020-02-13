<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Auth;
use App;

class ApiController extends Controller
{
    
    public function __construct()
    {
      $this->user =  Auth::guard('api')->user();
      if($this->user)
        App::setLocale($this->user->language_id);
      
      if(app('request')->header('lang'))
          App::setLocale(app('request')->header('lang'));
      
    }
    
}
