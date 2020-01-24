<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class coreTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name' => "administrator",
            'email' => 'himacq@gmail.com',
            'username' =>'admin',
            'password' => bcrypt('a123456'),
            'isActive' => 1,
            'phone' => rand(123456,999999),
            'mobile' => rand(123456,999999),
            'restaurant_id' => Null,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            
        ]);
        
        
        $faker = Faker::create();
    	foreach (range(1,10) as $index) {
	        DB::table('users')->insert([
	            'name' => $faker->name,
	            'email' => $faker->email,
                    'username'=>Str::random(10),
	            'password' => bcrypt('secret'),
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
	        ]);
        }
        
        
    }
}
