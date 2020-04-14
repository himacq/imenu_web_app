<?php

namespace App\Http\Controllers\Api;

use App\Models\CartDetailIngredient;
use App\Models\OrderDetailIngredient;
use App\Models\PaymentMethod;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderDetailOption;
use App\Models\CartDetailOption;
use App\Models\OrderRestaurant;
use App\Models\CartDetail;
use App\Models\OrderRestaurantStatus;
use App\Models\RestaurantReview;
use App\Http\Resources\Order as OrderResource;
use App\Http\Resources\OrderCollection;

class OrderController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }
    /**************************************************************
     * create and confirm order
     */
    public function createOrder(Request $request){

        $cart = $this->user->getCart;
        $notEmptyCart = $cart->cartRestaurants;

        if(!count($notEmptyCart)){
             return $this->response(null, false,__('api.not_found'));
        }


        // create the order
        /*********************************/
        $order = Order::create([
            'user_id'   => $this->user->id,
            'grand_total'   => $cart->grand_total,
        ]);

        if(!$order)
            return $this->response(null, false,__('api.not_found'));


        // create order restaurant records
        /*****************************************************************/
        foreach($cart->cartRestaurants as $restaurant){
            $order_restaurant = OrderRestaurant::Create([
                'order_id'=>$order->id,
                'restaurant_id'=>$restaurant['restaurant_id'],
                'sub_total' =>$restaurant['sub_total']
                ]);


            $order_status = OrderRestaurantStatus::Create([
                'order_restaurant_id'=>$order_restaurant->id,
                'status' => \Config::get('settings.new_order_status')
                ]);

            // create order details for each restaurant
            $cartDetails = CartDetail::where(['cart_restaurant_id'=>$restaurant['id']])->get();
            foreach($cartDetails as $detail){
                $orderDetail = OrderDetail::create([
                    'product_id' => $detail->product_id,
                    'order_restaurant_id'   => $order_restaurant->id,
                    'qty'   => $detail->qty,
                    'price' => $detail->price
                ]);

                //create order detail option for each item
                $product_detail_options = CartDetailOption::where(['cart_details_id'=>$detail->id])->get();
                foreach($product_detail_options as $option){
                    OrderDetailOption::create([
                        'order_details_id' => $orderDetail->id,
                        'product_option_id'   => $option->product_option_id,
                        'qty'   => $option->qty,
                        'price' => $option->price
                    ]);
                }

                //create order detail ingredient for each item
                $product_detail_ingredients = CartDetailIngredient::where(['cart_details_id'=>$detail->id])->get();
                foreach($product_detail_ingredients as $option){
                    OrderDetailIngredient::create([
                        'order_details_id' => $orderDetail->id,
                        'product_ingredient_id'   => $option->product_ingredient_id
                    ]);
                }

                }

        }

        /***********************************************************/
        foreach($request->order_restaurants as $record){
             $orderRestaurant = OrderRestaurant::where([
                'restaurant_id'=>$record['restaurant_id'],
                'order_id'=>$order->id
            ])->first();

             if($orderRestaurant)
            $orderRestaurant->update(['payment_id'=>$record['payment_id'],'address_id'=>$record['address_id']]);
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

    /**
     * receive order and review the restaurant
     */

    public function delivered_order(Request $request){
        $orderData = Order::where(['id'=>$request->order_id,'user_id'=>$this->user->id])->first();
        if (!$orderData) {
            return $this->response(null, false,__('api.not_found'));
        }

        foreach ($request->restaurants as $restaurant_review){
            $order_restaurant = OrderRestaurant::where(
                    ['order_id'=>$request->order_id,'restaurant_id'=>$restaurant_review['restaurant_id']
                    ])->first();

            OrderRestaurantStatus::firstOrCreate(
                    [
                        'order_restaurant_id'=>$order_restaurant->id,
                        'status' => \Config::get('settings.delivered_order_status')
                    ]);


             RestaurantReview::create(
                    [
                        'user_id'=>$this->user->id,
                        'restaurant_id'=>$restaurant_review['restaurant_id'],
                        'review_text'=>$restaurant_review['review_text'],
                        'review_rank'=>$restaurant_review['review_rank'],
                        'isActive'=>1
                    ]);

        }
        return $this->response(null, true,__('api.success'));
    }
}
