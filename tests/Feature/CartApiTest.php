<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartApiTest extends TestCase
{
    use RefreshDatabase;
       
   
    /***********************************************************************************/
    
    /**
     * @test
     */
    public function add_to_cart()
    {
      $this->withoutExceptionHandling();
      
      $this->user_authenticated();
      
      $restaurant = factory('App\Models\Restaurant',10)->create();
      $category = factory('App\Models\Category',10)->create();
      $product = factory('App\Models\Product')->create();
         
         $response = $this->post('api/cart',
                 [
                     'product_id'=>$product->id,'qty'=>1,
//                     'product_options'=>[
//                         'product_option_id'=> $product_option->id,
//                         'qty'  =>2,
//                         'price'=>$product_option->extra_price
//                     ]
                 ],
                 ['api_token'=>$this->user->api_token]);
         
         $response->assertStatus(200);
         $response->assertJson(['status'=>true]);
    }
    
    /**
     * @test
     */
    public function add_options_to_product_in_cart()
    {
      $this->withoutExceptionHandling();
      
      $this->user_authenticated();
      
        $restaurant = factory('App\Models\Restaurant',10)->create();
        $category = factory('App\Models\Category',10)->create();
        $product = factory('App\Models\Product')->create();
        $product_option = factory('App\Models\ProductOptions')->create();
        $carts = factory('App\Models\Cart')->create();
        $cart_details = factory('App\Models\CartDetail')->create();
         
         $response = $this->post('api/cartOption',
                 [
                         'cart_details_id'  => $cart_details->id,
                         'product_option_id'=> $product_option->id,
                         'qty'  =>2,
                 ],
                 ['api_token'=>$this->user->api_token]);
         
         $response->assertStatus(200);
         $response->assertJson(['status'=>true]);
    }
    /**
     * @test
     */
    public function get_my_cart(){
        $this->withoutExceptionHandling();
        
        $this->user_authenticated();
      
        $restaurant = factory('App\Models\Restaurant',10)->create();
        $category = factory('App\Models\Category',10)->create();
        $product = factory('App\Models\Product')->create();
        $product_option = factory('App\Models\ProductOptions')->create();
        $carts = factory('App\Models\Cart')->create();
        $cart_details = factory('App\Models\CartDetail')->create();
        
        $response = $this->get('api/cart',[],['api_token'=>$this->user->api_token]);
        
        $response->assertStatus(200);
        $response->assertJson(['status'=>true]);
        
    }
    
    /**
     * @test
     */
    
    public function remove_item_from_cart(){
        $this->withoutExceptionHandling();
        $this->user_authenticated();
        
        $restaurant = factory('App\Models\Restaurant',10)->create();
        $category = factory('App\Models\Category',10)->create();
        $product = factory('App\Models\Product')->create();
        $product_option = factory('App\Models\ProductOptions')->create();
        $carts = factory('App\Models\Cart')->create();
        $cart_details = factory('App\Models\CartDetail')->create();
        
        $response = $this->delete('api/cart/'.$cart_details->id,[],['api_token'=>$this->user->api_token]);
         
         $response->assertStatus(200);
         $response->assertJson(['status'=>true]);
    }
    
    /**
     * @test
     */
    
    public function empty_cart(){
        $this->withoutExceptionHandling();
        $this->user_authenticated();
        
        $restaurant = factory('App\Models\Restaurant',10)->create();
        $category = factory('App\Models\Category',10)->create();
        $product = factory('App\Models\Product')->create();
        $product_option = factory('App\Models\ProductOptions')->create();
        $carts = factory('App\Models\Cart')->create();
        $cart_details = factory('App\Models\CartDetail')->create();
        
        $response = $this->get('api/cart/empty',['api_token'=>$this->user->api_token]);
         
         $response->assertStatus(200);
         $response->assertJson(['status'=>true]);
    }
}
