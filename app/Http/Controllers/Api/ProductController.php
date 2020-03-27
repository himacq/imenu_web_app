<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Api\ApiController;
use App;
use App\Models\Product;

use App\Http\Resources\Product as ProductResource;
use App\Http\Resources\ProductCollection ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param Request $request
     * @return App\Http\Controllers\type
     */
    public function review(Request $request){
        $rules = [
            'review_text' => 'required|min:3',
            'review_rank' => 'required|integer',
            'product_id'=>'required'
        ];

        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            return $this->response(null, false,$validate->errors()->first());

        }

        $product = Product::find($request->product_id);
        if(!$product)
            return $this->response(null, false,__('api.not_found'));


        $review = App\Models\ProductReview::create([
            'review_text' => $request->review_text,
            'review_rank' => $request->review_rank,
            'isActive' => 1,
            'user_id' => $this->user->id,
            'product_id'=>$product->id
        ]);


        return $this->response($review->toArray(), true,__('api.success'));
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

        $product = Product::where(['id'=>$id,'isActive'=>1])->first();
        if(!$product)
            return $this->response(null, false,__('api.not_found'));

            $product = new ProductResource($product);

        return $product->additional(['status'=>true,'message'=>__('api.success')]);
    }



}
