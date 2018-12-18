<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sub_user_id')->unsigned();
            $table->foreign('sub_user_id')->references('id')->on('sub_users')->onDelete('cascade');
            $table->bigInteger('strain_id')->nullable()->unsigned();
            $table->foreign('strain_id')->references('id')->on('strains')->onDelete('cascade');
            $table->bigInteger('type_id')->nullable()->unsigned();
             $table->bigInteger('menu_cat_id')->nullable()->unsigned();
            $table->foreign('menu_cat_id')->references('id')->on('menu_categories')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('strain_types')->onDelete('cascade');
            $table->string('name', 100);
//            $table->string('type', 100);
            $table->float('thc', 8,2)->nullable();
            $table->float('cbd', 8,2)->nullable();
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
        Schema::dropIfExists('products');
    }
}
