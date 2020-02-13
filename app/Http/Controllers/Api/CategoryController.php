<?php

namespace App\Http\Controllers\Api;

use \App\Models\Category;

use App\Http\Resources\Category as CategoryResource;
use App\Http\Resources\CategoryCollection ;
use App\Http\Controllers\Api\ApiController;

class CategoryController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * get categories list
     */
    
    public function listCategories($restaurant_id=null){
                
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
    
    public function Category($id){
            $category = new CategoryResource(Category::findOrFail($id));
        return $category->additional(['status'=>true,'message'=>__('api.success')]);
    }

}
