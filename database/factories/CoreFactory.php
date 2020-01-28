<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\User;
use App\Models\Lookup;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
	            'name' => $faker->name,
	            'email' => $faker->email,
                    'username'=>$faker->userName,
	            'password' => bcrypt('secret'),
                    'isActive' =>$faker->boolean ,
                    'language_id' => 'en',
                    'phone' => $faker->phoneNumber,
                    'mobile' => $faker->phoneNumber,
                    'longitude' =>$faker->longitude,
                    'latitude' =>$faker->latitude,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
	        ];
});

