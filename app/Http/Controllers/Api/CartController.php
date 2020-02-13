<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Validator;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\CartDetailOption;
use App\Http\Resources\Cart as CartResource;

use App\Models\Product;
use App\Models\ProductOption;
use App\Models\CartRestaurant;

class CartController extends ApiController
{  
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * get user's cart
     */
    public function getCart(){
        Cart::firstOrCreate(['user_id' => $this->user->id]);
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

        // add  item
        $product = Product::where(['isActive'=>1,'id'=>$request->product_id])->first();
        
        
        if(!$product)
            return $this->response(null, false,__('api.not_found'));

        // get or create cart restaurant record
        $cart_restaurant = CartRestaurant::firstOrCreate([
            'cart_id'=>$this->user->getCart->id,
            'restaurant_id'=>$product->category->restaurant->id,
            'sub_total'=>0
                ]);
        
        // add the product to the cart
        $cartDetail = CartDetail::create([
            'product_id' => $request->product_id,
            'cart_restaurant_id'   => $cart_restaurant->id,
            'qty'   => $request->qty,
            'price' => $product->price
        ]);
        
        if($cartDetail){
            // if added successfully update grand total and sub total
            $grand_total = $this->user->getCart->grand_total;
            $this->user->getCart->update(['grand_total'=>$grand_total+($request->qty*$product->price)]);
            $cart_restaurant->update(['sub_total'=>$cart_restaurant->sub_total+($request->qty*$product->price)]);
            
            // add options tot the requested item
            if(is_array($request->options)){
                foreach($request->options as $option){
                $product_option = ProductOption::where(['isActive'=>1,'id'=>$option['option_id']])->first();
                
                if(!$product_option)
                    return $this->response(null, false,__('api.not_found'));

                $cartDetailOption = CartDetailOption::create([
                    'cart_details_id' => $cartDetail->id,
                    'product_option_id'   => $product_option->id,
                    'qty'   => $option['qty'],
                    'price' => $product_option->price
                ]);

                if($cartDetailOption){
                    // if added successfully update grand total and sub total
                    $grand_total = $this->user->getCart->grand_total;
                    $this->user->getCart->update([
                        'grand_total'=>$grand_total+($option['qty']*$product_option->price)
                            ]);
                    $cart_restaurant->update(['sub_total'=>$cart_restaurant->sub_total+($option['qty']*$product_option->price)]);
                }
            }
            
            }
            
            
        }
        
        return $this->getCart();
    }
    
    
    /**
     * Remove Item From Cart
     * @param type $id
     */
    public function removeItemCart($id){
        if (!$id) {
            return $this->response(null, false,__('api.not_found'));
        }
        $cartItem= CartDetail::where(['id'=>$id])->first();
        if (!$cartItem) {
            return $this->response(null, false,__('api.not_found'));
        }
        // get cart restaurant record
        $cart_restaurant = CartRestaurant::find($cartItem->cart_restaurant_id);
        
        $cartItemOptions = CartDetailOption::where(['cart_details_id'=>$cartItem->id])->get();
        $total = 0;
        foreach($cartItemOptions as $option){
            $total+=($option->price)*($option->qty);
        }
        if($cartItem->delete()){
            $grand_total = $this->user->getCart->grand_total;
            $this->user->getCart->update([
                'grand_total'=>$grand_total-($cartItem->qty*$cartItem->price)-$total
                    ]);
            
            $cart_restaurant->update(['sub_total'=>$cart_restaurant->sub_total-($cartItem->qty*$cartItem->price)-$total]);
       
            
            //check if there are no items associated with this restaurant => delete this record
            $cartItems= CartDetail::where(['cart_restaurant_id'=>$cart_restaurant->id])->first();
            if (!$cartItems) {
                $cart_restaurant->delete();
            }
        }
        
        return $this->getCart();
    }
    
    /**
     * update Item From Cart
     * @param type $id
     */
    public function updateItemCart(Request $request){
        if (!$request->item_id) {
            return $this->response(null, false,__('api.not_found'));
        }
        $cartItem= CartDetail::where(['id'=>$request->item_id])->first();
        if (!$cartItem) {
            return $this->response(null, false,__('api.not_found'));
        }
        
        if($this->removeItemCart($request->item_id)){
        $request->request->add(['product_id' => $cartItem->product_id]);
            return $this->addToCart($request);
        }
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
