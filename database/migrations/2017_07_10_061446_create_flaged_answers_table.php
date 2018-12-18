<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlagedAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flaged_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('answer_id')->unsigned();
            $table->foreign('answer_id')->references('id')->on('answers')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('flaged_user_id')->unsigned();
            $table->foreign('flaged_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('reason')->nullable();
            $table->boolean('is_read')->default(0);
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
        Schema::dropIfExists('flaged_answers');
    }
}
