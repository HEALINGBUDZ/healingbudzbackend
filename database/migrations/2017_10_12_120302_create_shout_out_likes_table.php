<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShoutOutLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shout_out_likes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('shout_out_id')->nullable()->unsigned();
            $table->foreign('shout_out_id')->references('id')->on('shout_outs')->onDelete('cascade');
            $table->bigInteger('liked_by')->unsigned();
            $table->foreign('liked_by')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('shout_out_likes');
    }
}
