<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class CoreTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        /*
        $faker = Faker::create();
        DB::table('users')->insert([
            'name' => "administrator",
            'email' => 'himacq@gmail.com',
            'username' =>'admin',
            'password' => bcrypt('a123456'),
            'isActive' => 1,
            'language_id' => 'en',
            'phone' => $faker->phoneNumber,
            'mobile' => $faker->phoneNumber,
            'restaurant_id' => Null,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            
        ]);*/
        
        //factory(App\Models\User::class, 10)->create();
        
        factory(App\Models\Lookup::class, 5)->create();
        
        

    }
}
