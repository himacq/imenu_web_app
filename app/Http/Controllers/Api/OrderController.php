<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderDetailOption;
use App\Models\CartDetailOption;
use App\Http\Resources\Order as OrderResource;
use App\Http\Resources\OrderCollection;

class OrderController extends Controller
{
    protected $user = null;
    public function __construct()
    {
      $this->user =  Auth::guard('api')->user();
      if($this->user)
        App::setLocale($this->user->language_id);
    }
    /**************************************************************
     * create and confirm order
     */
    public function createOrder(Request $request){
        $cart = $this->user->getCart;
        $cartDetails = $cart->details;
        
        
        $rules = [
            'payment_id' => 'required|integer',
            'address_id' => 'required|integer',
        ];
        
          $validate = Validator::make($request->all(), $rules);
          if ($validate->fails()) {
            return $this->response(null, false,$validate->errors()->first());

        }
        

        $order = Order::create([
            'payment_id' => $request->payment_id,
            'user_id'   => $this->user->id,
            'grand_total'   => $cart->grand_total,
            'address_id'   => $request->address_id,
            'order_status' => \Config::get('settings.new_order_status')
        ]);
        
        if(!$order)
            return $this->response(null, false,__('api.not_found'));
        
        
        
        foreach($cartDetails as $detail){
        $orderDetail = OrderDetail::create([
            'product_id' => $detail->product_id,
            'order_id'   => $order->id,
            'qty'   => $detail->qty,
            'price' => $detail->price
        ]);
        
        $product_detail_options = CartDetailOption::where(['cart_details_id'=>$detail->id])->get();
        foreach($product_detail_options as $option){
            OrderDetailOption::create([
            'order_details_id' => $orderDetail->id,
            'product_option_id'   => $option->product_option_id,
            'qty'   => $option->qty,
            'price' => $option->price
        ]);
        }
        
        }
        
        $order = new OrderResource($order);

        $cartObj = new CartController();
        $cartObj->emptyCart();
        
        return $order->additional(['status'=>true,'message'=>__('api.success')]);
    }
    /**
     * get order details
     */
    public function order($id){
   
        $orderData = Order::where(['id'=>$id,'user_id'=>$this->user->id])->first();
        if (!$orderData) {
            return $this->response(null, false,__('api.not_found'));
        }
        
        $order = new OrderResource($orderData);
        return $order->additional(['status'=>true,'message'=>__('api.success')]);

    }
    /**
     * list orders api services
     */
    public function listOrders(){
        
        $orders = new OrderCollection(
                Order::where(['user_id'=>$this->user->id])->paginate(\Config::get('settings.per_page'))
                );
        
        return $orders->additional(['status'=>true,'message'=>__('api.success')]);
        
    }
}
