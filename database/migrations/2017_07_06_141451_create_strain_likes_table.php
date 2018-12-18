<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStrainLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('strain_likes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('strain_id')->unsigned();
            $table->foreign('strain_id')->references('id')->on('strains')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('is_like')->nullable();
            $table->boolean('is_dislike')->nullable();
            $table->boolean('is_flaged')->nullable();
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
        Schema::dropIfExists('strain_likes');
    }
}
