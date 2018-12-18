<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSearchedKeywordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('searched_keywords', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key_word');
            $table->float('price')->nullable();
            $table->boolean('on_sale')->default(0);
            $table->boolean('is_tag')->default(0);
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
        Schema::dropIfExists('searched_keywords');
    }
}
