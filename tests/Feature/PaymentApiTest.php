<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentApiTest extends TestCase
{
    /**
     * @test
     */
    public function get_payment_methods(){
        $this->withoutExceptionHandling();

        $restaurant = factory('App\Models\Restaurant')->create();
        factory('App\Models\PaymentMethod',3)->create();
        factory('App\Models\RestaurantPaymentMethod',3)->create();

        $response = $this->get('api/paymentMethods/'.$restaurant->id);
        $response->assertStatus(200);
        $response->assertJson(['status'=>true]);
    }
}
