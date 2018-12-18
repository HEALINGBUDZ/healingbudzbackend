<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStrainReviewFlagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('strain_review_flags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('strain_id')->unsigned();
            $table->foreign('strain_id')->references('id')->on('strains')->onDelete('cascade');
            $table->bigInteger('strain_review_id')->unsigned();
            $table->foreign('strain_review_id')->references('id')->on('strain_reviews')->onDelete('cascade');
            $table->bigInteger('flaged_by')->unsigned();
            $table->foreign('flaged_by')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('is_flaged')->default(0);
            $table->boolean('is_read')->default(0);
            $table->string('reason')->nullable();
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
        Schema::dropIfExists('strain_review_flags');
    }
}
