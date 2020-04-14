<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


class FavouriteApiTest extends TestCase
{
     use RefreshDatabase;


    /***********************************************************************************/

    /**
     * @test
     */
    public function favourite_add(){
        $this->withoutExceptionHandling();

        $this->user_authenticated();

        factory('App\Models\Restaurant',10)->create();
        factory('App\Models\Category',10)->create();
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

        $this->user_authenticated();

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

        $this->user_authenticated();

        $restaurant = factory('App\Models\Restaurant',5)->create();
        $category = factory('App\Models\Category',5)->create();
        $product = factory('App\Models\Product',5)->create();
        $users = factory('App\Models\User',5)->create();
        $favourites = factory('App\Models\Favourite',5)->create();

        $response = $this->get('api/favourites',[],['api_token'=>$this->user->api_token]);

        $response->assertStatus(200);
        $response->assertJson(['status'=>true]);
    }

    /*************************************************************************/
    /**
     * @test
     */
    public function favourite_restaurant_add(){
        $this->withoutExceptionHandling();

        $this->user_authenticated();


        $restaurant = factory('App\Models\Restaurant')->create();

        $response = $this->post('api/favourite_restaurant',
            ['restaurant_id'=>$restaurant->id],
            ['api_token'=>$this->user->api_token]);

        $response->assertStatus(200);
        $response->assertJson(['status'=>true]);

    }

    /**
     * @test
     */

    public function favourite_restaurant_delete(){
        $this->withoutExceptionHandling();

        $this->user_authenticated();

        $restaurant = factory('App\Models\Restaurant')->create();
        $favourite = factory('App\Models\FavouriteRestaurant')->create();

        $response = $this->delete('/api/favourite_restaurant/'.$favourite->id,[],['api_token'=>$this->user->api_token]);

        $response->assertStatus(200);
        $response->assertJson(['status'=>true]);
    }

    /**
     * @test
     */

    public function favourite_restaurant_list(){
        $this->withoutExceptionHandling();

        $this->user_authenticated();


        $users = factory('App\Models\User',5)->create();
        $restaurant = factory('App\Models\Restaurant',5)->create();
        $favourites = factory('App\Models\FavouriteRestaurant',5)->create();

        $response = $this->get('api/favourite_restaurants',[],['api_token'=>$this->user->api_token]);

        $response->assertStatus(200);
        $response->assertJson(['status'=>true]);
    }
}
