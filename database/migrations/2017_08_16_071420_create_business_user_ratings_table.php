<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessUserRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_user_ratings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sub_user_id')->unsigned();
            $table->foreign('sub_user_id')->references('id')->on('sub_users')->onDelete('cascade');
            $table->bigInteger('rated_by')->unsigned();
            $table->foreign('rated_by')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('review_id')->unsigned();
            $table->foreign('review_id')->references('id')->on('business_reviews')->onDelete('cascade');
            $table->float('rating');
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
        Schema::dropIfExists('business_user_ratings');
    }
}
