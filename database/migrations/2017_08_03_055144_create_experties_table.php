<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 100);
            $table->bigInteger('exp_question_id')->unsigned();
            $table->foreign('exp_question_id')->references('id')->on('expertise_questions')->onDelete('cascade');
            $table->boolean('is_approved')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('experties');
    }
}