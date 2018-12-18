<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPointsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('user_points', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type', ['Complete Profile', 'Strain Survey', 'Follow Bud', 'Invite Friend', 'Ask Question', 'Share Question', 'Follow Keyword', 'Join Group','First Question','Share','Strain Like','Answer Like']);
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('points');
            $table->string('type_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('user_points');
    }

}
