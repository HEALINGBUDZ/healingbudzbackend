<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessTimingsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('business_timings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sub_user_id')->unsigned();
            $table->foreign('sub_user_id')->references('id')->on('sub_users')->onDelete('cascade');
            $table->string('monday', 255)->nullable();
            $table->string('tuesday', 255)->nullable();
            $table->string('wednesday', 255)->nullable();
            $table->string('thursday', 255)->nullable();
            $table->string('friday', 255)->nullable();
            $table->string('saturday', 255)->nullable();
            $table->string('sunday', 255)->nullable();
            $table->string('mon_end', 255)->nullable();
            $table->string('tue_end', 255)->nullable();
            $table->string('wed_end', 255)->nullable();
            $table->string('thu_end', 255)->nullable();
            $table->string('fri_end', 255)->nullable();
            $table->string('sat_end', 255)->nullable();
            $table->string('sun_end', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('business_timings');
    }

}
