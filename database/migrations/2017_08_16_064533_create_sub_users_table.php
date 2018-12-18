<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('sub_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('business_type_id')->unsigned()->nullable();
            $table->foreign('business_type_id')->references('id')->on('business_types')->onDelete('cascade');
            $table->string('title', 100);
            $table->string('logo', 255)->nullable();
            $table->string('banner', 255)->nullable();
            $table->string('banner_full', 255)->nullable();
            $table->string('top', 255)->nullable();
            $table->string('y', 255)->nullable();
            $table->boolean('is_organic')->default(0);
            $table->boolean('is_delivery')->default(0);
            $table->longText('description')->nullable();
            $table->string('location', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('phone')->nullable();
            $table->string('zip_code', 100)->nullable();
            $table->string('web', 255)->nullable();
            $table->string('facebook', 255)->nullable();
            $table->string('twitter', 255)->nullable();
            $table->bigInteger('is_blocked')->default(0)->nullable();
            $table->string('instagram', 255)->nullable();
            $table->enum('insurance_accepted', ['Yes', 'No'])->nullable();
            $table->string('office_policies', 500)->nullable();
            $table->string('visit_requirements', 500)->nullable();
            $table->string('others_image', 500)->nullable();
            $table->bigInteger('menu_tab_count')->default(0);
            $table->bigInteger('purchase_ticket_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('sub_users');
    }

}
