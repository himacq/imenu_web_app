<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RestaurantQuestionsAnswers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        schema::create('registrations_questions_answers',function(Blueprint $table){
            $table->increments('id');
            $table->integer('registration_id')->unsigned();
            $table->integer('question_id')->unsigned();
            $table->string('answer');

            $table->timestamps();

        });

        Schema::table('registrations_questions_answers', function($table) {
                $table->foreign('question_id')->references('id')->on('registrations_questions')
                        ->onUpdate('cascade')->onDelete('cascade');

                $table->foreign('registration_id')->references('id')->on('restaurant_registrations')
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
        Schema::dropIfExists('registrations_questions_answers');
    }
}
