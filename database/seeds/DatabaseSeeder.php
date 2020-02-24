<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RegistrationQuestionsSeeder::class);
        //$this->call(CoreTablesSeeder::class);
        //$this->call(ShoppingTablesSeeder::class);
    }
}
