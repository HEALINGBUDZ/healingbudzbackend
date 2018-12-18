<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVSurveyCountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW v_survey_counts AS (
SELECT strain_id,user_id,
  (SELECT
     GROUP_CONCAT(s_data.s_id,'-',s_data.sensation)
   FROM v_top_survey_answers s_data
   WHERE s_data.strain_id = v_main.strain_id AND v_main.user_id = s_data.user_id AND s_data.s_id IS NOT NULL ) AS s_data,
   (SELECT
     GROUP_CONCAT(s_data.m_id,'-',s_data.m_condition)
   FROM v_top_survey_answers s_data
   WHERE s_data.strain_id = v_main.strain_id AND v_main.user_id = s_data.user_id AND s_data.m_id IS NOT NULL ) AS m_data,
   (SELECT
     GROUP_CONCAT(s_data.n_id,'-',s_data.n_effect)
   FROM v_top_survey_answers s_data
   WHERE s_data.strain_id = v_main.strain_id AND v_main.user_id = s_data.user_id AND s_data.n_id IS NOT NULL ) AS n_data,
   (SELECT
     GROUP_CONCAT(s_data.p_id,'-',s_data.prevention)
   FROM v_top_survey_answers s_data
   WHERE s_data.strain_id = v_main.strain_id AND v_main.user_id = s_data.user_id AND s_data.p_id IS NOT NULL ) AS p_data,
   (SELECT
     GROUP_CONCAT(s_data.f_id,'-',s_data.flavor)
   FROM v_top_survey_answers s_data
   WHERE s_data.strain_id = v_main.strain_id AND v_main.user_id = s_data.user_id AND s_data.f_id IS NOT NULL ) AS f_data
FROM v_top_survey_answers v_main

GROUP BY v_main.user_id, v_main.strain_id
HAVING f_data AND s_data AND m_data AND n_data)");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('v_survey_counts');
    }
}
