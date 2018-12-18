<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVTopSurveyAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
   {
        DB::statement("CREATE VIEW v_top_survey_answers AS 
SELECT
	medical_conditions.id AS m_id,medical_conditions.m_condition,
	sensations.id AS s_id,sensations.sensation,
	negative_effects.id AS n_id,negative_effects.effect AS n_effect,
	disease_preventions.id AS p_id,disease_preventions.prevention,
        flavors.id AS f_id,flavors.flavor,
	strain_survey_answers.question_id,strain_survey_answers.strain_id, strain_survey_answers.user_id, COUNT(*) AS result
FROM strain_survey_answers
LEFT JOIN medical_conditions ON (CONCAT(',',REPLACE(`strain_survey_answers`.`answer`,', ',','),',')) LIKE CONCAT('%,',TRIM(medical_conditions.m_condition),',%') AND medical_conditions.is_approved = 1
LEFT JOIN sensations ON (CONCAT(',',REPLACE(`strain_survey_answers`.`answer`,', ',','),',')) LIKE CONCAT('%,',TRIM(sensations.sensation),',%') AND sensations.is_approved = 1
LEFT JOIN negative_effects ON (CONCAT(',',REPLACE(`strain_survey_answers`.`answer`,', ',','),',')) LIKE CONCAT('%,',TRIM(negative_effects.effect),',%') AND negative_effects.is_approved = 1
LEFT JOIN disease_preventions ON (CONCAT(',',REPLACE(`strain_survey_answers`.`answer`,', ',','),',')) LIKE CONCAT('%,',TRIM(disease_preventions.prevention),',%') AND disease_preventions.is_approved = 1
LEFT JOIN flavors ON (CONCAT(',',REPLACE(`strain_survey_answers`.`answer`,', ',','),',')) LIKE CONCAT('%,',TRIM(flavors.flavor),',%') AND flavors.is_approved = 1
WHERE strain_survey_answers.question_id != 4
GROUP BY medical_conditions.m_condition,
	sensations.sensation,
	negative_effects.effect,
	disease_preventions.prevention,
        flavors.flavor,
	strain_survey_answers.question_id,
        strain_survey_answers.user_id,
	strain_survey_answers.strain_id
ORDER BY question_id, strain_id, 14 desc");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('v_top_survey_answers');
    }
}
