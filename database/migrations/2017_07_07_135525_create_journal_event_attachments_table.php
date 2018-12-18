<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJournalEventAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journal_event_attachments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('journal_event_id')->unsigned();
            $table->foreign('journal_event_id')->references('id')->on('journal_events')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('attachment_path', 255);
            $table->string('attachment_type', 100);
            $table->string('poster', 255)->nullable();
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
        Schema::dropIfExists('journal_event_attachments');
    }
}
