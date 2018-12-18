<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVGetMySavesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        DB::statement("CREATE VIEW v_get_my_saves AS 
SELECT
  my_saves.*,
  IFNULL(questions.question,IFNULL(strains.title,IFNULL(journals.title,IFNULL(answers.answer,IFNULL(groups.title,IFNULL(sub_users.title,IFNULL(my_saves.strain_search_title,IFNULL(shout_outs.message,IFNULL(users.first_name,NULL))))))))) AS title
FROM my_saves
  LEFT JOIN questions
    ON my_saves.type_sub_id = questions.id
      AND my_saves.type_id = 4
  LEFT JOIN strains
    ON my_saves.type_sub_id = strains.id
      AND my_saves.type_id = 7
        LEFT JOIN journals
    ON my_saves.type_sub_id = journals.id
      AND my_saves.type_id = 3
         LEFT JOIN answers
    ON my_saves.type_sub_id = answers.id
      AND my_saves.type_id = 5
      LEFT JOIN groups
    ON my_saves.type_sub_id = groups.id
      AND my_saves.type_id = 6
      LEFT JOIN sub_users
    ON my_saves.type_sub_id = sub_users.id
      AND my_saves.type_id = 8
      LEFT JOIN shout_outs
    ON my_saves.type_sub_id = shout_outs.id
      AND my_saves.type_id = 11
      LEFT JOIN users
   ON users.description = users.id
      AND my_saves.type_id = 2 
      
");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('v_get_my_saves');
    }

}
