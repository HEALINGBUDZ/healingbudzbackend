<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStrainReviewImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('strain_review_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('strain_id')->unsigned();
            $table->foreign('strain_id')->references('id')->on('strains')->onDelete('cascade');
            $table->bigInteger('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('strain_review_id')->unsigned();
            $table->foreign('strain_review_id')->references('id')->on('strain_reviews')->onDelete('cascade');
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
        Schema::dropIfExists('strain_review_images');
    }
}
