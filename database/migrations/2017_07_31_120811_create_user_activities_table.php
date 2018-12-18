<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('on_user')->nullable()->unsigned();
            $table->foreign('on_user')->references('id')->on('users')->onDelete('cascade');
            $table->enum('type', ['Questions', 'Answers', 'Favorites', 'Likes', 'Groups', 'Journal', 'Tags', 'Budz Map', 'Strains', 'Users', 'Chat', 'ShoutOut','Comment','Post','BudzChat','Admin']);
            $table->bigInteger('type_id');
            $table->longText('description')->nullable();
            $table->string('text', 255)->nullable();
            $table->string('model', 20)->nullable();
            $table->bigInteger('type_sub_id')->nullable();
            $table->boolean('is_read')->default(0);
            $table->boolean('is_deleted')->default(0);
            $table->string('notification_text', 255)->nullable();
            $table->longText('unique_description')->nullable();
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
        Schema::dropIfExists('user_activities');
    }
}
