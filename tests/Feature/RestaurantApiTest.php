<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


class RestaurantApiTest extends TestCase
{
     use RefreshDatabase;



    /***********************************************************************************/

    /**
     * @test_fail
     *  no such function: acos (SQL: select *, ( 111.045 * acos( cos( radians( -63365 ) )
     * * cos( radians( latitude ) ) * cos( radians( longitude ) - radians( -5522 ) ) + sin( radians( -63365 ) ) * sin( radians( latitude ) ) ) ) AS distance from "restaurants" having "distance" < 5 and "status" = 2 and "category" = 5 order by "distance" asc)
     */
    public function restaurants_list(){
        $this->withoutExceptionHandling();
        $restaurants = factory('App\Models\Restaurant',10)->create();

        $response = $this->post('/api/restaurants',[
            'category'=>5,'latitude'=>'-63365','longitude'=>'-5522','distance'=>5
            ]);

        $response->assertStatus(200);
        $response->assertJson(['status'=>true]);

    }
    /**
     * @test
     */
    public function review_restaurant(){
        $this->withoutExceptionHandling();
        $this->user_authenticated();

        $restaurant = factory('App\Models\Restaurant')->create();
        $response = $this->post('/api/restaurant/review',['review_text'=>'good','review_rank'=>4,
            'restaurant_id'=>$restaurant->id],
            ['api_token'=>$this->user->api_token]);


        $response->assertStatus(200);
        $response->assertJson(['status'=>true]);
    }
    /**
     * @test
     */
    public function restaurants_categories(){
        $this->withoutExceptionHandling();
        $restaurants = factory('App\Models\Restaurant',10)->create();

        $response = $this->get('/api/restaurant_categories');

        $response->assertStatus(200);
        $response->assertJson(['status'=>true]);

    }

    /**
     * @test
     */
    public function restaurant_profile(){
        $this->withoutExceptionHandling();

        $restaurant = factory('App\Models\Restaurant')->create();
        $response = $this->get('/api/restaurant/'.$restaurant->id);

        $response->assertStatus(200);
        $response->assertJson(['status'=>true]);

    }


}
