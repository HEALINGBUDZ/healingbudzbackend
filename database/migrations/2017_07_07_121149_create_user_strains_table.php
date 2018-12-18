<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserStrainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_strains', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('strain_id')->unsigned();
            $table->foreign('strain_id')->references('id')->on('strains')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('indica')->nullable();
            $table->integer('sativa')->nullable();
            $table->string('genetics', 100)->nullable();
            $table->string('cross_breed', 255)->nullable();
            $table->float('min_CBD', 8,2)->nullable();
            $table->float('max_CBD', 8,2)->nullable();
            $table->float('min_THC', 8,2)->nullable();
            $table->float('max_THC', 8,2)->nullable();
            $table->string('growing', 100)->nullable();
            $table->float('plant_height', 8,2)->nullable();
            $table->integer('flowering_time')->nullable();
            $table->float('min_fahren_temp', 8,2)->nullable();
            $table->float('max_fahren_temp', 8,2)->nullable();
            $table->float('min_celsius_temp', 8,2)->nullable();
            $table->float('max_celsius_temp', 8,2)->nullable();
            $table->string('yeild', 100)->nullable();
            $table->string('climate', 100)->nullable();
            $table->string('note', 255)->nullable();
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('user_strains');
    }
}
