<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;

use App\Models\Message;
use App\Models\MessageReply;

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

$factory->define(Message::class, function (Faker $faker) {
    return [
	            'message_type' => random_int(1, 3),
	            'sender_id' => random_int(\DB::table('users')->min('id'), \DB::table('users')->max('id')),
                    'receiver_id'=> random_int(\DB::table('users')->min('id'), \DB::table('users')->max('id')),
	            'title' => $faker->title,
                    'message' =>$faker->text,
                    'isSeen' =>$faker->boolean,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
	        ];
});

$factory->define(MessageReply::class, function (Faker $faker) {
    return [
	            'message_id' => random_int(\DB::table('Messages')->min('id'), \DB::table('Messages')->max('id')),
                    'sender_id'=> random_int(\DB::table('users')->min('id'), \DB::table('users')->max('id')),
                    'message' =>$faker->text,
                    'isSeen' =>$faker->boolean,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
	        ];
});



