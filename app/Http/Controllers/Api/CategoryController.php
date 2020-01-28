<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


use App;
use \App\Models\Category;

use App\Http\Resources\Category as CategoryResource;
use App\Http\Resources\CategoryCollection ;


class CategoryController extends Controller
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
     * get categories list
     */
    
    public function listCategories($restaurant_id=null,$language_id = 'en'){
        if($language_id)
            App::setLocale($language_id);
        
        if($restaurant_id)
         $categories = new CategoryCollection(
                 Category::where(['restaurant_id'=>$restaurant_id,'isActive'=>1])
                 ->paginate(\Config::get('settings.per_page'))
                 );
        else
          $categories = new CategoryCollection(
                  Category::where(['isActive'=>1])->paginate(\Config::get('settings.per_page'))
                  );
        
        return $categories->additional(['status'=>true,'message'=>__('api.success')]);
    }
    
    /**
     * get category details by id
     */
    
    public function Category($id,$language_id = 'en'){
        
        if($language_id)
            App::setLocale($language_id);
      
            $category = new CategoryResource(Category::findOrFail($id));
        return $category->additional(['status'=>true,'message'=>__('api.success')]);
    }

}
