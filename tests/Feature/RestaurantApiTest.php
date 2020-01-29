<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


class RestaurantApiTest extends TestCase
{
     use RefreshDatabase;

    
    
    /***********************************************************************************/
    
    /**
     * @test
     */
    public function restaurants_list(){
        $this->withoutExceptionHandling();
        
        $response = $this->get('/api/restaurants');
        
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
