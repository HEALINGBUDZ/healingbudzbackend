<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubUserFlagsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('sub_user_flags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('budz_id')->unsigned();
            $table->foreign('budz_id')->references('id')->on('sub_users')->onDelete('cascade');
            $table->bigInteger('reported_by')->unsigned();
            $table->boolean('is_read')->default(0)->nullable();
            $table->foreign('reported_by')->references('id')->on('users')->onDelete('cascade');
            $table->string('reason', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('sub_user_flags');
    }

}
