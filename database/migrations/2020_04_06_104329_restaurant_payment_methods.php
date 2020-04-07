<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RestaurantPaymentMethods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        schema::create('restaurant_payment_methods',function(Blueprint $table){
            $table->increments('id');
            $table->integer('restaurant_id')->unsigned();
            $table->integer('payment_id')->unsigned();
            $table->timestamps();

            $table->foreign('restaurant_id')->references('id')->on('restaurants')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('payment_id')->references('id')->on('payment_methods')
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
        schema::drop('restaurant_payment_methods');
    }
}
