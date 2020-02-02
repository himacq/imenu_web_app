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
        
        factory('App\Models\PaymentMethod',3)->create();
        
        $response = $this->get('api/paymentMethods');
        $response->assertStatus(200);
        $response->assertJson(['status'=>true]);
    }
}
