<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CustomerMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        schema::create('customer_messages',function(Blueprint $table){
            $table->increments('id');
            $table->integer('sender_id')->unsigned();
            $table->integer('receiver_id')->unsigned();
            $table->integer('message_type');
            $table->string('title');
            $table->text('message');
            $table->boolean('isSeen');
            $table->timestamps();

            $table->foreign('sender_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');



        });

        schema::create('customer_message_replies',function(Blueprint $table){
            $table->increments('id');
            $table->integer('message_id')->unsigned();;
            $table->integer('sender_id')->unsigned();;
            $table->text('message');
            $table->boolean('isSeen');

            $table->timestamps();

            $table->foreign('message_id')->references('id')->on('customer_messages')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('sender_id')->references('id')->on('users')
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
        schema::Drop('customer_messages');
        schema::Drop('customer_message_replies');
    }
}
