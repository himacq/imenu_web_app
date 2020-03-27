<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Restaurants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        schema::create('restaurants',function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();
            $table->integer('isActive')->unsigned();
            $table->string('verification_code', 4)->unique();
            $table->integer('owner_id')->nullable()->unsigned();
            $table->integer('branch_of')->nullable()->unsigned();
            $table->text('latitude')->nullable();
            $table->text('longitude')->nullable();
            $table->text('extra_info')->nullable();
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->string('phone3')->nullable();
            $table->string('mobile1')->nullable();
            $table->string('mobile2')->nullable();
            $table->string('email')->nullable();
            $table->double('commision')->nullable();
            $table->double('discount')->nullable();

            $table->timestamps();




        });



            Schema::table('restaurants', function($table) {
             $table->foreign('owner_id')->references('id')->on('users')
                     ->onUpdate('cascade')->onDelete('cascade');
            });


            Schema::table('restaurants', function($table) {
            $table->foreign('branch_of')->references('id')->on('restaurants')
                     ->onUpdate('cascade')->onDelete('cascade');
            });

         schema::create('restaurant_reviews',function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('restaurant_id')->unsigned();
            $table->text('review_text');
            $table->integer('review_rank');
            $table->boolean('isActive');
            $table->timestamps();

             $table->foreign('user_id')->references('id')->on('users')
                     ->onUpdate('cascade')->onDelete('cascade');

             $table->foreign('restaurant_id')->references('id')->on('restaurants')
                     ->onUpdate('cascade')->onDelete('cascade');
        });


        schema::create('restaurant_working_details',function(Blueprint $table){
            $table->increments('id');
            $table->integer('restaurant_id')->unsigned();
            $table->text('display_text');
            $table->time('start_at');
            $table->time('end_at');
            $table->timestamps();

             $table->foreign('restaurant_id')->references('id')->on('restaurants')
                     ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurants');
        Schema::dropIfExists('restaurant_review');
        Schema::dropIfExists('restaurant_working_details');

    }
}
