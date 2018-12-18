<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudzChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budz_chats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sender_id')->unsigned();
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('receiver_id')->unsigned();
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('budz_id')->unsigned();
            $table->foreign('budz_id')->references('id')->on('sub_users')->onDelete('cascade');
            $table->bigInteger('last_message_id')->default(0);
            $table->boolean('sender_deleted')->default(0);
            $table->boolean('receiver_deleted')->default(0);
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
        Schema::dropIfExists('budz_chats');
    }
}
