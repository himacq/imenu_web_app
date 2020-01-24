<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Products extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        schema::create('products',function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('image');
            $table->double('price');
            $table->boolean('isActive');
            $table->integer('minutes_required');
            $table->integer('category_id')->unsigned();
            $table->timestamps();
            
             $table->foreign('category_id')->references('id')->on('categories')
                     ->onUpdate('cascade')->onDelete('cascade');
        });
        
        schema::create('product_ingredients',function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->boolean('isActive');
            $table->integer('product_id')->unsigned();
            $table->timestamps();
            
             $table->foreign('product_id')->references('id')->on('products')
                     ->onUpdate('cascade')->onDelete('cascade');
        });
        
        schema::create('product_options',function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->boolean('isActive');
            $table->integer('product_id')->unsigned();
            $table->integer('minutes_required');
            $table->double('extra_price');
            $table->timestamps();
            
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
        //
        schema::Drop('products');
        schema::Drop('product_ingredients');
        schema::Drop('product_options');
    }
}
