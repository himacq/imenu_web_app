<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CartDetailIngredients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        schema::create('cart_detail_ingredients',function(Blueprint $table){
            $table->increments('id');
            $table->integer('cart_details_id')->unsigned();
            $table->integer('product_ingredient_id')->unsigned();
            $table->timestamps();

            $table->foreign('cart_details_id')->references('id')->on('cart_details')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('product_ingredient_id')->references('id')->on('product_ingredients')
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
        schema::Drop('cart_detail_ingredients');
    }
}
