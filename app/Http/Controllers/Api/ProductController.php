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

    public function listProducts(Request $request){

        $order = ($request->order?$request->order:"ASC");
        $sort = ($request->sort?$request->sort:"name");

        $filter = array();
        $filter['isActive'] = 1;
        if($request->category_id)
            $filter['category_id'] = $request->category_id;

        if($request->restaurant_id){
            $products = Product::where($filter)->whereHas('category', function ($query) use ($request) {
                    $query->where(['restaurant_id'=> $request->restaurant_id]);
                });

        }
        else{
            $products = Product::where($filter);
        }

        $products->orderBy($sort,$order);

        $products = $products->paginate(\Config::get('settings.per_page'));

        $productsCollection = new ProductCollection($products);

        return $productsCollection->additional(['status'=>true,'message'=>__('api.success')]);
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
