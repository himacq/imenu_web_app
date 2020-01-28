<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;

class RestaurantApiTest extends TestCase
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
