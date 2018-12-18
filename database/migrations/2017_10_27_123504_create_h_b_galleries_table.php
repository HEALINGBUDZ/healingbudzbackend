<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHBGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          DB::statement("CREATE VIEW v_h_b_galleries AS
              
SELECT CONCAT(`business_review_attachments`.`id`,'_', 'br') COLLATE utf8mb4_unicode_ci AS v_pk,
`business_review_attachments`.`id`, 'br' COLLATE utf8mb4_unicode_ci AS  `a_type`,
`business_review_attachments`.`attachment` AS `path`,
`business_review_attachments`.`type` AS `type`,
`business_review_attachments`.`user_id` AS `user_id`,
`business_review_attachments`.`poster` AS `poster`,
'BusinessReviewAttachment' COLLATE utf8mb4_unicode_ci AS  `model`,
`business_review_attachments`.`created_at` AS `created_at` FROM `business_review_attachments` 
UNION ALL

SELECT CONCAT(`event_review_attachments`.`id`,'_', 'er') COLLATE utf8mb4_unicode_ci AS v_pk,
`event_review_attachments`.`id`, 'er' COLLATE utf8mb4_unicode_ci AS  `a_type`,
`event_review_attachments`.`attachment` AS `path`,
`event_review_attachments`.`upload_type` AS `type`,
`event_review_attachments`.`user_id` AS `user_id`,
`event_review_attachments`.`poster` AS `poster`,
'EventReviewAttachment' COLLATE utf8mb4_unicode_ci AS  `model`,
`event_review_attachments`.`created_at` AS `created_at` FROM `event_review_attachments` 
UNION ALL

SELECT CONCAT(`journal_event_attachments`.`id`,'_', 'je') COLLATE utf8mb4_unicode_ci AS v_pk,
`journal_event_attachments`.`id`, 'je' COLLATE utf8mb4_unicode_ci AS  `a_type`,
`journal_event_attachments`.`attachment_path` AS `path`,
`journal_event_attachments`.`attachment_type` AS `type`,
`journal_event_attachments`.`user_id` AS `user_id`,
`journal_event_attachments`.`poster` AS `poster`,
'JournalEventAttachment' COLLATE utf8mb4_unicode_ci AS  `model`,
`journal_event_attachments`.`created_at` AS `created_at` FROM `journal_event_attachments` 
UNION ALL

SELECT CONCAT(`product_images`.`id`,'_', 'pi') COLLATE utf8mb4_unicode_ci AS v_pk,
`product_images`.`id`, 'pi' COLLATE utf8mb4_unicode_ci AS  `a_type`,
`product_images`.`image` AS `path`,
'image' COLLATE utf8mb4_unicode_ci AS `type`,
`product_images`.`user_id` AS `user_id`,
'NULL' COLLATE utf8mb4_unicode_ci AS `poster`,
'ProductImage' COLLATE utf8mb4_unicode_ci AS  `model`,
`product_images`.`created_at` AS `created_at` FROM `product_images` 
UNION ALL

SELECT CONCAT(`strain_images`.`id`,'_', 'si') COLLATE utf8mb4_unicode_ci AS v_pk,
`strain_images`.`id`, 'si' COLLATE utf8mb4_unicode_ci AS  `a_type`,
`strain_images`.`image_path` AS `path`,
'image' COLLATE utf8mb4_unicode_ci AS `type`,
`strain_images`.`user_id` AS `user_id`,
'NULL' COLLATE utf8mb4_unicode_ci AS `poster`,
'StrainImage' COLLATE utf8mb4_unicode_ci AS  `model`,
`strain_images`.`created_at` AS `created_at` FROM `strain_images` 
UNION ALL

SELECT CONCAT(`strain_review_images`.`id`,'_', 'sr') COLLATE utf8mb4_unicode_ci AS v_pk,
`strain_review_images`.`id`, 'sr' COLLATE utf8mb4_unicode_ci AS  `a_type`,
`strain_review_images`.`attachment` AS `path`,
`strain_review_images`.`type` AS `type`,
`strain_review_images`.`user_id` AS `user_id`,
`strain_review_images`.`poster` AS `poster`,
'StrainReviewImage' COLLATE utf8mb4_unicode_ci AS  `model`,
`strain_review_images`.`created_at` AS `created_at` FROM `strain_review_images` 
UNION ALL

SELECT CONCAT(`sub_user_images`.`id`,'_', 'su') COLLATE utf8mb4_unicode_ci AS v_pk,
`sub_user_images`.`id`, 'su' COLLATE utf8mb4_unicode_ci AS  `a_type`,
`sub_user_images`.`image` AS `path`,
'image' COLLATE utf8mb4_unicode_ci AS `type`,
`sub_user_images`.`user_id` AS `user_id`,
'NULL' COLLATE utf8mb4_unicode_ci AS `poster`,
'SubUserImage' COLLATE utf8mb4_unicode_ci AS  `model`,
`sub_user_images`.`created_at` AS `created_at` FROM `sub_user_images`

UNION ALL

SELECT CONCAT(`answer_attachments`.`id`,'_', 'ans') COLLATE utf8mb4_unicode_ci AS v_pk,
`answer_attachments`.`id`, 'ans' COLLATE utf8mb4_unicode_ci AS  `a_type`,
`answer_attachments`.`upload_path` AS `path`,
`answer_attachments`.`media_type` AS `type`,
`answer_attachments`.`user_id` AS `user_id`,
`answer_attachments`.`poster` AS `poster`,
'AnswerAttachment' COLLATE utf8mb4_unicode_ci AS  `model`,
`answer_attachments`.`created_at` AS `created_at` FROM `answer_attachments`

UNION ALL

SELECT CONCAT(`user_post_attachments`.`id`,'_', 'post') COLLATE utf8mb4_unicode_ci AS v_pk,
`user_post_attachments`.`id`, 'post' COLLATE utf8mb4_unicode_ci AS  `a_type`,
`user_post_attachments`.`file` AS `path`,
`user_post_attachments`.`type` AS `type`,
`user_post_attachments`.`user_id` AS `user_id`,
`user_post_attachments`.`poster` AS `poster`,
'UserPostAttachment' COLLATE utf8mb4_unicode_ci AS  `model`,
`user_post_attachments`.`created_at` AS `created_at` FROM `user_post_attachments`

UNION ALL

SELECT CONCAT(`user_post_comment_attachments`.`id`,'_', 'comment') COLLATE utf8mb4_unicode_ci AS v_pk,
`user_post_comment_attachments`.`id`, 'comment' COLLATE utf8mb4_unicode_ci AS  `a_type`,
`user_post_comment_attachments`.`file` AS `path`,
`user_post_comment_attachments`.`type` AS `type`,
`user_post_comment_attachments`.`user_id` AS `user_id`,
`user_post_comment_attachments`.`poster` AS `poster`,
'UserPostCommentAttachment' COLLATE utf8mb4_unicode_ci AS  `model`,
`user_post_comment_attachments`.`created_at` AS `created_at` FROM `user_post_comment_attachments`

UNION ALL

SELECT CONCAT(`users`.`id`,'_', 'user') COLLATE utf8mb4_unicode_ci AS v_pk,
`users`.`id`, 'userimage' COLLATE utf8mb4_unicode_ci AS  `a_type`,
`users`.`image_path` AS `path`,
'image' COLLATE utf8mb4_unicode_ci AS `type`,
`users`.`id` AS `user_id`,
'NULL' COLLATE utf8mb4_unicode_ci AS `poster`,
'User' COLLATE utf8mb4_unicode_ci AS  `model`,
`users`.`created_at` AS `created_at` FROM `users`
UNION ALL

SELECT CONCAT(`users`.`id`,'_', 'cover') COLLATE utf8mb4_unicode_ci AS v_pk,
`users`.`id`, 'usercover' COLLATE utf8mb4_unicode_ci AS  `a_type`,
`users`.`cover` AS `path`,
'image' COLLATE utf8mb4_unicode_ci AS `type`,
`users`.`id` AS `user_id`,
'NULL' COLLATE utf8mb4_unicode_ci AS `poster`,
'User' COLLATE utf8mb4_unicode_ci AS  `model`,
`users`.`created_at` AS `created_at` FROM `users`

UNION ALL

SELECT CONCAT(`sub_users`.`id`,'_', 'sublogo') COLLATE utf8mb4_unicode_ci AS v_pk,
`sub_users`.`id`, 'sublogo' COLLATE utf8mb4_unicode_ci AS  `a_type`,
`sub_users`.`logo` AS `path`,
'image' COLLATE utf8mb4_unicode_ci AS `type`,
`sub_users`.`user_id` AS `user_id`,
'NULL' COLLATE utf8mb4_unicode_ci AS `poster`,
'SubUser' COLLATE utf8mb4_unicode_ci AS  `model`,
`sub_users`.`created_at` AS `created_at` FROM `sub_users`

UNION ALL

SELECT CONCAT(`sub_users`.`id`,'_', 'subbanner') COLLATE utf8mb4_unicode_ci AS v_pk,
`sub_users`.`id`, 'subbanner' COLLATE utf8mb4_unicode_ci AS  `a_type`,
`sub_users`.`banner` AS `path`,
'image' COLLATE utf8mb4_unicode_ci AS `type`,
`sub_users`.`user_id` AS `user_id`,
'NULL' COLLATE utf8mb4_unicode_ci AS `poster`,
'SubUser' COLLATE utf8mb4_unicode_ci AS  `model`,
`sub_users`.`created_at` AS `created_at` FROM `sub_users`

UNION ALL

SELECT CONCAT(`hb_gallery_media`.`id`,'_', 'hbgallery') COLLATE utf8mb4_unicode_ci AS v_pk,
`hb_gallery_media`.`id`, 'hbgallery' COLLATE utf8mb4_unicode_ci AS  `a_type`,
`hb_gallery_media`.`path` AS `path`,
`hb_gallery_media`.`type` AS `type`,
`hb_gallery_media`.`user_id` AS `user_id`,
`hb_gallery_media`.`poster` AS `poster`,
'HbGalleryMedia' COLLATE utf8mb4_unicode_ci AS  `model`,
`hb_gallery_media`.`created_at` AS `created_at` FROM `hb_gallery_media`
");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('h_b_galleries');
    }
}
