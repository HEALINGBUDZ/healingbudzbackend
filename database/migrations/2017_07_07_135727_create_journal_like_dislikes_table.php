<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJournalLikeDislikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journal_like_dislikes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('journal_event_id')->unsigned();
            $table->foreign('journal_event_id')->references('id')->on('journal_events')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('is_like')->default(0);
            $table->boolean('is_dislike')->default(0);
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
        Schema::dropIfExists('journal_like_dislikes');
    }
}
