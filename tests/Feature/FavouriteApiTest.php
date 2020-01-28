<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;

class FavouriteApiTest extends TestCase
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
     public function favourite_add(){
         $this->withoutExceptionHandling();
         
         $this->_user_authenticated();
         
         $restaurant = factory('App\Models\Restaurant',10)->create();
         $category = factory('App\Models\Category',10)->create();
         $product = factory('App\Models\Product')->create();
         
         $response = $this->post('api/favourite',
                 ['product_id'=>$product->id],
                 ['api_token'=>$this->user->api_token]);
         
         $response->assertStatus(200);
         $response->assertJson(['status'=>true]);
         
     }
     
     /**
      * @test
      */
     
     public function favourite_delete(){
         $this->withoutExceptionHandling();
         
         $this->_user_authenticated();
         
         $restaurant = factory('App\Models\Restaurant',5)->create();
         $category = factory('App\Models\Category',5)->create();
         $product = factory('App\Models\Product',5)->create();
         $favourite = factory('App\Models\Favourite')->create();
         
         $response = $this->delete('/api/favourite/'.$favourite->id,[],['api_token'=>$this->user->api_token]);
         
         $response->assertStatus(200);
         $response->assertJson(['status'=>true]);
     }
     
     /**
      * @test
      */
     
     public function favourite_list(){
         $this->withoutExceptionHandling();
         
         $this->_user_authenticated();
         
         $restaurant = factory('App\Models\Restaurant',5)->create();
         $category = factory('App\Models\Category',5)->create();
         $product = factory('App\Models\Product',5)->create();
         $users = factory('App\Models\User',5)->create();
         $favourites = factory('App\Models\Favourite',5)->create();
         
         $response = $this->get('api/favourites',[],['api_token'=>$this->user->api_token]);
         
         $response->assertStatus(200);
         $response->assertJson(['status'=>true]);
     }
}
