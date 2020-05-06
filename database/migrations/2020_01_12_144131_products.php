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
            $table->text('description')->nullable();
            $table->boolean('isActive');
            $table->integer('minutes_required');
            $table->bigInteger('category_id')->unsigned();
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

        schema::create('product_option_groups',function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->boolean('isActive');
            $table->integer('product_id')->unsigned();
            $table->integer('minimum');
            $table->integer('maximum');
            $table->timestamps();

             $table->foreign('product_id')->references('id')->on('products')
                     ->onUpdate('cascade')->onDelete('cascade');
        });


        schema::create('product_options',function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->boolean('isActive');
            $table->integer('group_id')->unsigned();
            $table->integer('minutes_required');
            $table->double('price');
            $table->timestamps();

             $table->foreign('group_id')->references('id')->on('product_option_groups')
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
        schema::Drop('product_option_groups');
        schema::Drop('product_options');

    }
}
