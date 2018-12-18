<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShoutOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shout_outs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('sub_user_id')->nullable()->unsigned();
            $table->foreign('sub_user_id')->references('id')->on('sub_users')->onDelete('cascade');
            $table->string('title', 255);
            $table->string('message', 255);
            $table->date('validity_date');
            $table->string('image')->nullable();
            $table->float('lat')->nullable();
            $table->float('lng')->nullable();
            $table->integer('zip_code')->nullable();
            $table->string('public_location')->nullable()->default(0);
            $table->bigInteger('budz_special_id')->unsigned();
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
        Schema::dropIfExists('shout_outs');
    }
}
