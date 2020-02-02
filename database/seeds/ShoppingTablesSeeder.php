<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ShoppingTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * fake restaurants
         */
        factory(App\Models\Restaurant::class, 10)->create();
        
        /**
         * fake categories and products
         */
        
        factory(App\Models\Category::class, 10)->create();
        factory(App\Models\Product::class, 10)->create();
        factory(App\Models\ProductIngredients::class, 10)->create();
        factory(App\Models\ProductOptions::class, 10)->create();
        factory(App\Models\PaymentMethod::class, 3)->create();
    }
}
