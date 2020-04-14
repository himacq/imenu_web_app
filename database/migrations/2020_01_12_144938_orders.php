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
            $table->integer('user_id')->unsigned();
            $table->string('address_type')->nullable();
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->integer('house_no')->nullable();
            $table->integer('house_name')->nullable();
            $table->integer('floor_no')->nullable();
            $table->integer('apartment_no')->nullable()->default(0);
            $table->string('governorate')->nullable();
            $table->string('zip_code')->nullable();
            $table->text('latitude')->nullable();
            $table->text('longitude')->nullable();
            $table->boolean('isDefault');

            $table->timestamps();

             $table->foreign('user_id')->references('id')->on('users')
                     ->onUpdate('cascade')->onDelete('cascade');

        });

        schema::create('payment_methods',function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->text('api_url');
            $table->boolean('isActive');

            $table->timestamps();

        });

        schema::create('orders',function(Blueprint $table){
            $table->increments('id');
            $table->integer('grand_total')->double()->default(0);
            $table->integer('user_id')->unsigned();

            $table->timestamps();

             $table->foreign('user_id')->references('id')->on('users')
                     ->onUpdate('cascade')->onDelete('cascade');


        });

        schema::create('order_restaurants',function(Blueprint $table){
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->integer('restaurant_id')->unsigned();
            $table->double('sub_total');
            $table->integer('address_id')->nullable()->unsigned();
            $table->integer('payment_id')->nullable()->unsigned();

            $table->timestamps();


            $table->foreign('address_id')->references('id')->on('user_addresses')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('payment_id')->references('id')->on('payment_methods')
                ->onUpdate('cascade')->onDelete('cascade');

             $table->foreign('order_id')->references('id')->on('orders')
                     ->onUpdate('cascade')->onDelete('cascade');

             $table->foreign('restaurant_id')->references('id')->on('restaurants')
                     ->onUpdate('cascade')->onDelete('cascade');

        });

        schema::create('order_restaurant_statuses',function(Blueprint $table){
            $table->increments('id');
            $table->integer('order_restaurant_id')->unsigned();
            $table->integer('status')->unsigned();
            $table->timestamps();

             $table->foreign('order_restaurant_id')->references('id')->on('order_restaurants')
                     ->onUpdate('cascade')->onDelete('cascade');

             $table->foreign('status')->references('id')->on('lookup')
                     ->onUpdate('cascade')->onDelete('cascade');
        });

        schema::create('order_details',function(Blueprint $table){
            $table->increments('id');
            $table->integer('order_restaurant_id')->unsigned();;
            $table->integer('product_id')->unsigned();;
            $table->integer('qty');
            $table->double('price');
            $table->timestamps();

             $table->foreign('order_restaurant_id')->references('id')->on('order_restaurants')
                     ->onUpdate('cascade')->onDelete('cascade');

             $table->foreign('product_id')->references('id')->on('products')
                     ->onUpdate('cascade')->onDelete('cascade');
        });

        schema::create('order_detail_options',function(Blueprint $table){
            $table->increments('id');
            $table->integer('order_details_id')->unsigned();
            $table->integer('product_option_id')->unsigned();
            $table->double('price');
            $table->integer('qty');
            $table->timestamps();

            $table->foreign('order_details_id')->references('id')->on('order_details')
                     ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('product_option_id')->references('id')->on('product_options')
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
        schema::Drop('order_restaurants');
        schema::Drop('order_details');
        schema::Drop('order_detail_options');
    }
}
