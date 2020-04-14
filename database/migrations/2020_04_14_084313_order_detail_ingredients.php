<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrderDetailIngredients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        schema::create('order_detail_ingredients',function(Blueprint $table){
            $table->increments('id');
            $table->integer('order_details_id')->unsigned();
            $table->integer('product_ingredient_id')->unsigned();
            $table->timestamps();

            $table->foreign('order_details_id')->references('id')->on('order_details')
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
        schema::Drop('order_detail_ingredients');
    }
}
