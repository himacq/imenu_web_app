<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Carts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        schema::create('favourites',function(Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->integer('product_id')->unsigned();;

            $table->timestamps();

             $table->foreign('user_id')->references('id')->on('users')
                     ->onUpdate('cascade')->onDelete('cascade');

             $table->foreign('product_id')->references('id')->on('products')
                     ->onUpdate('cascade')->onDelete('cascade');
        });

        schema::create('carts',function(Blueprint $table){
            $table->bigIncrements('id');
            $table->integer('grand_total')->double()->default(0);
            $table->bigInteger('user_id')->unsigned();;
            $table->timestamps();

             $table->foreign('user_id')->references('id')->on('users')
                     ->onUpdate('cascade')->onDelete('cascade');

        });

        schema::create('cart_restaurants',function(Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('cart_id')->unsigned();;
            $table->integer('restaurant_id')->unsigned();;
            $table->double('sub_total')->nullable();
            $table->timestamps();

             $table->foreign('cart_id')->references('id')->on('carts')
                     ->onUpdate('cascade')->onDelete('cascade');

             $table->foreign('restaurant_id')->references('id')->on('restaurants')
                     ->onUpdate('cascade')->onDelete('cascade');
        });


        schema::create('cart_details',function(Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('cart_restaurant_id')->unsigned();;
            $table->integer('product_id')->unsigned();;
            $table->integer('qty');
            $table->double('price');
            $table->timestamps();

             $table->foreign('cart_restaurant_id')->references('id')->on('cart_restaurants')
                     ->onUpdate('cascade')->onDelete('cascade');

             $table->foreign('product_id')->references('id')->on('products')
                     ->onUpdate('cascade')->onDelete('cascade');
        });

        schema::create('cart_detail_options',function(Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('cart_details_id')->unsigned();
            $table->integer('product_option_id')->unsigned();
            $table->double('price');
            $table->integer('qty');
            $table->timestamps();

            $table->foreign('cart_details_id')->references('id')->on('cart_details')
                     ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('product_option_id')->references('id')->on('product_options')
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
        schema::Drop('favourites');
        schema::Drop('carts');
        schema::Drop('cart_restaurants');
        schema::Drop('cart_details');
        schema::Drop('cart_detail_options');
    }
}
