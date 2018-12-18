<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_languages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sub_user_id')->unsigned();
            $table->foreign('sub_user_id')->references('id')->on('sub_users')->onDelete('cascade');
            $table->bigInteger('language_id')->unsigned();
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
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
        Schema::dropIfExists('business_languages');
    }
}
