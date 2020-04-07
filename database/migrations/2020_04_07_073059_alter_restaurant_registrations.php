<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRestaurantRegistrations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('restaurant_registrations', function($table) {
            $table->text('latitude')->nullable();
            $table->text('longitude')->nullable();
            $table->double('distance')->nullable();
        });

        Schema::table('restaurants', function($table) {
            $table->double('distance')->nullable();
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
    }
}
