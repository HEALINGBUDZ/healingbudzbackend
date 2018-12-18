<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudzFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budz_feeds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sub_user_id')->nullable()->unsigned();
            $table->foreign('sub_user_id')->references('id')->on('sub_users')->onDelete('cascade');
            $table->bigInteger('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('search_by')->nullable()->unsigned();
            $table->foreign('search_by')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('review_id')->nullable()->unsigned();
            $table->foreign('review_id')->references('id')->on('business_reviews')->onDelete('cascade');
            $table->bigInteger('my_save_id')->nullable()->unsigned();
            $table->foreign('my_save_id')->references('id')->on('my_saves')->onDelete('cascade');
            $table->bigInteger('share_id')->nullable()->unsigned();
            $table->foreign('share_id')->references('id')->on('business_shares')->onDelete('cascade');
            $table->bigInteger('tag_id')->nullable()->unsigned();
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            $table->bigInteger('views')->default(0);
            $table->bigInteger('cta')->default(0);
            $table->bigInteger('click_to_call')->default(0);
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
        Schema::dropIfExists('budz_feeds');
    }
}
