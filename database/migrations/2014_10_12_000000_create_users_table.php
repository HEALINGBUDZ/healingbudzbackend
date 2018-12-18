<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     * @return void
     */
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name', 50)->nullable();
            $table->string('last_name', 50)->nullable();
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->integer('zip_code')->nullable();
            $table->string('city', 255)->nullable();
            $table->integer('state_id')->nullable();
            $table->string('stripe_id', 255)->nullable();
            $table->string('card_brand', 255)->nullable();
            $table->string('card_last_four', 255)->nullable();
            $table->string('expire_date', 255)->nullable();
            $table->string('card_id', 255)->nullable();
            $table->string('remaing_cash', 255)->nullable();
            $table->bigInteger('cashspend')->nullable();
            $table->string('image_path', 255)->nullable();
            $table->integer('user_type');
            $table->string('avatar', 255)->nullable();
            $table->string('special_icon', 255)->nullable();
            $table->string('cover', 255)->nullable();
            $table->string('cover_full', 255)->nullable();
            $table->longText('bio')->nullable();
            $table->text('location')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('fb_id', 255)->nullable();
            $table->string('google_id', 255)->nullable();
            $table->boolean('is_web')->default(0);
            $table->boolean('show_budz_popup')->default(1)->nullable();
            $table->boolean('show_my_save')->default(0);
            $table->integer('points')->default(0);
            $table->integer('point_redeem')->nullable()->default(0);
            $table->string('emaillestorecode', 500)->nullable();
            $table->boolean('is_blocked')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('users');
    }

}
