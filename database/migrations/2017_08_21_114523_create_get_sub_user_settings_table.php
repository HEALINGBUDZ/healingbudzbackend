<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGetSubUserSettingsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        DB::statement("CREATE VIEW v_get_sub_user_settings AS 
SELECT
  `sub_users`.*,`subscriptions`.`ends_at`,`subscriptions`.`stripe_id` AS s_id,`subscriptions`.`name`,
  (SELECT
     COUNT(*)
   FROM `business_reviews`
   WHERE `sub_users`.`id` = `business_reviews`.`sub_user_id`) AS `review_count`
FROM `sub_users`
LEFT JOIN subscriptions ON sub_users.id=subscriptions.sub_user_id;
");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('get_sub_user_settings');
    }

}
