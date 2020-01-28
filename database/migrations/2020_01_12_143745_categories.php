<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Categories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        schema::create('categories',function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('image');
            $table->boolean('isActive');
            $table->integer('restaurant_id')->unsigned();
            $table->timestamps();
            
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
        Schema::dropIfExists('categories');
    }
}
