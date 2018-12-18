<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW v_products AS
              
            SELECT products.*,
            `sub_users`.`user_id`,`sub_users`.`is_blocked`, `sub_users`.`zip_code`,`sub_users`.`title`, `sub_users`.`logo`, `sub_users`.`lat`, `sub_users`.`lng`,
            `tag_state_prices`.`tag_id`, `tag_state_prices`.`state`, `tag_state_prices`.`price`,
            `tags`.`title` AS `tag_title`
            FROM `products` 
            LEFT JOIN sub_users ON products.sub_user_id = sub_users.id
            LEFT JOIN tag_state_prices ON sub_users.user_id = tag_state_prices.user_id
            LEFT JOIN tags ON tag_state_prices.tag_id = tags.id");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('v_products');
    }
}
