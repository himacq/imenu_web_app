<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('username')->unique();
            $table->string('password');
            $table->boolean('isActive')->default(1);
            $table->string('avatar')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('language_id')->nullable()->default('en');
            $table->integer('restaurant_id')->unsigned()->nullable();
            $table->boolean('news_letter')->default(0);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
