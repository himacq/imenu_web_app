<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Messages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         schema::create('messages',function(Blueprint $table){
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
        
        schema::create('message_replies',function(Blueprint $table){
            $table->increments('id');
            $table->integer('message_id')->unsigned();;
            $table->integer('sender_id')->unsigned();;
            $table->text('message');
            $table->boolean('isSeen');
            
            $table->timestamps();
            
             $table->foreign('message_id')->references('id')->on('messages')
                     ->onUpdate('cascade')->onDelete('cascade');
             
             $table->foreign('sender_id')->references('id')->on('users')
                     ->onUpdate('cascade')->onDelete('cascade');

        });
        
        /*schema::create('message_attachements',function(Blueprint $table){
            $table->increments('id');
            $table->integer('message_id')->unsigned();;
            $table->string('file');
            $table->string('name');
            $table->timestamps();
            
             $table->foreign('message_id')->references('id')->on('messages')
                     ->onUpdate('cascade')->onDelete('cascade');
            
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        schema::Drop('messages');
        schema::Drop('message_replies');
        //schema::Drop('message_attachements');
    }
}
