<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


class CategoryApiTest extends TestCase
{
     use RefreshDatabase;

     
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
