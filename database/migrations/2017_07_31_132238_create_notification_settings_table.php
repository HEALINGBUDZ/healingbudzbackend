<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('new_question')->default(0)->nullable();
            $table->boolean('follow_question_answer')->default(0)->nullable();
            $table->boolean('public_joined')->default(0)->nullable();
            $table->boolean('private_joined')->default(0)->nullable();
            $table->boolean('follow_strains')->default(0)->nullable();
            $table->boolean('specials')->default(0)->nullable();
            $table->boolean('shout_out')->default(0)->nullable();
            $table->boolean('message')->default(0)->nullable();
            $table->boolean('follow_profile')->default(0)->nullable();
            $table->boolean('follow_journal')->default(0)->nullable();
            $table->boolean('your_strain')->default(0)->nullable();
            $table->boolean('like_question')->default(0)->nullable();
            $table->boolean('like_answer')->default(0)->nullable();
            $table->boolean('like_journal')->default(0)->nullable();
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
        Schema::dropIfExists('notification_settings');
    }
}
