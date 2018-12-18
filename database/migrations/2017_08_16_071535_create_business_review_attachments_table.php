<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessReviewAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_review_attachments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('business_review_id')->unsigned();
            $table->foreign('business_review_id')->references('id')->on('business_reviews')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('attachment', 255);
            $table->string('type', 50);
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
        Schema::dropIfExists('business_review_attachments');
    }
}
