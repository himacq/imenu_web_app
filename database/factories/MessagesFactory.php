<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;

use App\Models\UserMessage;
use App\Models\UserMessageReply;

use App\Models\CustomerMessage;
use App\Models\CustomerMessageReply;

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

$factory->define(UserMessage::class, function (Faker $faker) {
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

$factory->define(UserMessageReply::class, function (Faker $faker) {
    return [
        'message_id' => random_int(\DB::table('user_messages')->min('id'), \DB::table('user_messages')->max('id')),
        'sender_id'=> random_int(\DB::table('users')->min('id'), \DB::table('users')->max('id')),
        'message' =>$faker->text,
        'isSeen' =>$faker->boolean,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => \Carbon\Carbon::now()
    ];
});


$factory->define(CustomerMessage::class, function (Faker $faker) {
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

$factory->define(CustomerMessageReply::class, function (Faker $faker) {
    return [
        'message_id' => random_int(\DB::table('customer_messages')->min('id'), \DB::table('customer_messages')->max('id')),
        'sender_id'=> random_int(\DB::table('users')->min('id'), \DB::table('users')->max('id')),
        'message' =>$faker->text,
        'isSeen' =>$faker->boolean,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => \Carbon\Carbon::now()
    ];
});



