<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessReviewReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_review_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('business_review_id')->unsigned();
            $table->foreign('business_review_id')->references('id')->on('business_reviews')->onDelete('cascade');
            $table->bigInteger('reported_by')->unsigned();
            $table->foreign('reported_by')->references('id')->on('users')->onDelete('cascade');
            $table->string('reason', 255)->nullable();
            $table->boolean('is_read')->default(0);
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
        Schema::dropIfExists('business_review_reports');
    }
}
