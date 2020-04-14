<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartApiTest extends TestCase {

    use RefreshDatabase;

    protected $product, $product_option,$product_ingredient, $cart_details;

    /*     * ******************************************************************************** */

    private function create_fake_data() {
        $this->withoutExceptionHandling();

        $this->user_authenticated();

        $restaurant = factory('App\Models\Restaurant', 10)->create();
        $category = factory('App\Models\Category', 10)->create();
        $this->product = factory('App\Models\Product')->create();
        $product_option_group = factory('App\Models\ProductOptionGroup')->create();
        $this->product_option = factory('App\Models\ProductOption')->create();
        $this->product_ingredient = factory('App\Models\ProductIngredient')->create();

        $carts = factory('App\Models\Cart')->create();
        $cart_restaurant = factory('App\Models\CartRestaurant')->create();
        $this->cart_details = factory('App\Models\CartDetail')->create();
        $cart_detail_options = factory('App\Models\CartDetailOption')->create();
    }

    /**
     * @test
     */
    public function add_to_cart() {

        $this->create_fake_data();

        $response = $this->post('api/cart', [
            'product_id' => $this->product->id, 'qty' => 1,
            'options' => [
                'option_id' => $this->product_option->id,
            ],
            'ingredients' => [
                'ingredient_id' => $this->product_ingredient->id,
            ]
                ], ['api_token' => $this->user->api_token]);

        $response->assertStatus(200);
        //$response->assertJson(['status' => true]);
    }

    /**
     * @test
     */
    public function get_my_cart() {
        $this->create_fake_data();

        $response = $this->get('api/cart', [], ['api_token' => $this->user->api_token]);

        $response->assertStatus(200);
        $response->assertJson(['status' => true]);
    }

    /**
     * @test
     */
    public function remove_item_from_cart() {
        $this->create_fake_data();

        $response = $this->delete('api/cart/' . $this->cart_details->id, [], ['api_token' => $this->user->api_token]);

        $response->assertStatus(200);
        $response->assertJson(['status' => true]);
    }

    /**
     * @test
     */
    public function empty_cart() {
        $this->create_fake_data();

        $response = $this->get('api/cart/empty', ['api_token' => $this->user->api_token]);

        $response->assertStatus(200);
        $response->assertJson(['status' => true]);
    }

}
