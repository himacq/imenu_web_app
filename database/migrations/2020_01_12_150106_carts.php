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
        schema::create('favorits',function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->unsigned();;
            $table->integer('product_id')->unsigned();;
            
            $table->timestamps();
            
             $table->foreign('user_id')->references('id')->on('users')
                     ->onUpdate('cascade')->onDelete('cascade');
             
             $table->foreign('product_id')->references('id')->on('products')
                     ->onUpdate('cascade')->onDelete('cascade');
        });
        
        schema::create('carts',function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->unsigned();;                       
            $table->timestamps();
            
             $table->foreign('user_id')->references('id')->on('users')
                     ->onUpdate('cascade')->onDelete('cascade');

        });
        
        schema::create('cart_details',function(Blueprint $table){
            $table->increments('id');
            $table->integer('cart_id')->unsigned();;
            $table->integer('product_id')->unsigned();;
            $table->integer('qty');
            $table->json('options');
            $table->double('price');
            $table->timestamps();
            
             $table->foreign('cart_id')->references('id')->on('carts')
                     ->onUpdate('cascade')->onDelete('cascade');
             
             $table->foreign('product_id')->references('id')->on('products')
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
        schema::Drop('favorits');
        schema::Drop('carts');
        schema::Drop('cart_details');
    }
}
