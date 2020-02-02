<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BillingPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        
        schema::create('billing',function(Blueprint $table){
            $table->increments('id');
            $table->integer('order_id')->unsigned();;
            $table->integer('payment_method')->unsigned();;
            $table->dateTime('payment_date');
            $table->integer('payment_status')->unsigned();;
            
            
            $table->timestamps();
            
             $table->foreign('order_id')->references('id')->on('orders')
                     ->onUpdate('cascade')->onDelete('cascade');
             
             $table->foreign('payment_method')->references('id')->on('payment_methods')
                     ->onUpdate('cascade')->onDelete('cascade');
             
             $table->foreign('payment_status')->references('id')->on('lookup')
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
        schema::Drop('payment_methods');
        schema::Drop('billing');
    }
}
