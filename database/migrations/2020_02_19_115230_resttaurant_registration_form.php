<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ResttaurantRegistrationForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        schema::create('restaurant_registrations',function(Blueprint $table){
            $table->increments('id');
            $table->bigInteger('user_id')->unsigned();
            $table->string('name');
            $table->string('id_img')->nullable();
            $table->string('license_img')->nullable();
            $table->string('education_level')->nullable();
            $table->string('city')->nullable();
            $table->string('locality')->nullable();
            $table->string('address')->nullable();
            $table->string('duty')->nullable();
            $table->string('starting')->nullable();
            $table->string('ending')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('business_title')->nullable();
            $table->integer('branches_count');
            $table->json('branches');

            $table->bigInteger('status')->unsigned();


            $table->timestamps();




        });

        Schema::table('restaurant_registrations', function($table) {
                $table->foreign('status')->references('id')->on('lookup')
                        ->onUpdate('cascade')->onDelete('cascade');
                });

       Schema::table('restaurant_registrations', function($table) {
                $table->foreign('user_id')->references('id')->on('users')
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
        Schema::dropIfExists('restaurant_registrations');
    }
}
