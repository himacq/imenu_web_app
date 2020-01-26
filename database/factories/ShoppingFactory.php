<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Restaurant;
use Faker\Generator as Faker;
use Illuminate\Support\Str;


/**
 * Fake Restaurants
 */
$factory->define(Restaurant::class, function (Faker $faker) {
     return [

        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'mobile1' => $faker->phoneNumber,
        'mobile2' => $faker->phoneNumber,
         'phone3' => $faker->phoneNumber,
         'phone2' => $faker->phoneNumber,
         'phone1' => $faker->phoneNumber,
        'extra_info' => $faker->text,
        'working_details' =>$faker->text,
         'longitude' =>$faker->longitude,
         'latitude' =>$faker->latitude,
         'verification_code' =>str_random(4),
         'manager_id'=>random_int(\DB::table('users')->min('id'), \DB::table('users')->max('id')),
         'status'=>random_int(\DB::table('lookup')->min('id'), \DB::table('lookup')->max('id')),
         
             ];
});
