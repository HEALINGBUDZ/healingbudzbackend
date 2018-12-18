<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStrainRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('strain_ratings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('rated_by')->unsigned();
            $table->foreign('rated_by')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('strain_id')->unsigned();
            $table->foreign('strain_id')->references('id')->on('strains')->onDelete('cascade');
            $table->bigInteger('strain_review_id')->unsigned();
            $table->foreign('strain_review_id')->references('id')->on('strain_reviews')->onDelete('cascade');
            
            $table->float('rating', 8,2);
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
        Schema::dropIfExists('strain_ratings');
    }
}
