<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdminRestaurantReviews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        schema::create('admin_restaurant_reviews',function(Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_restaurant_reviews');
    }
}
