<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Orders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        schema::create('user_addresses',function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->unsigned();;
            $table->string('street');
            $table->string('city');
            $table->integer('house_no')->nullable();
            $table->integer('floor_no')->nullable();
            $table->integer('appartment_no')->nullable;
            $table->string('governorate');
            $table->string('zip_code');
            $table->boolean('isDefault');
            
            $table->timestamps();
            
             $table->foreign('user_id')->references('id')->on('users')
                     ->onUpdate('cascade')->onDelete('cascade');
        });
        
        schema::create('orders',function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->unsigned();;
            $table->integer('order_status');
            $table->integer('address_id')->unsigned();;
                        
            $table->timestamps();
            
             $table->foreign('user_id')->references('id')->on('users')
                     ->onUpdate('cascade')->onDelete('cascade');
             
            $table->foreign('address_id')->references('id')->on('user_addresses')
                     ->onUpdate('cascade')->onDelete('cascade');
        });
        
        schema::create('order_details',function(Blueprint $table){
            $table->increments('id');
            $table->integer('order_id')->unsigned();;
            $table->integer('product_id')->unsigned();;
            $table->integer('qty');
            $table->json('options');
            $table->double('price');
            $table->timestamps();
            
             $table->foreign('order_id')->references('id')->on('orders')
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
        schema::Drop('user_addresses');
        schema::Drop('orders');
        schema::Drop('order_details');
    }
}
