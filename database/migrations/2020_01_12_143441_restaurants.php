<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Restaurants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        schema::create('restaurants',function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();
            $table->integer('status')->unsigned();
            $table->string('verification_code', 4)->unique();
            $table->integer('manager_id')->unsigned();
            $table->integer('branch_of')->nullable()->unsigned();
            $table->text('latitude')->nullable();
            $table->text('longitude')->nullable();
            $table->text('working_details')->nullable();
            $table->text('extra_info')->nullable();
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->string('phone3')->nullable();
            $table->string('mobile1')->nullable();
            $table->string('mobile2')->nullable();
            $table->string('email');
            
            $table->timestamps();
            
            
            
            
        });
        
        Schema::table('restaurants', function($table) {
            $table->foreign('status')->references('id')->on('lookup')
                    ->onUpdate('cascade')->onDelete('cascade');
            });
            
            Schema::table('restaurants', function($table) {
             $table->foreign('manager_id')->references('id')->on('users')
                     ->onUpdate('cascade')->onDelete('cascade');
            });
            
            
            Schema::table('restaurants', function($table) {
            $table->foreign('branch_of')->references('id')->on('restaurants')
                     ->onUpdate('cascade')->onDelete('cascade');
            });
        
         schema::create('restaurant_review',function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('restaurant_id')->unsigned();
            $table->text('review_text');
            $table->integer('review_rank');
            $table->boolean('isActive');
            $table->timestamps();
            
             $table->foreign('user_id')->references('id')->on('users')
                     ->onUpdate('cascade')->onDelete('cascade');
             
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
        Schema::dropIfExists('restaurants');
        Schema::dropIfExists('restaurant_review');
        
    }
}
