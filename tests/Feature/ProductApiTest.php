<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


class ProductApiTest extends TestCase
{
     use RefreshDatabase;



    /***********************************************************************************/

     /**
      * @test
      */
     public function products_list(){
         $this->withoutExceptionHandling();

         $restaurant = factory('App\Models\Restaurant',10)->create();
         $category = factory('App\Models\Category',10)->create();
         $products = factory('App\Models\Product',10)->create();

         $response = $this->post('api/products',
             [
                "sort"=>"price",
                "order"=>"asc",
                "restaurant_id"=>4,
                "category_id"=>3
             ]);

         $response->assertStatus(200);
         $response->assertJson(['status'=>true]);

     }

    /**
     * @test
     */
    public function review_product(){
        $this->withoutExceptionHandling();
        $this->user_authenticated();

        $restaurant = factory('App\Models\Restaurant',10)->create();
        $category = factory('App\Models\Category',10)->create();
        $product = factory('App\Models\Product')->create();
        $response = $this->post('/api/product/review',['review_text'=>'good','review_rank'=>4,
            'product_id'=>$product->id],
            ['api_token'=>$this->user->api_token]);


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
