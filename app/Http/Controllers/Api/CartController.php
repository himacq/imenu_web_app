<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App;

use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\CartDetailOption;
use App\Http\Resources\Cart as CartResource;

use App\Models\Product;
use \App\Models\ProductOptions;

class CartController extends Controller
{
    protected $user = null;
    public function __construct()
    {
      $this->user =  Auth::guard('api')->user();
      if($this->user)
        App::setLocale($this->user->language_id);
    }
    /**
     * get user's cart
     */
    public function getCart(){
        $cart = new CartResource($this->user->getCart);

        return $cart->additional(['status'=>true,'message'=>__('api.success')]);
    }
    
    /**
     * add to Carts
     */
    
    public function addToCart(Request $request){
        $rules = [
            'product_id' => 'required|integer',
            'qty' => 'required|integer',
        ];
        
          $validate = Validator::make($request->all(), $rules);
          if ($validate->fails()) {
            return $this->response(null, false,$validate->errors()->first());

        }
        $product = Product::where(['isActive'=>1,'id'=>$request->product_id])->first();
        
        if(!$product)
            return $this->response(null, false,__('api.not_found'));

        $cartDetail = CartDetail::create([
            'product_id' => $request->product_id,
            'cart_id'   => $this->user->getCart->id,
            'qty'   => $request->qty,
            'price' => $product->price
        ]);
        
        
        return $this->response($cartDetail->toArray(), true,__('api.success'));
    }
    
    /**
     * add to Carts
     */
    
    public function addOptionToCartDetails(Request $request){
        $rules = [
            'cart_details_id' => 'required|integer',
            'product_option_id' => 'required|integer',
            'qty' => 'required|integer',
        ];
        
          $validate = Validator::make($request->all(), $rules);
          if ($validate->fails()) {
            return $this->response(null, false,$validate->errors()->first());

        }
        
        $product_option = ProductOptions::where(['isActive'=>1,'id'=>$request->product_option_id])->first();
        if(!$product_option)
            return $this->response(null, false,__('api.not_found'));

        $cartDetailOption = CartDetailOption::create([
            'cart_details_id' => $request->cart_details_id,
            'product_option_id'   => $request->product_option_id,
            'qty'   => $request->qty,
            'price' => $product_option->price
        ]);
        
        
        return $this->response($cartDetailOption->toArray(), true,__('api.success'));
    }
    
    /**
     * Remove Item From Cart
     * @param type $id
     */
    public function removeItemCart($id){
        if (!$id) {
            return $this->response(null, false,__('api.not_found'));
        }
        $cartItem= CartDetail::where(['cart_id'=>$this->user->getCart->id,'id'=>$id])->first();
        if (!$cartItem) {
            return $this->response(null, false,__('api.not_found'));
        }
        
        $cartItem->delete();
      
        return $this->response(null, true,__('api.success'));
        
    }
    
    /**
     * empty Cart
     * @param type $id
     */
    public function emptyCart(){
       
        $cartItem = $this->user->getCart;
        if (!$cartItem) {
            return $this->response(null, false,__('api.not_found'));
        }
        
        $cartItem->delete();
        $cart = Cart::firstOrCreate(['user_id' => $this->user->id]);
        return $this->response($cart->toArray(), true,__('api.success'));
        
    }
}
