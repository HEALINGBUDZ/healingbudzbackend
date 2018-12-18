<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('chat_id')->unsigned();
            $table->foreign('chat_id')->references('id')->on('chat_users')->onDelete('cascade');
            $table->bigInteger('sender_id')->unsigned();
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('receiver_id')->unsigned();
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
            $table->longText('message')->nullable();
            $table->string('file_type', 50)->nullable();
            $table->string('file_path', 255)->nullable();
            $table->boolean('is_read')->default(0);
            $table->boolean('sender_deleted')->default(0);
            $table->boolean('receiver_deleted')->default(0);
            $table->string('poster', 255)->nullable();
            $table->string('site_title', 255)->nullable();
            $table->string('site_content', 255)->nullable();
            $table->string('site_image', 255)->nullable();
            $table->string('site_extracted_url', 255)->nullable();
            $table->string('site_url', 255)->nullable();
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
        Schema::dropIfExists('chat_messages');
    }
}
