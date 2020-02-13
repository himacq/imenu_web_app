<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderApiTest extends TestCase
{
        protected $product, $product_option, $cart_details,$order,$payment_method,$user_address;

    /*     * ******************************************************************************** */

    private function create_fake_data() {
        $this->withoutExceptionHandling();

        $this->user_authenticated();

        $lookup = factory('App\Models\Lookup', 10)->create();
        $restaurant = factory('App\Models\Restaurant', 10)->create();
        $category = factory('App\Models\Category', 10)->create();
        $this->product = factory('App\Models\Product')->create();
        $product_option_group = factory('App\Models\ProductOptionGroup')->create();
        $this->product_option = factory('App\Models\ProductOption')->create();

        $carts = factory('App\Models\Cart')->create();
        $cart_restaurant = factory('App\Models\CartRestaurant')->create();
        $this->cart_details = factory('App\Models\CartDetail')->create();
        $cart_detail_options = factory('App\Models\CartDetailOption')->create();
        
        $this->payment_method = factory('App\Models\PaymentMethod')->create();
        $this->user_address = factory('App\Models\UserAddress')->create();
        $this->order = factory('App\Models\Order')->create();
        $order_restaurant = factory('App\Models\OrderRestaurant')->create();
        $order_details = factory('App\Models\OrderDetail')->create();
        $order_details_options = factory('App\Models\OrderDetailOption')->create();
    }
    
    /**
     * @test
     */
    
    public function create_order(){
        $this->create_fake_data();
        
        $response = $this->post('api/order',
                ['payment_id'=>$this->payment_method->id,'address_id'=>$this->user_address->id],
                ['api_token'=>$this->user->api_token]
                );
        
        $response->assertStatus(201);
        $response->assertJson(['status'=>true]);
    }
    
    /**
     * @test
     */
    
    public function receive_order(){
        $this->create_fake_data();
        
        $restaurant1 = factory('App\Models\OrderRestaurant')->create();
        $restaurant2 = factory('App\Models\OrderRestaurant')->create();
        
        $response = $this->post('api/delivered_order',
                ['order_id'=>$this->order->id,'restaurants'=>
                    [
                       [
                           'restaurant_id'=>$restaurant1->restaurant_id,
                           'review_rank'=>4,
                           'review_text'=>'good job'
                           ],
                        [
                           'restaurant_id'=>$restaurant2->restaurant_id,
                           'review_rank'=>5,
                           'review_text'=>'fantastic'
                           ]
                    ]
                    ],
                ['api_token'=>$this->user->api_token]
                );
        
        $response->assertStatus(200);
        $response->assertJson(['status'=>true]);
    }
    
    /**
     * @test
     */
    
    public function get_order(){
        $this->create_fake_data();
        $response = $this->get('api/order/'.$this->order->id,[],['api_token'=>$this->user->api_token]);
        
        $response->assertStatus(200);
        $response->assertJson(['status'=>true]);
    }
    
    
    /**
     * @test
     */
    
    public function get_order_collection(){
        $this->create_fake_data();
        
        $response = $this->get('api/orders',[],['api_token'=>$this->user->api_token]);
        
        $response->assertStatus(200);
        $response->assertJson(['status'=>true]);
    }
}
