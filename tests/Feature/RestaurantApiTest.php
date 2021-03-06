<?php

namespace Tests\Feature;

use App\Models\RestaurantRegistration;
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
            'classification'=>5,'latitude'=>'-63365','longitude'=>'-5522','distance'=>5
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

        $response = $this->get('/api/restaurant_classifications');

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

    /**
     * @test
     */
    public function restaurant_registration()
    {
        $this->withoutExceptionHandling();
        $this->user_authenticated();

        $response = $this->post('/api/restaurant/register',
            [
                'name'=>'hima',
                "id_img"=>"jpeg,/9j/4AAQSkZJRgABAgEAYABgAAD/4Q8HRXhpZgAATU0AKgAAAAgABgEyAAIAAAAUAAAAVkdGAAMAAAABAAMAAEdJAAMAAAABADIAAJydAAEAAAAOAAAAAOocAAcAAAf0AAAAAIdpAAQAAAABAAAAagAAANQyMD",
	            "license_img"=>"jpeg,/9j/4AAQSkZJRgABAgEAYABgAAD/4Q8HRXhpZgAATU0AKgAAAAgABgEyAAIAAAAUAAAAVkdGAAMAAAABAAMAAEdJAAMAAAABADIAAJydAAEAAAAOAAAAAOocAAcAAAf0AAAAAIdpAAQAAAABAAAAagAAANQyMD",
	            "education_level"=>"Master",
	            "city"=>"Kuruçeşme ",
	            "locality"=>"Kuruçeşme ",
	            "address"=>"Kuruçeşme  462",
                "duty"=>"fast food",
                "starting"=>"today",
                "ending"=>"morgen",
                "latitude"=>"41.25289566687463",
                "longitude"=>"39.5626922952659",
                "distance"=>25,
	            "email"=>"sdsd@dfdf.com",
	            "phone"=>22366533,
	            "business_title"=>"sdsdsd",
	            "branches_count"=>"5",
	            "branches"=>[
		            ["name"=>"Istanbul","address"=>"dssfsfs"],
		            ["name"=>"Ankara","address"=>"dffff"]
		                ],

                "general_questions"=>[
                    ["1"=>"yes"],
                    ["2"=>"yes"],
                    ["3"=>"yes"],
                    ["4"=>"yes"],
                    ["5"=>"yes"],
                    ["6"=>"yes"],
                    ["7"=>"yes"],
                    ["8"=>"yes"],
                    ["9"=>"yes"],
                    ["10"=>"yes"]
                        ]
            ]);

        $this->assertCount(1,RestaurantRegistration::all());
        $response->assertStatus(200);
        $response->assertJson(['status'=>true]);
    }


}
