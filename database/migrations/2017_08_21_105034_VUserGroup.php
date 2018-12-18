<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VUserGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW v_user_groups AS
SELECT `groups`.*, (SELECT COUNT(*) FROM `group_followers` WHERE `groups`.`id` = `group_followers`.`group_id`) AS `get_members_count` FROM `groups`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
