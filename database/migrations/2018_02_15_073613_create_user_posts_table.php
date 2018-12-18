<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPostsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('user_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('sub_user_id')->nullable()->unsigned();
            $table->foreign('sub_user_id')->references('id')->on('sub_users')->onDelete('cascade');
            $table->longText('description')->nullable();
            $table->longText('json_data')->nullable();
            $table->boolean('allow_repost')->default(0);
            $table->bigInteger('shared_id')->nullable();
            $table->bigInteger('shared_user_id')->unsigned()->nullable();
            $table->foreign('shared_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->longText('post_added_comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('user_posts');
    }

}
