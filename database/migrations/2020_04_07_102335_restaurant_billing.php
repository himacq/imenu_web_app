<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RestaurantBilling extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        schema::create('restaurant_billings',function(Blueprint $table){
            $table->increments('id');
            $table->integer('restaurant_id')->unsigned();
            $table->integer('payment_id')->unsigned();
            $table->double('sub_total');
            $table->integer('order_id')->unsigned();
            $table->integer('order_restaurant_id')->unsigned();
            $table->double('commision');
            $table->double('discount');
            $table->double('restaurant_distance');
            $table->double('order_distance');
            $table->boolean('distance_exceeded');
            $table->double('credit');
            $table->double('debit');

            $table->timestamps();

            $table->foreign('restaurant_id')->references('id')->on('restaurants')
                ->onUpdate('restrict')->onDelete('restrict');

            $table->foreign('payment_id')->references('id')->on('payment_methods')
                ->onUpdate('restrict')->onDelete('restrict');

            $table->foreign('order_id')->references('id')->on('orders')
                ->onUpdate('restrict')->onDelete('restrict');

            $table->foreign('order_restaurant_id')->references('id')->on('order_restaurants')
                ->onUpdate('restrict')->onDelete('restrict');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        schema::Drop('restaurant_billings');
    }
}
