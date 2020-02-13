<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Api\ApiController;
use App;
use App\Models\Product;

use App\Http\Resources\Product as ProductResource;
use App\Http\Resources\ProductCollection ;

class ProductController extends ApiController
{  
    public function __construct()
    {
        parent::__construct();
    }
 
    /**
     * get products' list
     */
    
    public function listProducts($category_id = null){
        
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
    
    public function Product($id){

            $product = new ProductResource(Product::findOrFail($id));
        return $product->additional(['status'=>true,'message'=>__('api.success')]);
    }
    
    
    
}
