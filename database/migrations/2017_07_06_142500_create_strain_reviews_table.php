<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStrainReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('strain_reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('strain_id')->unsigned();
            $table->foreign('strain_id')->references('id')->on('strains')->onDelete('cascade');
            $table->bigInteger('reviewed_by')->unsigned();
            $table->foreign('reviewed_by')->references('id')->on('users')->onDelete('cascade');
            $table->longText('review');
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
        Schema::dropIfExists('strain_reviews');
    }
}
