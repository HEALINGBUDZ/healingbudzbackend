<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJournalEventTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journal_event_tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('journal_id')->unsigned();
            $table->foreign('journal_id')->references('id')->on('journals')->onDelete('cascade');
            $table->bigInteger('journal_event_id')->unsigned();
            $table->foreign('journal_event_id')->references('id')->on('journal_events')->onDelete('cascade');
            $table->bigInteger('tag_id')->unsigned();
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
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
        Schema::dropIfExists('journal_event_tags');
    }
}
