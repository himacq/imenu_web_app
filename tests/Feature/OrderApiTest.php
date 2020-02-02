<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderApiTest extends TestCase
{
    /**
     * @test
     */
    
    public function create_order(){
        $this->withoutExceptionHandling();
      
      $this->user_authenticated();
      
        $restaurant = factory('App\Models\Restaurant',10)->create();
        $category = factory('App\Models\Category',10)->create();
        $lookup = factory('App\Models\Lookup',10)->create();
        $product = factory('App\Models\Product')->create();
        $product_option = factory('App\Models\ProductOptions')->create();
        $payment_method = factory('App\Models\PaymentMethod')->create();
        $user_address = factory('App\Models\UserAddress')->create();
        $order = factory('App\Models\Order')->create();
        $order_details = factory('App\Models\OrderDetail')->create();
        $order_details_options = factory('App\Models\OrderDetailOption')->create();
        
        
        
        $response = $this->post('api/order',
                ['payment_id'=>$payment_method->id,'address_id'=>$user_address->id],
                ['api_token'=>$this->user->api_token]
                );
        
        $response->assertStatus(201);
        $response->assertJson(['status'=>true]);
    }
    
    /**
     * @test
     */
    
    public function get_order(){
        $this->withoutExceptionHandling();
      
      $this->user_authenticated();
      
        $restaurant = factory('App\Models\Restaurant',10)->create();
        $category = factory('App\Models\Category',10)->create();
        $lookup = factory('App\Models\Lookup',10)->create();
        $product = factory('App\Models\Product')->create();
        $product_option = factory('App\Models\ProductOptions')->create();
        $payment_method = factory('App\Models\PaymentMethod')->create();
        $user_address = factory('App\Models\UserAddress')->create();
        $order = factory('App\Models\Order')->create();
        $order_details = factory('App\Models\OrderDetail')->create();
        $order_details_options = factory('App\Models\OrderDetailOption')->create();
        
        
        
        $response = $this->get('api/order/'.$order->id,[],['api_token'=>$this->user->api_token]);
        
        $response->assertStatus(200);
        $response->assertJson(['status'=>true]);
    }
    
    
    /**
     * @test
     */
    
    public function get_order_collection(){
        $this->withoutExceptionHandling();
      
      $this->user_authenticated();
      
        $restaurant = factory('App\Models\Restaurant',10)->create();
        $category = factory('App\Models\Category',10)->create();
        $lookup = factory('App\Models\Lookup',10)->create();
        $product = factory('App\Models\Product')->create();
        $product_option = factory('App\Models\ProductOptions')->create();
        $payment_method = factory('App\Models\PaymentMethod')->create();
        $user_address = factory('App\Models\UserAddress')->create();
        $order = factory('App\Models\Order',5)->create();
        $order_details = factory('App\Models\OrderDetail',5)->create();
        $order_details_options = factory('App\Models\OrderDetailOption',3)->create();
        
        
        
        $response = $this->get('api/orders',[],['api_token'=>$this->user->api_token]);
        
        $response->assertStatus(200);
        $response->assertJson(['status'=>true]);
    }
}
