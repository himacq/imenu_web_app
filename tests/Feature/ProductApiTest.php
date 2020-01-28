<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;

class ProductApiTest extends TestCase
{
     use RefreshDatabase;
    /**
     * @test
     */
    
    protected $user = null;
    
    
    private function _user_authenticated()
    {

        $this->user = User::create(['name'=>'hima','username'=>'admin','email'=>'dd@gg.com',
            'password'=>bcrypt('a123456'),'language_id'=>'en']);
  
        $this->user->generateToken();
        
        $this->actingAs($this->user,'api');

    }
    /***********************************************************************************/

     /**
      * @test
      */
     public function products_list(){
         $this->withoutExceptionHandling();
         
         $restaurant = factory('App\Models\Restaurant',10)->create();
         $category = factory('App\Models\Category',10)->create();
         $products = factory('App\Models\Product',10)->create();
         
         $response = $this->get('api/products');
         
         $response->assertStatus(200);
         $response->assertJson(['status'=>true]);
         
     }
     
     /**
      * @test
      */
     public function product_details(){
         $this->withoutExceptionHandling();
         
         $restaurant = factory('App\Models\Restaurant',10)->create();
         $category = factory('App\Models\Category',10)->create();
         $product = factory('App\Models\Product')->create();
         
         $response = $this->get('api/product/'.$product->id);
         
         $response->assertStatus(200);
         $response->assertJson(['status'=>true]);
     }
     
}
