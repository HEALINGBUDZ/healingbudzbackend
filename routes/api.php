<?php

use Illuminate\Http\Request;

/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
 */

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::group(['prefix' => 'v1', 'middleware' => ['headersmid', 'checkAppKey']], function () {
    Route::post('/login', 'AuthController@login');
    Route::post('/check_email', 'AuthController@checkEmail');
    Route::post('/check_special_email', 'AuthController@checkSpecialEmail');
    Route::post('/register', 'AuthController@register');
    Route::post('/social_login', 'AuthController@CheckSocialLogin');
    Route::post('/add_image_profile', 'AuthController@addImage');
    Route::get('/get_defaults/{email}', 'AuthController@getDefaults');
    Route::post('/forget_password', 'AuthController@forgetEmail');
    Route::post('/update_password', 'AuthController@updatePassword');
    Route::group(['middleware' => ['checkSession']], function () {
//        Question section
        Route::get('/get_questions', 'QuestionController@getQuestions');
        Route::get('/test_job', 'HomeController@testJob');
        Route::get('/get_all_questions', 'QuestionController@allQuestions');
        Route::post('/add_question', 'QuestionController@addQuestion');
        Route::get('delete_question/{question_id}', 'QuestionController@deleteQuestion');
        Route::post('/add_question_like', 'QuestionController@addToFavorit');
        Route::post('/add_question_flag', 'QuestionController@addFlag');
        Route::post('save_favorit_discussion', 'QuestionController@addToFavorit');
        Route::get('/search_question', 'QuestionController@searchQuestion');
        Route::get('/get_question/{question_id}', 'QuestionController@getQuestion');
        Route::post('/change_show_ads_status', 'QuestionController@changeShowAdsStatus');
        //        Answers  section
        Route::get('/get_answers/{question_id}', 'AnswerController@getAnswers');
        Route::post('/add_video', 'AnswerController@addVideo');
        Route::post('/add_image', 'AnswerController@addImage');
        Route::post('/add_answer', 'AnswerController@addAnswer');
        Route::post('/add_answer_like', 'AnswerController@addLike');
        Route::post('/add_answer_flag', 'AnswerController@addFlag');
        Route::get('/delete_answer/{answer_id}', 'AnswerController@deleteUserAnswer');
        Route::get('/get_answer/{answer_id}', 'AnswerController@getAnswer');
        Route::get('/get_answer_question/{answer_id}', 'AnswerController@getAnswerQuestion');
        Route::get('/get_edits/{answer_id}', 'AnswerController@getAnswerEdits');
//        Activities Section
        Route::get('/get_activities/{user_id}', 'ActivityController@getActivities');
        Route::get('/get_activity/{activity_id}', 'ActivityController@getActivity');
        Route::get('/filter_activity/{user_id}', 'ActivityController@filterActivity');
        Route::get('/search_keyword_activity', 'ActivityController@searchKeywordActivity');

        Route::get('/get_keywords', 'ActivityController@getKeywords');
//        Groups Section
        Route::get('/get_groups', 'GroupController@getGroups');
        Route::get('get_group_members/{group_id}', 'GroupController@getMembers');
        Route::post('/add_group', 'GroupController@createGroup');
        Route::post('/edit_group', 'GroupController@editGroup');
        Route::post('/invite_members', 'GroupController@inviteMembers');
        Route::post('/accept_reject_invitaion', 'GroupController@acceptRejectInvitaion');
        Route::post('/approve_decline_request', 'GroupController@approveDeclineRequest');
        Route::post('/remove_member', 'GroupController@removeMember');
        Route::get('remove_group/{group_id}', 'GroupController@removeGroup');
        Route::get('get_group/{group_id}', 'GroupController@getGroup');
        Route::get('get_all_public_groups', 'GroupController@getAllPublicGroups');
        Route::get('get_all_public_groups_alpha', 'GroupController@getAllPublicGroupsAlpha');
        Route::get('get_all_public_groups_created', 'GroupController@getAllPublicGroupsCreated');
        Route::get('get_all_gublic_groups_joined', 'GroupController@getAllPublicGroupsJoined');
        Route::post('/add_group_message', 'GroupController@addGroupMessage');
        Route::post('/add_message_like', 'GroupController@addMessageLike');
        Route::post('/remove_message_like', 'GroupController@removeMessageLike');
        Route::get('get_messgaes/{group_id}', 'GroupController@getMessgaes');
        Route::post('/add_group_settings', 'GroupController@addGroupSettings');
        Route::get('/group_settings/{group_id}', 'GroupController@getGroupSetting');
        Route::get('/search_group', 'GroupController@searchGroup');
        Route::post('/join_group', 'GroupController@joinGroup');
        Route::post('/leave_group', 'GroupController@leaveGroup');
//        Route::get('/get_my_groups', 'GroupController@getMyGroups');
//        User Section
        Route::post('get_user_session', 'UserController@getUserSession');
        Route::get('get_users', 'UserController@getUsers');
        Route::get('get_all_users', 'UserController@userToFollow');
        Route::get('search_users', 'UserController@searchUser');
        Route::get('get_my_save', 'UserController@getMySave');
        Route::post('delete_my_save', 'UserController@deleteMySave');
        Route::get('get_user_profile/{id}', 'UserController@getUserProfile');
        Route::get('get_user_groups/{id}', 'UserController@userGroups');
        Route::get('get_user_profile_strains/{id}', 'UserController@userPrfileStrains');
        Route::get('get_user_profile_journals/{id}', 'UserController@userPrfileJournals');
        Route::get('get_user_profile_budz_map/{id}', 'UserController@userPrfileBudz');
        Route::get('get_user_profile_reviews/{id}', 'UserController@userPrfileReviews');
        Route::get('get_followings/{id}', 'UserController@getFollowings');
        Route::get('get_followers/{id}', 'UserController@getFollowers');

        Route::post('/follow_user', 'UserController@followUser');
        Route::post('/un_follow', 'UserController@unFollow');
        Route::post('/update_email', 'UserController@updateEmail');
        Route::post('/change_password', 'UserController@changePassword');
        Route::post('/update_zip', 'UserController@updateZip');
        Route::post('/update_avatar', 'UserController@updateAvatar');
        Route::post('/update_special_icon', 'UserController@updateSicon');
        Route::post('/update_image', 'UserController@updateImage');
        Route::post('/update_cover', 'UserController@updateCover');
        Route::post('/update_cover_orignal_image', 'UserController@addCoverFull');
        Route::post('/update_bio', 'UserController@updateBio');
        Route::post('/update_name', 'UserController@updateName');
        Route::post('/add_expertise', 'UserController@addExpertise');
        Route::post('/add_expertise_suggestion', 'UserController@addExpertiseSuggestion');
        Route::get('get_budz_map_reviews/{id}', 'UserController@getMyBudzMapReviews');
        Route::get('get_tags', 'UserController@getTags');
        Route::get('hb_gallery/{user_id}', 'UserController@getHbGallery');
        Route::get('delete_hb_gallery/{pk}', 'UserController@deleteImage');
        Route::post('add_hb_media', 'UserController@addHbMedia');
        Route::get('/get_login_user', 'UserController@getLoginUser');
        Route::post('offline_user', 'UserController@offlineUser');

//      Journal Section
        Route::post('/create_journal', 'JournalController@createJournal');
        Route::post('/create_journal_event', 'JournalController@createJournalEvent');
        Route::post('/add_journal_tags', 'JournalController@addJournalTags');
        Route::get('get_journal_tags', 'JournalController@getJournalTags');
        Route::post('/follow_journal', 'JournalController@followJournal');
        Route::post('/favourtire_journal', 'JournalController@favourtireJournal');
        Route::post('/journal_like_or_dislike', 'JournalController@journalLikeOrDislike');
        Route::post('delete_journal', 'JournalController@deleteJournal');
        Route::post('delete_journal_event', 'JournalController@deleteJournalEvent');

//        Route::post('/update_journal_privacy', 'JournalController@updateJournalPrivacy');
        Route::post('/update_journal', 'JournalController@updateJournal');

        Route::get('/get_user_all_journals/{user_id}', 'JournalController@getUserAllJournals');
        Route::get('/get_all_journals/', 'JournalController@getAllJournals');
        Route::get('/get_journal_events/{journal_id}', 'JournalController@getJournalEvents');
        Route::get('/get_journal_followers/{journal_id}', 'JournalController@getJournalFollowers');
        Route::get('/get_journal/{journal_id}', 'JournalController@getJournal');
        Route::get('/search_journal', 'JournalController@searchJournal');
        Route::get('/get_favorit_journals', 'JournalController@getFavoritJournals');

        Route::post('/add_event_image', 'JournalController@addImage');
        Route::post('/add_event_video', 'JournalController@addVideo');

//        Mail Support
        Route::get('/get_support_listing', 'StaticPagesController@getSupportUsers');
        Route::post('/mail_support', 'AuthController@supportMail');
        Route::post('/invite', 'AuthController@sendInvitationMail');
        //    Search Section
        Route::get('globle_search', 'SearchController@search');
        Route::get('get_global_search_loader', 'SearchController@getSearchLoader');

//        Dashboard
        Route::get('get_expertise', 'HomeController@getExpertise');
        Route::get('get_notifications', 'HomeController@getNotification');
        Route::get('clear_all_notifications', 'HomeController@clearAllNotifications');
        Route::get('get_shout_outs', 'HomeController@getShoutOuts');
        Route::post('add_shout_out', 'HomeController@addShoutOut');
        Route::post('like_shout_out', 'HomeController@likeShoutOut');
        Route::post('save_shoutout_share', 'HomeController@saveShoutOutShare');
        Route::post('save_shoutout_view', 'HomeController@saveShoutOutView');
        Route::post('save_favorit_shout_out', 'HomeController@saveFavoritShoutOut');
        Route::get('search', 'HomeController@search');
        Route::get('get_default_question', 'HomeController@getDefaultQuestion');
        Route::post('invite_friend', 'HomeController@inviteFriend');
        Route::post('save_share', 'HomeController@saveShare');
        Route::post('logout', 'HomeController@logout');
        Route::post('job_remaind_later', 'HomeController@jobRemaindLater');

//       Sub user section
        Route::post('add_listing', 'ListingController@addListing');
        Route::post('add_logo', 'ListingController@addLogo');
        Route::post('add_banner', 'ListingController@addBanner');
        Route::get('get_budz_map', 'ListingController@getMapBudz');
        Route::get('get_budz_profile/{id}', 'ListingController@getProfile');
        Route::post('add_budz_review_like', 'ListingController@addBudzReviewLike');
        Route::get('get_budz/{bud_id}', 'ListingController@getBudz');
        Route::post('add_budz_review', 'ListingController@addReview');
        Route::post('delete_budz_review', 'ListingController@DeleteReview');
        Route::post('add_budz_review_reply', 'ListingController@addReviewReply');
        Route::post('delete_budz_review_reply', 'ListingController@deleteReviewReply');
        Route::post('add_budz_review_flag', 'ListingController@addFlag');
        Route::post('add_subuser_images', 'ListingController@addSubUserPics');
        Route::post('delete_sub_user', 'ListingController@deleteSubUser');
        Route::post('save_favorit_bud', 'ListingController@addToFavorit');
        Route::post('add_subscription', 'ListingController@addSubscription');
        Route::post('update_subscription', 'ListingController@updateSubscription');
        Route::get('get_languages', 'ListingController@getLanguages');
        Route::post('add_budz_image', 'ListingController@addImage');
        Route::post('update_pop_up', 'ListingController@updatePopUp');
        Route::post('add_budz_flag', 'ListingController@addBudzFlag');
        Route::post('save_budzmap_share', 'ListingController@saveBudzMapShare');
        Route::post('save_budz_menu_click', 'ListingController@saveBudzMenuClick');
        Route::post('save_budz_ticket_click', 'ListingController@saveBudzTicketClick');
        Route::post('save_budz_call_click', 'ListingController@saveBudzCallClick');
        Route::get('payment_methods', 'ListingController@getPaymentMethods');
        Route::get('delete_subscription/{budz_id}', 'ListingController@deleteSubscription');
        Route::post('add_budz_product', 'ListingController@addProduct');
        Route::post('add_budz_product_image', 'ListingController@addProductImage');
        Route::get('delete_product/{product_id}', 'ListingController@deleteProduct');

        Route::post('add_budz_ticket', 'ListingController@addTicket');
        Route::get('delete_budz_ticket/{product_id}', 'ListingController@deleteTicket');

        Route::post('add_budz_service', 'ListingController@addService');
        Route::get('delete_budz_service/{service_id}', 'ListingController@deleteService');

//        sub user Stats
        Route::get('all_budz_stats', 'ListingController@budzMapStats');
        Route::get('single_budz_stat/{budz_id}', 'ListingController@singleBudzStat');
        Route::get('filter-budz-map-stats/{filter}', 'ListingController@filterSubUser');
        Route::get('shout_out_stats', 'HomeController@shoutOutStats');
        Route::get('user_shout_outs', 'HomeController@getUserShoutOut');
        Route::get('shout_detail/{shout_id}', 'HomeController@getShoutOut');
        Route::get('shoutout-stats', 'Web\ShoutOutController@shoutOutStats');
//       get static pages
        Route::get('legal_page', 'StaticPagesController@getLegal');
        Route::get('privacy_page', 'StaticPagesController@getPrivacyPolicy');
        Route::get('follow_page', 'StaticPagesController@getFollowPage');
        Route::get('terms_condations', 'StaticPagesController@TermCondation');

//       Setting Section
        Route::get('get_biz_settings', 'SettingController@getBussinessSettings');
        Route::get('get_journal_settings', 'SettingController@getJournalSettings');
        Route::get('get_notification_settings', 'SettingController@getNotificationSettings');
        Route::post('add_journal_setting', 'SettingController@addJournalsetting');
        Route::post('add_journal_data_setting', 'SettingController@addJournalDataSetting');
        Route::post('add_journal_reminder_setting', 'SettingController@addJournalReminderSetting');
        Route::post('add_notificarion_setting', 'SettingController@addNotificarionSetting');
        Route::get('remove_tag/{tag_id}', 'SettingController@removeTag');
        Route::post('follow_keyword', 'SettingController@followKeyWord');
//      Strains Section
        Route::get('get_strains', 'StrainController@getStrains');
        Route::get('get_strain/{strain_id}', 'StrainController@getStrain');
        Route::get('get_strains_alphabitically', 'StrainController@getStrainsAlphabitically');
        Route::get('get_strains_by_type/{type_id}', 'StrainController@getStrainsByType');
        Route::get('get_strain_detail/{strain_id}', 'StrainController@getStrainDetail');
        Route::get('strain_details_by_name/{name}', 'StrainController@getStrainDetailByName');
        Route::post('add_strain_review', 'StrainController@addReview');
        Route::post('delete_strain_review', 'StrainController@deleteReview');
        Route::post('flag_strain_review', 'StrainController@flagStrainReview');
        Route::post('strain_like_dislike', 'StrainController@saveStrainLikeDislike');
        Route::post('strain_dislike', 'StrainController@saveStrainDislike');
        Route::post('strain_flaged', 'StrainController@saveStrainFlag');
        Route::post('save_user_strain', 'StrainController@saveUserStrain');
        Route::post('save_user_strain_like', 'StrainController@saveUserStrainLike');
        Route::get('get_user_strains/{strain_id}', 'StrainController@getUserStrains');
        Route::get('get_user_strain_detail/{user_strain_id}', 'StrainController@getUserStrainDetail');
        Route::post('upload_strain_image', 'StrainController@saveStrainImage');
        Route::post('save_favorit_strain', 'StrainController@addToFavorit');
        Route::get('search_strain_name', 'StrainController@searchStrainByName');
        Route::get('search_strain_survey', 'StrainController@searchStrainBySurvey');
        Route::post('delete_user_strain', 'StrainController@deleteUserStrain');
        Route::get('save_strain_search', 'StrainController@saveStrainSurveySearch');
        Route::get('locate_strain_budz', 'StrainController@locateStrainBudz');
        Route::post('save_user_image_strain_like', 'StrainController@saveStrainImageLike');
        Route::post('save_user_image_strain_dislike', 'StrainController@saveStrainImageDislike');
        Route::post('save_user_image_strain_flag', 'StrainController@saveStrainImageFlag');
        Route::post('add_strain_review_like', 'StrainController@addStrainReviewLike');
        Route::get('delete_strain_image/{image_id}', 'StrainController@deleteStrainImage');
//      Strains Survey Section       
        Route::get('get_survey_questions/', 'StrainController@getSurveyQuestions');
        Route::post('save_survey_answer/', 'StrainController@saveSurveyAnswer');
        Route::get('search_medical_condition/', 'StrainController@searchMedicalCondition');
        Route::get('search_negative_effect/', 'StrainController@searchNegativeEffect');
        Route::get('search_sensation/', 'StrainController@searchSensation');
        Route::get('search_disease_prevention/', 'StrainController@searchDiseasePrevention');

        Route::post('suggest_medical_condition/', 'StrainController@saveSuggestedMedicalCondition');
        Route::post('suggest_sensation/', 'StrainController@saveSuggestedSensation');
        Route::post('suggest_negative_effect/', 'StrainController@saveSuggestedNegativeEffect');
        Route::post('suggest_disease_prevention/', 'StrainController@saveSuggestedDiseasePrevention');


//      Chat Section
        Route::post('send_message/', 'ChatController@sendMessage');
        Route::post('read_messages/', 'ChatController@readMessages');
        Route::post('delete_message/', 'ChatController@deleteMessage');
        Route::post('delete_chat/', 'ChatController@deleteChat');
        Route::post('get_detail_chat/', 'ChatController@getDetailChat');
        Route::get('get_chats/', 'ChatController@getChats');
        Route::post('/add_video_chat', 'ChatController@addVideo');
        Route::post('/add_image_chat', 'ChatController@addImage');
        Route::post('/save_chat', 'ChatController@addChatMySave');

        Route::get('get_chat_detail_by_id/{chat_id}', 'ChatController@getDetailChatById');
//Budz Chat section
        Route::post('send_budz_message/', 'BudzChatController@sendMessage');
        Route::get('get_budz_chats/', 'BudzChatController@getBudzChats');
        Route::post('read_budz_messages/', 'BudzChatController@readMessages');
        Route::post('delete_message_budz/', 'BudzChatController@deleteMessage');
        Route::post('delete_chat_budz/', 'BudzChatController@deleteChat');
        Route::post('delete_chat_budzs/', 'BudzChatController@deleteChatBudz');
        Route::post('get_budz_detail_chat/', 'BudzChatController@getDetailChat');
        Route::post('get_budz_chat_detail/', 'BudzChatController@getChatDetail');
        Route::get('get_budz_chats_user/{budz_id}', 'BudzChatController@getChatUsers');
        Route::post('/save_chat_budz', 'BudzChatController@addBuzChatMySave');
//        Route::post('/add_video_chat', 'ChatController@addVideo');
//        Route::post('/add_image_chat', 'ChatController@addImage');
        //My Section 
        Route::get('/get_my_question', 'MyController@getMyQuestions');
        Route::get('/get_my_answers', 'MyController@getMyAnswers');
        Route::get('/get_my_strains', 'MyController@getMyStrains');
        Route::get('/my_budz_map', 'MyController@getMyBudzMap');
        Route::get('/my_feature_budz_map', 'MyController@getFeatureMyBudzMap');
        Route::get('/get_my_journals', 'MyController@getMyJournals');
        Route::get('/get_my_journals_calander', 'MyController@getMyJournalsCalander');
        Route::get('/get_my_journals_sorting', 'MyController@myJournalSorting');
        Route::get('/get_my_groups', 'MyController@getMyGoups');
        Route::get('/get_my_rewards', 'MyController@myRewards');
        Route::get('/get_my_saves', 'MyController@getMySaves');
        Route::get('/delete_my_save/{id}', 'MyController@deleteMySave');
        Route::get('/filter_my_save', 'MyController@filterMySave');
//  Special Section
        Route::post('/add_budz_special', 'ListingController@addSpecial');
        Route::get('/delete_special/{special_id}', 'ListingController@deleteSpecial');
        //post section
        Route::post('/add_post_image', 'PostController@addImage');
        Route::post('/add_post_video', 'PostController@addVideo');
        Route::get('/get_sub_users', 'PostController@getSubUsers');
        Route::get('/get_all_sub_users', 'PostController@getAllSubUsers');
        Route::post('/save_post', 'PostController@addPost');
        Route::get('/get_post/{post_id}', 'PostController@getPost');
        Route::get('/get_user_posts', 'PostController@fetchPosts');
        Route::post('/add_comment', 'PostController@addComment');
        Route::post('/delete_comment', 'PostController@deleteComment');
        Route::post('/add_post_like_dislike', 'PostController@postLikeDislike');
        Route::post('/add_comment_like_dislike', 'PostController@commentLikeDislike');
        Route::post('/add_post_flag', 'PostController@flagPost');
        Route::post('/mute_post', 'PostController@mutePost');
        Route::post('/delete_post', 'PostController@deletePost');
        Route::post('/repost', 'PostController@repost');
        Route::get('/user_posts/{user_id}', 'PostController@userPosts');
        Route::get('/user_post_comment/{post_id}', 'PostController@getComments');
        Route::post('/share_post_in_app', 'PostController@addSharedUrlPost');
        //Products section
        Route::get('/get_products', 'ProductController@getProducts');
        Route::post('/purchase_product', 'ProductController@purchaseProduct');
        Route::get('/get_user_purchased_products', 'ProductController@getPurchasedProducts');
        Route::get('/get_user_point_log', 'ProductController@getPointsLog');

        //      Key words Section  
        Route::post('list_key_words', 'KeyWordController@listKeyWords');
        Route::post('buy_keyword', 'KeyWordController@buyKeyword');


        //   Stats
        Route::get('list_user_keywords', 'KeyWordController@listUserKeywords');
        Route::post('keyword_analytics', 'KeyWordController@getKeywordAnalytics');
//        Route::post('filter_keyword_analytics', 'KeyWordController@filterKeywordAnalytics');
//        Route::post('date_keyword_analytics', 'KeyWordController@dateKeywordAnalytics');
//        Route::post('keywords-stats-mail', 'Web\KeyWordController@sendKeywordStatsMail');
        Route::get('shoutout-stats', 'Web\ShoutOutController@shoutOutStats');
        Route::get('budz-map-stats', 'Web\BudzMapController@budzMapStats');
        Route::get('filter-budz-map-stats/{filter}', 'Web\BudzMapController@filterSubUser');
        Route::get('date-budz-map-stats', 'Web\BudzMapController@filterSubUserDate');
        Route::get('single-budz-stats/{budz_id}', 'Web\BudzMapController@singleBudzStat');
    });
});
Route::get('/scrape', function () {
    $url = $_GET['url'];
    $url = "https://via.hypothes.is/" . $url;

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("REMOTE_ADDR: 192.168.3.160", "HTTP_X_FORWARDED_FOR: 192.168.3.160"));
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_TIMEOUT => 30000,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
        ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if (!$response) {
        $response = file_get_contents("$url");
    }
//        print_r($response);exit;
//    $newhtml = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $response);
//    $replaceded_itmes = array('https://via.hypothes.is/oe_/', 'https://via.hypothes.is/im_/', 'https://via.hypothes.is/', '/oe_/', 'im_', '/js_/', 'js_/', '');
    $replaceded_itmes = array('im_', 'wbinfo.prefix = "https://via.hypothes.is/"', 'js_/', 'embed_script.src = "https://hypothes.is/embed.js";', 'showHighlights: true,', '<script> if (_wb_js) { _wb_js.load(); }</script>', '', 'wbinfo.url =', 'wbinfo.url =', 'wbinfo.wombat_host =', 'wbinfo =', 'animation:');
    $finalhtml = str_replace($replaceded_itmes, "", $response);
    $other_arry = (array('"/oe_/', '"/js_/'));
    $finalhtml = str_replace($other_arry, '"', $finalhtml);
    $finalhtml = str_replace('"//', '"http://', $finalhtml);
//    $finalhtml = str_replace("//via.hypothes.is//", "http://", $finalhtml);
//    $finalhtml = str_replace("//https", "https", $finalhtml);
//    print_r($finalhtml);exit;
    $file_name = time() . '.html';
    $path = public_path() . '/annotation/' . date('d_y_m');
    File::isDirectory($path) or File::makeDirectory($path, $mode = 0777, true, true);
    file_put_contents($path . '/' . $file_name, $finalhtml);
    return sendSuccess(asset('public/annotation/' . date('d_y_m') . '/' . $file_name), '');
});
