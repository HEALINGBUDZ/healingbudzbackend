<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSearchCountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('search_counts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('keyword_id')->unsigned();
            $table->foreign('keyword_id')->references('id')->on('searched_keywords')->onDelete('cascade');
            $table->integer('count');
            $table->date('date');
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
        Schema::dropIfExists('search_counts');
    }
}
