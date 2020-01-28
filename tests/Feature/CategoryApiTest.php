<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;

class CategoryApiTest extends TestCase
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
    
    public function categories_list(){
        $this->withoutExceptionHandling();
        
        $response = $this->get('/api/categories');
        
        $response->assertStatus(200);
        $response->assertJson(['status'=>true]);
        
    }
    
    /**
     * @test
     */
     public function category_details(){
         $this->withoutExceptionHandling();
         
         $restaurant = factory('App\Models\Restaurant')->create();
         $category = factory('App\Models\Category')->create();
         $response = $this->get('/api/category/'.$category->id);
         
         $response->assertStatus(200);
         $response->assertJson(['status'=>true]);
         
     }
     
    }
