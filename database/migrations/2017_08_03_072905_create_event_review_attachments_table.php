<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventReviewAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_review_attachments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('event_review_id')->unsigned();
            $table->foreign('event_review_id')->references('id')->on('event_reviews')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('attachment', 255);
            $table->enum('upload_type', ['image', 'video']);
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
        Schema::dropIfExists('event_review_attachments');
    }
}
