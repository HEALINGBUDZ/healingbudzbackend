<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title',500);
            $table->longText('description');
            $table->string('image');
            $table->string('thumb')->nullable();
            $table->enum('type',['Article','Strain','Question'])->default('Article');
            $table->boolean('displayed')->default(0);
            $table->bigInteger('question_id')->nullable()->unsigned();
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->bigInteger('user_strain_id')->nullable()->unsigned();
            $table->foreign('user_strain_id')->references('id')->on('user_strains')->onDelete('cascade');
            $table->bigInteger('cat_id')->nullable()->unsigned();
            $table->foreign('cat_id')->references('id')->on('artical_categories')->onDelete('cascade');
            $table->string('display_date',20)->nullable();
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
        Schema::dropIfExists('articles');
    }
}
