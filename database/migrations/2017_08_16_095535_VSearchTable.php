<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VSearchTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        DB::statement("CREATE VIEW v_search_table AS
SELECT CONCAT(`sub_users`.`id`,'_', 'bm') COLLATE utf8mb4_unicode_ci AS v_pk,
`sub_users`.`id`, 'bm' COLLATE utf8mb4_unicode_ci AS  `s_type`,
`sub_users`.`title` AS `title`,
`sub_users`.`description` AS `description`,
REPLACE(`sub_users`.`description`,' ' ,'') COLLATE utf8mb4_unicode_ci AS `s_description`,
REPLACE(`sub_users`.`title`,' ' ,'') COLLATE utf8mb4_unicode_ci AS `s_title`,
REPLACE(`sub_users`.`title`,'''' ,'') COLLATE utf8mb4_unicode_ci AS `a_title`,
`sub_users`.`zip_code` AS `zip_code`,
`sub_users`.`stripe_id` AS `is_premium`,
`sub_users`.`is_blocked` AS `is_blocked`,
`sub_users`.`created_at` AS `created_at`
FROM `sub_users`

UNION ALL 
SELECT 
CONCAT(`answers`.`id`,'_', 'a') COLLATE utf8mb4_unicode_ci AS v_pk,
`answers`.`question_id` AS `id`, 'a' AS  `s_type`,`answers`.`answer` COLLATE utf8mb4_unicode_ci AS `title`,
'' AS `description`,
'' `s_description`,
REPLACE(`answers`.`answer`,' ' ,'') COLLATE utf8mb4_unicode_ci AS `s_title`,
REPLACE(`answers`.`answer`,'''' ,'') COLLATE utf8mb4_unicode_ci AS `a_title`,
'' AS `zip_code`,null AS `is_premium`,0 AS `is_blocked`,`answers`.`created_at` AS `created_at` 
FROM `answers` 
UNION ALL 
SELECT 
CONCAT(`questions`.`id`,'_', 'q') COLLATE utf8mb4_unicode_ci AS v_pk,
`questions`.`id`, 'q' AS `q`,`questions`.`question` COLLATE utf8mb4_unicode_ci AS `title`,
`questions`.`description` AS `description`,
REPLACE(`questions`.`description`,' ' ,'') COLLATE utf8mb4_unicode_ci AS `s_description`,
REPLACE(`questions`.`question`,' ' ,'') COLLATE utf8mb4_unicode_ci AS `s_title`,
REPLACE(`questions`.`question`,'''' ,'') COLLATE utf8mb4_unicode_ci AS `a_title`,
'' AS `zip_code`,null AS `is_premium`,0 AS `is_blocked`,`questions`.`created_at` AS `created_at` FROM `questions` 
UNION ALL 
SELECT 
CONCAT(`journals`.`id`,'_', 'j') COLLATE utf8mb4_unicode_ci AS v_pk,
`journals`.`id`, 'j' AS `j`,`journals`.`title` COLLATE utf8mb4_unicode_ci AS `title`,'' AS `description`,
'' `s_description`,
REPLACE(`journals`.`title`,' ' ,'') COLLATE utf8mb4_unicode_ci AS `s_title`,
REPLACE(`journals`.`title`,'''' ,'') COLLATE utf8mb4_unicode_ci AS `a_title`,
'' AS `zip_code`,null AS `is_premium`,0 AS `is_blocked`,`journals`.`created_at` AS `created_at` FROM `journals` 
UNION ALL 
SELECT 
CONCAT(`groups`.`id`,'_', 'g') COLLATE utf8mb4_unicode_ci AS v_pk,
`groups`.`id`,  'g' AS `g`,`groups`.`title` COLLATE utf8mb4_unicode_ci AS `title`,`groups`.`description` AS `description`,
REPLACE(`groups`.`description`,' ' ,'') COLLATE utf8mb4_unicode_ci AS `s_description`,
REPLACE(`groups`.`title`,' ' ,'') COLLATE utf8mb4_unicode_ci AS `s_title`,
REPLACE(`groups`.`title`,'''' ,'') COLLATE utf8mb4_unicode_ci AS `a_title`,
'' AS `zip_code`,null AS `is_premium`,0 AS `is_blocked`,`groups`.`created_at` AS `created_at` FROM `groups` 
UNION ALL 
SELECT 
CONCAT(`users`.`id`,'_', 'u') COLLATE utf8mb4_unicode_ci AS v_pk,
`users`.`id`,  'u' AS `u`,`users`.`first_name` COLLATE utf8mb4_unicode_ci AS `title`,'' AS `description`,
`bio` AS `s_description`,
REPLACE(`users`.`first_name`,' ' ,'') COLLATE utf8mb4_unicode_ci AS `s_title`,
REPLACE(`users`.`first_name`,'''' ,'') COLLATE utf8mb4_unicode_ci AS `a_title`,
'' AS `zip_code`,null AS `is_premium`,0 AS `is_blocked`,`users`.`created_at` AS `created_at` FROM `users` 
UNION ALL 
SELECT
CONCAT(`strains`.`id`,'_', 's') COLLATE utf8mb4_unicode_ci AS v_pk,
 `strains`.`id`,'s' AS `s`,`strains`.`title` COLLATE utf8mb4_unicode_ci AS `title`,`strains`.`overview` AS `description`,
REPLACE(`strains`.`overview`,' ' ,'') COLLATE utf8mb4_unicode_ci AS `s_description`,
REPLACE(`strains`.`title`,' ' ,'') COLLATE utf8mb4_unicode_ci AS `s_title`, 
REPLACE(`strains`.`title`,'''' ,'') COLLATE utf8mb4_unicode_ci AS `a_title`,
'' AS `zip_code`,null AS `is_premium`,0 AS `is_blocked`,`strains`.`created_at` AS `created_at` FROM `strains`
");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }

}
