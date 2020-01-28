<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


use App;
use App\Models\Product;

use App\Http\Resources\Product as ProductResource;
use App\Http\Resources\ProductCollection ;

class ProductController extends Controller
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
     * get products' list
     */
    
    public function listProducts($category_id = null, $language_id = 'en'){
        if($language_id)
            App::setLocale($language_id);
        
        if($category_id)
         $products = new ProductCollection(
                 Product::where(['category_id'=>$category_id,'isActive'=>1])
                    ->orderBy('created_at', 'desc')
                    ->paginate(\Config::get('settings.per_page'))
                 );
        else
          $products = new ProductCollection(
                  Product::where(['isActive'=>1])
                    ->orderBy('created_at', 'desc')
                    ->paginate(\Config::get('settings.per_page'))
                  );
        
        return $products->additional(['status'=>true,'message'=>__('api.success')]);
    }
    
    /**
     * get product details by id
     */
    
    public function Product($id,$language_id = 'en'){
        
        if($language_id)
            App::setLocale($language_id);
      
            $product = new ProductResource(Product::findOrFail($id));
        return $product->additional(['status'=>true,'message'=>__('api.success')]);
    }
    
    
    
}
