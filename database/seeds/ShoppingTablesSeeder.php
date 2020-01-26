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
    }
}
