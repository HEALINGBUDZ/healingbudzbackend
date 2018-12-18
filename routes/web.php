<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
//Models
use App\Question;
use App\State;
use App\Icons;
use App\User;
use App\Tag;
use App\SubUser;
use App\Strain;
use App\VStrainRating;
use App\Article;
use App\TermCondation;
use App\PrivacyPolicy;
use App\SpecialIcon;
use Jenssegers\Agent\Agent;
//use Illuminate\Http\Request;
/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

Route::get('/frontend-test', function() {
    $temp = \App\BudzSpecial::all();
    echo '<pre>';
    print_r($temp);
    exit;
});

Route::get('test_nitification', function () {
    $heading = 'Test Notification';
    $message = 'I am Testing';
    $data['message'] = 'Test Message';
    $user_id = 48;
    sendNotification($heading, $message, $data, $user_id);
});

//Route::get('/mobileSupport/{agent}', function ($agent) {
//        return view('user.mobileSupport');
//});
Route::get('/mobileSupport', 'AuthController@mobileSupport');
Route::get('/save_popup_session', 'AuthController@savePopupSession');
Route::get('signup-terms-conditions', function () {
        $data['data'] = TermCondation::first();
        return view('user.terms-conditions_signup', $data);
    });

    Route::get('signup-privacy-policy', function () {
        $data['data'] = PrivacyPolicy::first();
        return view('user.privacy-policy_signup', $data);
    });
Route::group(['middleware' => ['checkagent','checkusername']], function () {
    Route::post('register', 'Web\AuthController@postRegister');
    Route::post('check_special_email', 'Web\AuthController@checkSpecialEmail');
    Route::get('/register', function () {
        if (Auth::guard('user')->check()) {
            return Redirect::to('wall');
//            return (new App\Http\Controllers\Web\PostController)->show();
//        $data['title'] = 'Home';
//        $data['questions'] = Question::selectRaw("REPLACE( REPLACE(REPLACE(REPLACE(REPLACE(question,'</font></b>',''),\"'\",''),'<br />',''),'\r\n',''),'<b ><font class=keyword_class color=#6d96ad>', '' ) AS question , id")->withCount('getAnswers')->orderBy('get_answers_count', 'desc')->get();
//
//        return view('user.home', $data);
        } else {
            $data['user_icons'] = Icons::all();
            $data['special_icons'] = SpecialIcon::all();
            $data['states'] = State::where('country', 'United States')->get();
            $data['term_coditions'] = TermCondation::first();
            return view('user.sign-up', $data);
        }
    });

    
    Route::get('about-us', function () {
        $data['data'] = App\AboutUs::first();
        return view('user.about-us', $data);
    });
    Route::get('who-can-join', function () {
        $data['data'] = App\WhoCanJoin::first();
        return view('user.who-can-join', $data);
    });
    Route::get('what-to-expect', function () {
        $data['data'] = App\WhatToExpect::first();
        return view('user.what-to-expect', $data);
    });
    Route::get('final-note', function () {
        $data['data'] = App\FinalNote::first();
        return view('user.final-note', $data);
    });
    Route::get('contact-us', function () {
        $data['data'] = App\ContactUs::first();
        return view('user.contact-us', $data);
    });

    Route::get('careers', function () {
        $data['data'] = App\Career::first();
        return view('user.careers', $data);
    });
    Route::get('business-services', function () {
        $data['data'] = App\BusinessServices::first();
        return view('user.business-services', $data);
    });
    Route::get('static-banner', function () {
        $data['data'] = App\Commercial::first();
        return view('user.static-banner', $data);
    });
    Route::get('advertising', function () {
        $data['data'] = App\Advertise::first();
        return view('user.advertising', $data);
    });
    Route::get('/', function () {
//    echo '<pre>';
        $agent = new Agent();
        $platform = $agent->platform();
        $data['agent'] = $platform;
//    print_r($data);exit;
//    AndroidOS
//    iOS
//    if (Auth::guard('user')->check()) {
//        return (new App\Http\Controllers\Web\PostController)->show();
//    } else {
        $data['budz_count'] = User::count();
        $data['strains_count'] = Strain::count();
        $data['questions_count'] = Question::whereHas('getAnswers')->count();

        $data['top_budz'] = User::orderBy('points', 'Desc')->take(3)->get();
        $data['top_strains'] = VStrainRating::with('getStrain.getType', 'getStrain.getMainImages')->orderBy('total', 'desc')->take(3)->get();
//        $data['top_strains'] = $top_strains->sortByDesc('ratingSum->total');

        $data['top_questions'] = Question::withCount('getAnswers')->orderBy('get_answers_count', 'desc')->take(3)->get();

        $data['today_articles'] = Article::where(['type' => 'Article', 'display_date' => date("Y-m-d", strtotime('-5 hours'))])->orderBy('id', 'desc')->take(3)->get();
        $data['today_strain'] = Article::where(['type' => 'Strain', 'display_date' => date("Y-m-d", strtotime('-5 hours'))])->withCount('getUserStrainLikes')->with('getUserStrain.getUser', 'getUserStrain.getStrain')->orderBy('id', 'desc')->first();
        $data['today_question'] = Article::where(['type' => 'Question', 'display_date' => date("Y-m-d", strtotime('-5 hours'))])->orderBy('id', 'desc')->first();
        $data['image']= App\HomeImage::first();
        return view('user.home_page', $data);
//    }
    });


    Route::get('/login', function () {
        if (Auth::guard('user')->check()) {
            return Redirect::to('wall');
        } else {
            return view('user.login');
        }
    });

    Route::get('forget', function () {
        if (Auth::guard('user')->check()) {
            return Redirect::to('wall');
//            $data['title'] = 'Home';
//            $data['questions'] = Question::selectRaw("REPLACE( REPLACE(REPLACE(REPLACE(REPLACE(question,'</font></b>',''),\"'\",''),'<br />',''),'\r\n',''),'<b ><font class=keyword_class color=#6d96ad>', '' ) AS question , id")->withCount('getAnswers')->orderBy('get_answers_count', 'desc')->get();
//            return view('user.home', $data);
        } else {
            return view('user.forget-password');
        }
    });
    Route::post('forget', 'Web\AuthController@forgetEmail');
    Route::get('changepassword', 'Web\AuthController@changePassword');
    Route::post('changepassword', 'Web\AuthController@updatePassword');
    Route::post('/', 'Web\AuthController@postLogin');
    Route::get('userlogout', function() {
        if (Auth::user()) {
            User::where('id', Auth::user()->id)->update(['show_budz_popup' => 1]);
            \App\LoginUsers::where(['user_id' => Auth::user()->id, 'device_id' => \Request::ip()])->delete();
            Auth::guard('user')->logout();
        }

        return Redirect::to(\Illuminate\Support\Facades\URL::previous());
    });
    Route::get('fb-login', 'Web\SocialAuthController@redirect');
    Route::get('/facebook', 'Web\SocialAuthController@callback');
    Route::get('google-login', 'Web\SocialAuthController@redirectToProvider');
    Route::get('google', 'Web\SocialAuthController@handleProviderCallback');


//Cron Jobs Routs
    Route::get('send-stats-mail', 'CronController@sendStatsMail');
    Route::get('update_subscription', 'CronController@updateSubscription');
//Article Detail page
    Route::get('/article_detail/{article_id}', 'Web\AuthController@getArticleDetail');

//404 page
    Route::get('/404', function () {
        return view('404-page');
    });

    Route::group(['middleware' => ['nocache']], function () {
        Route::get('support', 'Web\HelpAndSupportController@show');
        Route::get('questions', 'Web\QuestionController@getQuestions');
        Route::get('get-question-answers/{id}', 'Web\QuestionController@getQuestionAnswers');
        Route::get('get-question-answers-loader', 'Web\QuestionController@getQuestionAnswersLoader');
        Route::get('question/{id}', 'Web\QuestionController@getMyAnswers');
        Route::get('question-sorting', 'Web\QuestionController@questionSorting');
        Route::get('get-question-loader', 'Web\QuestionController@getQuestionLoader');
        Route::get('wall', 'Web\PostController@show');
        Route::get('/get-user-posts/{user_id}', 'Web\PostController@fetchPosts');
        Route::get('/get-user-posts', 'Web\PostController@fetchPosts');
        Route::get('/get-post/{post_id}', 'Web\PostController@getPostView');
        Route::get('/fetch-post/{post_id}', 'Web\PostController@getPost');
        Route::get('/get-post-comments', 'Web\PostController@getComments');
        Route::get('about-user/{user_id}', 'Web\UserController@userDetail');
        Route::get('user-reviews/{user_id}', 'Web\UserController@userReviews');
        Route::get('user-strains/{user_id}', 'Web\UserController@userStrains');
        Route::get('get-user-strains-loader/{user_id}', 'Web\UserController@userStrainsLoader');
        Route::get('user-budzmap/{user_id}', 'Web\UserController@userbudzMap');
        Route::get('get-user-budzmap-loader/{user_id}', 'Web\UserController@userbudzMapLoader');
        Route::get('/get-user-profile-posts/{user_id}', 'Web\UserController@fetchPosts');
        Route::get('/user-profile-questions/{user_id}', 'Web\UserController@userProfileQuestions');
        Route::get('/user-profile-questions-loader/{user_id}', 'Web\UserController@userProfileQuestionsLoader');
        Route::get('/myexpertise', 'Web\UserController@addMyExpertise');
        Route::get('user-profile-detail/{id}', 'Web\UserController@getUserProfileDetail');
        Route::get('hb-gallery/{user_id}', 'Web\UserController@getHBGallery');
        Route::get('strains-list', 'Web\StrainController@getStrainsAlphabitically');
        Route::get('strains-search', 'Web\StrainController@searchStrainByName');
        Route::get('strains-search-type/{type_id}', 'Web\StrainController@getStrainsByType');
        Route::get('strains-filter', 'Web\StrainController@searchStrainBySurvey');
        Route::get('strain-details/{strain_id}', 'Web\StrainController@getStrainDetail');
        Route::get('strain-details-by-name/{name}', 'Web\StrainController@getStrainDetailByName');
        Route::get('user-strains-listing/{strain_id}', 'Web\StrainController@getUserStrains');
        Route::get('user-strain-detail', 'Web\StrainController@getUserStrainDetail');
        Route::get('user-strain-add/{strain_id}', 'Web\StrainController@addUserStrain');
        Route::get('strain-review-listing/{strain_id}', 'Web\StrainController@getStrainReviews');
        Route::get('get-strain-review-loader', 'Web\StrainController@getStrainReviewsLoader');
        Route::get('strain-detail-gallery/{strain_id}/{image_id}', 'Web\StrainController@getStrainGalleryDetail');
        Route::get('delete-user-strain/{user_strain_id}', 'Web\StrainController@deleteUserStrain');
        Route::get('strain-gallery/{strain_id}', 'Web\StrainController@getStrainGallery');
        Route::get('budz-map', 'Web\BudzMapController@budzMap');
        Route::get('filter-bud-map', 'Web\BudzMapController@filterBudzMap');
        Route::get('get-budz-map-loader', 'Web\BudzMapController@getBudzMapLoader');
        Route::get('get-budz', 'Web\BudzMapController@getBudz');
        Route::get('budz-map-review-listing/{id}', 'Web\BudzMapController@getBudzReviews');
        Route::get('get-budz-map-review-loader', 'Web\BudzMapController@getBudzReviewsLoader');
        Route::get('globle-search', 'Web\SearchController@search');
        Route::get('search-keyword', 'Web\SearchController@searchKeyword');
        Route::get('get-global-search-loader', 'Web\SearchController@getSearchLoader');
        Route::get('get-keyword-search-loader', 'Web\SearchController@getKeyWordSearchLoader');
        Route::get('autoCompleteSearch', 'Web\SearchController@autoCompleteSearch');
        Route::get('get-strain-loader', 'Web\StrainController@getStrainsLoader');
        Route::get('privacy-policy', function () {
            $data['privacy_policy'] = PrivacyPolicy::first();
            return view('user.privacy-policy', $data);
        });
        Route::get('terms-conditions', function () {
            $data['term_coditions'] = TermCondation::first();
            return view('user.terms-conditions', $data);
        });
        Route::group(['middleware' => ['auth']], function () {
//   Shout outs
            Route::get('shout-outs', 'Web\ShoutOutController@shoutOuts');
            Route::get('save-shoutout', 'Web\ShoutOutController@saveShoutout');
            Route::get('get-shoutout/{id}', 'Web\ShoutOutController@getShoutOut');
            Route::post('add-shoutout', 'Web\ShoutOutController@addShoutOut');
            Route::post('like-shoutout', 'Web\ShoutOutController@likeShoutOut');
            Route::get('save_shoutout_share', 'Web\ShoutOutController@saveShoutOutShare');
            Route::get('save_shoutout_view', 'Web\ShoutOutController@saveShoutOutView');
            Route::get('shoutout_stats/{shout_out_id}', 'Web\ShoutOutController@shoutOutStats');
            Route::get('get_budz_specials/{id}', 'Web\ShoutOutController@getBudzSpecials');

            Route::get('expertise-intro', function () {
                return view('user.expertise-intro');
            });

            Route::get('expertise-edit', function () {
                return view('user.expertise-edit');
            });
            Route::get('user-nickname', function () {
                return view('user.user-nickname');
            });

//  Wall section


            Route::post('/add-post', 'Web\PostController@savePost');
            Route::post('/images-save', 'Web\PostController@addImage');
            Route::post('/images-delete', 'Web\PostController@deleteImage');
            Route::post('/video-save', 'Web\PostController@addVideo');
            Route::post('/video-delete', 'Web\PostController@deleteVideo');



            Route::get('/delete-post', 'Web\PostController@deletePost');
            Route::post('/like-post', 'Web\PostController@likePost');
            Route::post('/add-comment', 'Web\PostController@saveComment');
            Route::post('/like-comment', 'Web\PostController@likeComment');
            Route::get('/delete-comment', 'Web\PostController@deleteComment');
            Route::post('/send-comment-notifications', 'Web\PostController@sendCommentNotifications');

            Route::post('/mute-post', 'Web\PostController@mutePost');
            Route::post('/report-single-post', 'Web\PostController@reportPost');
            Route::post('/scrape-url', 'Web\PostController@scrapeUrl');
            Route::post('/add_shared_url_post', 'Web\PostController@addSharedUrlPost');
            Route::get('post-edit/{post_id}', 'Web\PostController@editPost');
            Route::get('get-post-images/{post_id}', 'Web\PostController@getPostImages');
            Route::get('get-post-video/{post_id}', 'Web\PostController@getPostVideo');


            Route::get('get-comment-images/{comment_id}', 'Web\PostController@getCommentImages');
            Route::get('get-comment-video/{comment_id}', 'Web\PostController@getCommentVideo');


            Route::post('/repost', 'Web\PostController@repost');


//  Questions Section

            Route::post('ask-question', 'Web\QuestionController@addQuestion');
            Route::get('search-question', 'Web\QuestionController@searchQuestion');
            Route::get('ask-questions', 'Web\QuestionController@askQuestion');
            Route::get('update-question/{id}', 'Web\QuestionController@updateQuestion');
            Route::get('save-question', 'Web\QuestionController@saveQuestion');
            Route::get('remove-save-question', 'Web\QuestionController@removeSaveQuestion');
            Route::get('delete-question/{question_id}', 'Web\QuestionController@deleteQuestion');
            Route::get('add-question-flag', 'Web\QuestionController@addQuestionFlag');
            Route::post('add-question-flag', 'Web\QuestionController@addQuestionFlagPost');
            Route::get('remove-question-flag', 'Web\QuestionController@removeQuestionFlag');




            Route::get('add_question_share_points', 'Web\QuestionController@addQuestionSharePoints');


//  Answer section 
            Route::get('give-answer/{id}', 'Web\AnswerController@showAnswer');
            Route::post('add-answer', 'Web\AnswerController@addAnswer');
            Route::get('like-answer', 'Web\AnswerController@likeAnswer');
            Route::get('remove-like-answer', 'Web\AnswerController@removeLikeAnswer');
            Route::post('add-answer-flag', 'Web\AnswerController@addAnswerFlag');
            Route::get('delete-answer/{id}', 'Web\AnswerController@deleteUserAnswer');
            Route::get('edit-answer/{id}', 'Web\AnswerController@editAnswer');
            Route::post('add_answer_attachment', 'Web\AnswerController@addAnswerAttachment');
            Route::post('remove-attachment', 'Web\AnswerController@removeAttachment');




//  Group Section    
            Route::get('groups', 'Web\GroupController@getGroups');
            Route::get('search-group', 'Web\GroupController@searchGroups');
            Route::get('group-sorting', 'Web\GroupController@groupSorting');
            Route::get('create-group', 'Web\GroupController@createGroup');
            Route::post('create-group', 'Web\GroupController@storeGroup');
            Route::post('invite-bud', 'Web\GroupController@groupBudInvite');
            Route::get('group-invitation/{invitation_id}', 'Web\GroupController@viewGroupInvitation');
            Route::post('group-invitation', 'Web\GroupController@respondGroupInvitation');
            Route::get('edit-group/{id}', 'Web\GroupController@editGroup');
            Route::get('group-create-success', 'Web\GroupController@successGroup');
            Route::get('group-chat/{id}', 'Web\GroupController@groupChat');
            Route::post('add-group-message', 'Web\GroupController@addMessage');
            Route::post('update-group', 'Web\GroupController@updateGroup');
            Route::get('remove-member/{id}', 'Web\GroupController@removeMember');
            Route::get('remove-group/{id}', 'Web\GroupController@removeGroup');
            Route::get('get-group-loader', 'Web\GroupController@getGroupLoader');
            Route::get('remove-group-message-like', 'Web\GroupController@removeMessageLike');
            Route::get('add-group-message-like', 'Web\GroupController@addMessageLike');
            Route::get('add-to-follow', 'Web\GroupController@joinGroup');


//Activities Section
            Route::get('activity-log', 'Web\ActivityController@getActivities');
            Route::get('sort-activity', 'Web\ActivityController@sortActivity');
            Route::get('budz-feeds', 'Web\ActivityController@budzFeeds');
            Route::get('get-budz-feeds-loader', 'Web\ActivityController@getbudzFeedsLoader');
            Route::get('get-activity-loader', 'Web\ActivityController@getActivityLoader');
            Route::get('read_all_notifications', 'Web\ActivityController@readAllNotifications');


//    
            Route::get('edit-group', function () {
                return view('user.edit-group');
            });

            Route::get('strains', function () {
                return view('user.strains');
            });


            Route::get('support_from_reward', 'Web\HelpAndSupportController@supportFromReward');

//  User Section

            Route::get('profile-setting', 'Web\UserController@getProfile');
            Route::get('get-experties', 'Web\UserController@getExperties');
            Route::post('update_profile', 'Web\UserController@updateProfile');
            Route::post('update_username', 'Web\UserController@updateUserName');
            Route::post('update_name', 'Web\UserController@updateName');
            Route::post('update_zip_code', 'Web\UserController@updateZipCode');
            Route::post('update_email', 'Web\UserController@updateEmail');
            Route::post('change_password', 'Web\UserController@changePassword');
            Route::post('update_bio', 'Web\UserController@updateBio');
            Route::post('update_profile_photo', 'Web\UserController@updateProfilePhoto');
            Route::post('update_special_icon', 'Web\UserController@updateSpecialIcon');
            Route::post('update_cover', 'Web\UserController@updateCover');
            Route::get('follow-user/{followed_id}', 'Web\UserController@followUser');
            Route::get('un-follow-user/{followed_id}', 'Web\UserController@unFollowUser');
            Route::post('update-user-experties', 'Web\UserController@updateUserExperties');
            Route::get('search-user', 'Web\UserController@searchUser');

            Route::get('delete-hb-gallery/{pk}', 'Web\UserController@deleteHbImage');
            Route::post('add-hb-mdeia', 'Web\UserController@addHbMedia');
            Route::get('follow', 'Web\UserController@follow');
            Route::get('unfollow', 'Web\UserController@unfollow');
            Route::get('follow-keyword', 'Web\UserController@followKeyword');
            Route::get('budz-follow', 'Web\UserController@allUser');
            Route::post('save_my_exp', 'Web\UserController@saveMyExpertise');
            Route::get('all-tags', 'Web\UserController@tagView');
            Route::get('get-tags', 'Web\UserController@getAllTags');

//  Strain Section

            Route::get('add-like-strain-review', 'Web\StrainController@addStrainReviewLike');
            Route::post('save-user-strain', 'Web\StrainController@saveUserStrain');
            Route::post('save-strain-search', 'Web\StrainController@saveStrainSearch');
//    Route::post('save-user-strain-like', 'Web\StrainController@saveUserStrainLike');
            Route::get('save-user-strain-like/{user_strain_id}/{strain_id}/{is_like}', 'Web\StrainController@saveUserStrainLike');
            Route::get('strain-product-listing/{strain_id}', 'Web\StrainController@getStrainProducts');
            Route::get('strain-product-listing-current/{strain_id}', 'Web\StrainController@getStrainCurrentProducts');
            Route::post('strain_like', 'Web\StrainController@saveStrainLike');
            Route::get('delete-strain-survay', 'Web\StrainController@deleteStrainSurvay');
            Route::post('strain_like_revert', 'Web\StrainController@revertStrainLike');
            Route::post('strain_dislike', 'Web\StrainController@saveStrainDislike');
            Route::post('strain_dislike_revert', 'Web\StrainController@revertStrainDislike');
            Route::post('strain_flag', 'Web\StrainController@saveStrainFlag');
            Route::post('strain_flag_revert', 'Web\StrainController@revertStrainFlag');

            Route::get('edit-user-strain/{user_strain_id}', 'Web\StrainController@editUserStrain');

            Route::post('strain-add-favorit', 'Web\StrainController@addToFavorit');
            Route::post('strain-remove-favorit', 'Web\StrainController@removeFromFavorit');

            Route::post('add_strain_review', 'Web\StrainController@addReview');
            Route::post('flag_strain_review', 'Web\StrainController@flagStrainReview');

            Route::get('delete-strain-review/{strain_review_id}/{strain_id}', 'Web\StrainController@deleteStrainReview');
            Route::get('edit-strain-review/{strain_review_id}/{strain_id}', 'Web\StrainController@editStrainReview');
            Route::post('delete-strain-review-attachment', 'Web\StrainController@deleteStrainReviewAttachment');
            Route::post('upload_strain_image', 'Web\StrainController@uploadStrainImage');




            Route::get('get-survey-data', 'Web\StrainController@getSurveyData');
            Route::post('save-survey-answer', 'Web\StrainController@saveSurveyAnswer');
            Route::post('save-medical-condition-suggestion', 'Web\StrainController@saveMedicalConditionSuggestion');
            Route::post('save-sensation-suggestion', 'Web\StrainController@saveSensationSuggestion');
            Route::post('save-negative-effect-suggestion', 'Web\StrainController@saveNegativeEffectSuggestion');
            Route::post('save-prevention-suggestion', 'Web\StrainController@savePreventionSuggestion');

            Route::get('save-strain-image-like', 'Web\StrainController@saveStrainImageLike');
            Route::get('save-strain-image-dislike', 'Web\StrainController@saveStrainImageDislike');
            Route::post('save-strain-image-flag', 'Web\StrainController@storeStrainImageFlag');
            Route::get('save-strain-image-flag', 'Web\StrainController@saveStrainImageFlag');
            Route::post('delete_strain_image', 'Web\StrainController@deleteStrainImage');
//
//  Help and Support Section
            Route::post('support-message', 'Web\HelpAndSupportController@sendSupportMail');
            Route::post('send-invitation-mail', 'Web\HelpAndSupportController@sendInvitationMail');

            Route::get('journals-new', function () {
                return view('user.journals-new');
            });


//    Budz Map Section


            Route::get('add-review-flag', 'Web\BudzMapController@addReviewFlag');

            Route::post('add_product_attachment', 'Web\BudzMapController@addProductAttachment');

            Route::post('report-budz', 'Web\BudzMapController@addBudzFlag');
            Route::post('report-budz-review', 'Web\BudzMapController@addReviewFlag');
            Route::post('add-budzmap-review', 'Web\BudzMapController@addReview');
            Route::post('add-budzmap-review-reply', 'Web\BudzMapController@addReviewReply');
            Route::get('edit-budzmap-review-reply/{review_id}/{business_id}/{business_type_id}', 'Web\BudzMapController@editReviewReply');
            Route::get('delete-budzmap-review-reply/{review_reply_id}', 'Web\BudzMapController@deleteReviewReply');
            Route::get('delete-budmap-review/{review_id}/{business_id}/{business_type_id}', 'Web\BudzMapController@deleteBudmapReview');
            Route::get('edit-budmap-review/{review_id}/{business_id}/{business_type_id}', 'Web\BudzMapController@editBudmapReview');
            Route::post('delete-budz-review-attachment', 'Web\BudzMapController@deleteBudmapReviewAttachment');
            Route::post('update_bud_rating', 'Web\BudzMapController@updateBudRating');

            Route::get('save_budzmap_share', 'Web\BudzMapController@saveBudzMapShare');
            Route::post('save-budz-menu-click', 'Web\BudzMapController@saveBudzMenuClick');
            Route::post('save-budz-ticket-click', 'Web\BudzMapController@saveBudzTicketClick');

            Route::get('budz-gallary/{id}', 'Web\BudzMapController@BudzGallery');
            Route::get('budz-gallery-detail/{id}/{image_id}', 'Web\BudzMapController@BudzGallerySlider');
            Route::post('add-sub-user-image', 'Web\BudzMapController@addSubUserImage');
            Route::get('save-budz', 'Web\BudzMapController@saveBudz');
            Route::get('budz-map-add', 'Web\BudzMapController@createbudz');
            Route::get('check_budz_title', 'Web\BudzMapController@checkBudzTitle');
            Route::post('create-bud', 'Web\BudzMapController@storeBud');
            Route::get('budz-map-edit/{id}', 'Web\BudzMapController@showEdit');
            Route::get('delete-budz/{id}', 'Web\BudzMapController@deleteBudz');
            Route::get('cancel-subscription/{id}', 'Web\BudzMapController@deleteSubscription');
            Route::post('add-budz-review-like', 'Web\BudzMapController@addBudzReviewLike');

            Route::post('add-service', 'Web\BudzMapController@addService');
            Route::get('delete-service/{service_id}', 'Web\BudzMapController@deleteService');
            Route::post('add-product', 'Web\BudzMapController@addProduct');
            Route::get('delete-product/{product_id}', 'Web\BudzMapController@deleteProduct');
            Route::post('edit-product', 'Web\BudzMapController@editProduct');
            Route::post('remove-product-attachment', 'Web\BudzMapController@removeAttachment');
            Route::post('add-ticket', 'Web\BudzMapController@addTicket');
            Route::get('delete-ticket/{product_id}', 'Web\BudzMapController@deleteTicket');
            Route::get('remove-save-budz', 'Web\BudzMapController@removeSaveBudz');
            Route::post('subscribe-user', 'Web\BudzMapController@addSubscription');
            Route::post('update-subscription', 'Web\BudzMapController@updateSubscription');
            Route::post('add_special', 'Web\BudzMapController@addSpecial');
            Route::post('update_special', 'Web\BudzMapController@updateSpecial');
            Route::get('delete-special/{special_id}', 'Web\BudzMapController@deleteSpecial');
            Route::get('budz-map-md/{id}', function ($id) {
                $data['budz'] = \App\SubUser::where('id', $id)->withCount(['getUserSave' => function($query) {
                                $query->where('user_id', \Illuminate\Support\Facades\Auth::user()->id);
                            }])->first();

                $data['title'] = 'Budz Map';
                $data['id'] = $id;
                return view('user.budz-map-md', $data);
            });
            Route::get('invoices/{sub_user_id}', 'Web\BudzMapController@getSubscription');
            Route::get('update_pop_up', 'Web\BudzMapController@updatepopUp');

//     My Section 
            Route::get('my-questions', 'Web\MyController@myQuestions');
            Route::get('my-answers', 'Web\MyController@myAnswers');
            Route::get('my-strains', 'Web\MyController@myStrains');
            Route::get('my-budz-map', 'Web\MyController@myBudzMap');
            Route::get('my-journals', 'Web\MyController@myJournals');
            Route::get('my-groups', 'Web\MyController@myGoups');
            Route::get('my-rewards', 'Web\MyController@myRewards');
            Route::get('reward-log', 'Web\MyController@rewardLog');
            Route::get('reward-log-loader', 'Web\MyController@rewardLogLoader');
            Route::get('my-saves', 'Web\MyController@mySaves');
            Route::get('mysave-setting', 'Web\MyController@mySavesSetting');
            Route::get('delete-mysave/{id}', 'Web\MyController@deleteMySave');
            Route::get('filter-mysave', 'Web\MyController@filterMySave');

            Route::get('get-my-journal-loader', 'Web\MyController@getMyJournalLoader');
            Route::get('get-my-question-loader', 'Web\MyController@getMyQuestionLoader');
            Route::get('get-my-answers-loader', 'Web\MyController@getMyAnswersLoader');
            Route::get('get-my-groups-loader', 'Web\MyController@getMyGroupsLoader');
            Route::get('get-my-strains-loader', 'Web\MyController@getMyStrainsLoader');
            Route::get('get-my-budz-map-loader', 'Web\MyController@getMyBudzMapLoader');
            Route::get('get-my-saves-loader', 'Web\MyController@getMySavesLoader');
            Route::get('save-strains', 'Web\MyController@getSavedStrains');
            Route::get('save-strains-loader', 'Web\MyController@getSavedStrainsLoader');
            

            Route::get('map-add', function () {
                return view('user.map-add');
            });

            Route::get('budz-map-events/{id}', function ($id) {
                $data['budz'] = \App\SubUser::where('id', $id)->withCount(['getUserSave' => function($query) {
                                $query->where('user_id', \Illuminate\Support\Facades\Auth::user()->id);
                            }])->first();

                $data['title'] = 'Budz Map';
                $data['id'] = $id;
                return view('user.budz-map-events', $data);
            });

            Route::get('budz-map-cannabites/{id}', function ($id) {
                $data['budz'] = \App\SubUser::where('id', $id)->withCount(['getUserSave' => function($query) {
                                $query->where('user_id', \Illuminate\Support\Facades\Auth::user()->id);
                            }])->first();

                $data['title'] = 'Budz Map';
                $data['id'] = $id;
                return view('user.budz-map-cannabites', $data);
            });

//  Journal Section
            Route::get('journals', 'Web\JournalController@getJournals');
            Route::get('journal-sorting', 'Web\JournalController@journalSorting');
            Route::get('my-journal-sorting', 'Web\JournalController@myJournalSorting');
            Route::get('journal-search', 'Web\JournalController@journalSearch');
            Route::post('journal-add-favorit', 'Web\JournalController@addToFavorit');
            Route::post('journal-remove-favorit', 'Web\JournalController@removeFromFavorit');
            Route::post('journal-event-like', 'Web\JournalController@saveJournalEventLike');
            Route::post('journal-event-like-revert', 'Web\JournalController@revertJournalEventLike');
            Route::post('journal-event-dislike', 'Web\JournalController@saveJournalEventDislike');
            Route::post('journal-event-dislike-revert', 'Web\JournalController@revertJournalEventDislike');
            Route::get('journal-details/{journal_id}', 'Web\JournalController@getJournalEvents');
            Route::get('journals-calendar', 'Web\JournalController@getJournalEventsCalendar');
            Route::get('journal-tags', 'Web\JournalController@getJournalTags');
            Route::get('add-journal-event/{journal_id}', 'Web\JournalController@addJournalEvent');
            Route::post('save-journal-event', 'Web\JournalController@createJournalEvent');
            Route::post('add_journal_event_attachment', 'Web\JournalController@addJournalEventAttachment');
            Route::post('remove_journal_event_attachment', 'Web\JournalController@removeAttachment');
            Route::get('edit-journal-event/{journal_id}', 'Web\JournalController@editJournalEvent');
            Route::get('journal-event-detail/{journal_event_id}', 'Web\JournalController@getJournalEventDetail');
            Route::get('get-journal-loader', 'Web\JournalController@getJournalLoader');
            Route::get('follow-journal/{journal_id}', 'Web\JournalController@followJournal');
            Route::get('unfollow-journal/{journal_id}', 'Web\JournalController@unFollowJournal');

            Route::post('create-journal', 'Web\JournalController@createJournal');
            Route::post('update-journal', 'Web\JournalController@updateJournal');
            Route::get('delete-journal/{journal_id}', 'Web\JournalController@deleteJournal');
            Route::get('delete-journal-event/{journal_event_id}', 'Web\JournalController@deleteJournalEvent');

            Route::get('invite-bud', function () {
                return view('user.invite-bud');
            });
            Route::get('ca-healing', function () {
                return view('user.ca-healing');
            });
            Route::get('leave-group', function () {
                return view('user.leave-group');
            });



            Route::get('chat-sidebar', function () {
                return view('user.chat-sidebar');
            });
//    Settings 
//    
            Route::get('settings', 'Web\SettingController@getSetting');
            Route::get('business-settings', 'Web\SettingController@getBussinessSettings');
            Route::get('journal-settings', 'Web\SettingController@getJournalSettings');
            Route::get('reminder-settings', 'Web\SettingController@getBussinessSettings');
            Route::get('data-settings', 'Web\SettingController@getBussinessSettings');
            Route::get('notifications-settings', 'Web\SettingController@getNotificationSettings');
            Route::get('save-settting', 'Web\SettingController@addNotificarionSetting');
            Route::get('save-journal-setting', 'Web\SettingController@saveJournalSetting');
            Route::get('remove-tag', 'Web\SettingController@removeTag');
            Route::get('add-tag', 'Web\SettingController@addTag');
            Route::get('remove-add-tag', 'Web\SettingController@removeAddTag');
            Route::get('check-keyword-following', 'Web\SettingController@checkKeywordFollowing');
//    Search Section
//  Chat Section
            Route::get('messages', 'Web\ChatController@getChats');
            Route::get('message-detail/{id}', 'Web\ChatController@getChatDetails');
            Route::get('message-detail-iframe/{id}', 'Web\ChatController@getChatDetailsIframe');
            Route::get('message-user-detail/{other_id}', 'Web\ChatController@getChatUserDetails');
            Route::post('/add_message', 'Web\ChatController@addMessage');
            Route::post('add-file', 'Web\ChatController@addFile');
            Route::get('delete-chat/{id}', 'Web\ChatController@deleteChat');
            Route::get('get_url_message', 'Web\ChatController@returnMessage');
            Route::get('add_chat_my_save', 'Web\ChatController@addChatMySave');
            Route::get('add_buss_chat_my_save', 'Web\ChatController@addBussChatMySave');
            //  Budz Chat Section
            Route::get('budz-chat', 'Web\BudzChatController@getBudzChats');
            Route::get('budz-message-detail/{id}', 'Web\BudzChatController@getChatDetails');
            Route::get('budz-listing-message-detail/{user_id}/{budz_id}', 'Web\BudzChatController@getChatBudzDetails');
            Route::post('/add_budz_message', 'Web\BudzChatController@addMessage');
            Route::get('delete-budz-chat/{id}', 'Web\BudzChatController@deleteChat');

//      Key words Section  
            Route::get('list-key-state', 'Web\KeyWordController@listKeyStates');
            Route::get('list-key-words', 'Web\KeyWordController@listKeyWords');
            Route::post('buy-keyword', 'Web\KeyWordController@buyKeyword');

//   Stats
            Route::get('list-user-keywords', 'Web\KeyWordController@listUserKeywords');
            Route::get('keyword-analytics/{keyword_id}/{zip_code}', 'Web\KeyWordController@getKeywordAnalytics');
            Route::get('filter-keyword-analytics/{keyword_id}/{zip_code}/{filter}', 'Web\KeyWordController@filterKeywordAnalytics');
            Route::get('date-keyword-analytics/{keyword_id}/{zip_code}', 'Web\KeyWordController@dateKeywordAnalytics');
            Route::post('keywords-stats-mail', 'Web\KeyWordController@sendKeywordStatsMail');
            Route::get('shoutout-stats', 'Web\ShoutOutController@shoutOutStats');
            Route::get('budz-map-stats', 'Web\BudzMapController@budzMapStats');
            Route::get('filter-budz-map-stats/{filter}', 'Web\BudzMapController@filterSubUser');
            Route::get('date-budz-map-stats', 'Web\BudzMapController@filterSubUserDate');
            Route::get('single-budz-stats/{budz_id}', 'Web\BudzMapController@singleBudzStat');
            Route::post('reload-keyword', 'Web\KeyWordController@reloadKeyword');
//  Store Section
            Route::get('store-products', 'Web\ProductController@getProducts');
            Route::get('get-products-loader', 'Web\ProductController@getProductsLoader');
            Route::get('store-redeem', function () {
                return view('user.store-redeem');
            });

            Route::get('purchase-product', 'Web\ProductController@purchaseProduct');
//    Payments section 
            Route::get('cards-section', 'Web\PaymentController@show');
            Route::post('cards-section', 'Web\PaymentController@save');
            Route::post('charge_user', 'Web\PaymentController@charge');
        });
    });
    Route::get('/home-article-list', 'Web\AuthController@homeArtical');
    Route::get('/search_artical', 'Web\AuthController@searchArtical');
    Route::get('/get_selected_articals/{cat_id}', 'Web\AuthController@searchCatArtical');
});
//      Admin Routes
Route::get('/admin_login', function () {
    if (Auth::guard('admin')->check()) {
        return Redirect::to('admin_dashboard');
    } else {
        return view('admin.login');
    }
});
Route::post('/admin_login', 'Admin\AdminController@adminLogin');
Route::get('admin_logout', function() {

    Auth::guard('admin')->logout();
    return Redirect::to(\Illuminate\Support\Facades\URL::previous());
});
Route::group(['middleware' => ['nocache', 'admin']], function () {

    //user routes
    Route::get('/admin_dashboard', 'Admin\AdminController@getDashboard');
    Route::get('/get_admin_profile', 'Admin\AdminController@getAdminProfile');
    Route::post('/update_admin_profile', 'Admin\AdminController@updateAdminProfile');
    Route::get('/show_users', 'Admin\AdminController@getUsers');
    Route::get('/user_account/{user_id}', 'Admin\AdminController@JumpToUserAccount');
    Route::get('/approve_status/{status}/{id}', 'Admin\AdminController@userApproveStatus');
    
    Route::get('/business_profiles', 'Admin\AdminController@getBusinessProfiles');
    
    Route::post('/business_profiles_ajax', 'Admin\AdminController@getBusinessProfilesAjax');
    
    
    Route::post('/block_unblock_business_profiles', 'Admin\AdminController@blockUnblockSubuser');
    Route::get('/user_business_profiles/{user_id}', 'Admin\AdminController@getUserBusinessProfiles');
    Route::get('/user_business_profile_detail/{sub_user_id}', 'Admin\AdminController@getUserBusinessProfileDetail');
    Route::get('/get_business_profile_reviews/{sub_user_id}', 'Admin\AdminController@getBusinessProfileReviews');
    Route::get('/get_business_profile_reviews_flags/{sub_user_id}/{review_id}', 'Admin\AdminController@getBusinessProfileReviewFlags');
    Route::get('/subscriptions/{id}', 'Admin\AdminController@getSubscriptions');
    Route::get('/add_user', 'Admin\AdminController@addUserView');
    Route::post('/add_user', 'Admin\AdminController@addUser');
    Route::get('/delete_user/{id}', 'Admin\AdminController@deleteUser');
    Route::get('/block_user/{id}', 'Admin\AdminController@blockUser');
    Route::get('/unblock_user/{id}', 'Admin\AdminController@unblockUser');
    Route::post('/delete_multiple_users', 'Admin\AdminController@deleteMultipleUsers');
    Route::get('/user_detail/{id}', 'Admin\AdminController@getUserDetail');
    Route::post('upload_user_image', 'Admin\AdminController@uploadUserImage');
    Route::post('upload_sub_user_image', 'Admin\AdminController@uploadSubUserImage');
//    Route::get('/update_user/{id}', 'Admin\AdminController@getUser');
//    Route::post('/update_user/{id}', 'Admin\AdminController@updateUser');
    Route::post('/update_user_first_name', 'Admin\AdminController@updateUserFirstName');
    Route::post('/update_user_last_name', 'Admin\AdminController@updateUserLastName');
    Route::post('/update_user_email', 'Admin\AdminController@updateUserEmail');
    Route::post('/update_user_password', 'Admin\AdminController@updateUserPassword');
    Route::post('/update_user_zip_code', 'Admin\AdminController@updateUserZipCode');

    //Special Users
    Route::get('/get_special_users', 'Admin\AdminController@getSpecialUsers');
    Route::post('/add_special_user', 'Admin\AdminController@addSpecialUsers');
    Route::get('/delete_special_user/{id}', 'Admin\AdminController@deleteSpecialUser');
    Route::get('/get_special_users_icons', 'Admin\AdminController@getSpecialSpecificUser');
    Route::post('/add_specific_user_icon', 'Admin\AdminController@addSpecialSpecificIcon');
    Route::get('/delete_specific_user_icon/{id}', 'Admin\AdminController@deleteSpecialUserIcon');
    Route::post('/delete_special_multi_user', 'Admin\AdminController@deleteMultiSpecialUser');
//   
    //Shout Outs
    Route::get('/shout_outs', 'Admin\ShoutOutController@getShoutOuts');
    Route::get('/delete_shout_outs/{id}', 'Admin\AdminController@deleteShoutOut');
    Route::post('/delete_multi_shout_outs', 'Admin\AdminController@deleteMultipleShoutOut');
    //tags
    Route::get('/tags', 'Admin\TagsController@getTags');
    Route::get('/tag_approve_status/{status}/{id}', 'Admin\TagsController@tagApproveStatus');
    Route::post('/add_tag', 'Admin\TagsController@addTag');
    Route::get('/delete_tag/{id}', 'Admin\TagsController@deleteTag');
    Route::post('/delete_multiple_tags', 'Admin\TagsController@deleteMultiTag');
    Route::post('/approve_multiple_tags', 'Admin\TagsController@approveMultiTag');
    Route::post('/update_tag', 'Admin\TagsController@updateTag');
    Route::post('/update_tag_price', 'Admin\TagsController@updatePrice');
    Route::post('/put_tag_on_sale', 'Admin\TagsController@onSale');
    Route::get('/remove_tag_sale/{tag_id}', 'Admin\TagsController@removeSale');
    Route::get('/purchased_tags', 'Admin\TagsController@getPurchasedTags');
    Route::get('/tag_searches/{tag_name}/{tag_id}', 'Admin\TagsController@getTagSearches');

    //User Searches
    Route::get('/user_searches', 'Admin\UserSearchController@getUserSearches');
    Route::get('/delete_user_search/{search_id}', 'Admin\UserSearchController@deleteUserSearch');
    Route::get('/add_to_tag/{search_id}', 'Admin\UserSearchController@addToTags');
    Route::post('/delete_multiple_user_searches', 'Admin\UserSearchController@deleteMultipleUserSearches');

    //flavors
    Route::get('/flavors', 'Admin\FlavorsController@getFlavors');
    Route::get('/delete_flavor/{id}', 'Admin\FlavorsController@deleteFlavor');
    Route::get('/delete_flavor_category/{id}', 'Admin\FlavorsController@deleteFlavorCategory');
    Route::post('/update_flavor/{id}', 'Admin\FlavorsController@updateFlavor');
    Route::post('/update_flavor_category/{id}', 'Admin\FlavorsController@updateFlavorCategory');
    Route::post('/add_flavor', 'Admin\FlavorsController@addFlavor');
    Route::post('/add_flavor_category', 'Admin\FlavorsController@addFlavorCategory');
    Route::get('/view_all_flavor_categories', 'Admin\FlavorsController@viewAllFlavorCategories');
    Route::post('/delete_multiple_flavors', 'Admin\FlavorsController@deleteMultipleFlavours');
    Route::post('/delete_multiple_flavor_categories', 'Admin\FlavorsController@deleteMultipleFlavourCategories');
    //medical conditions
    Route::get('/medical_conditions', 'Admin\MedicalConditionController@getMedicalConditions');
    Route::get('/medical_condition_approve_status/{status}/{id}', 'Admin\MedicalConditionController@medicalConditionApproveStatus');
    Route::post('/add_medical_condition', 'Admin\MedicalConditionController@addMedicalCondition');
    Route::get('/delete_medical_condition/{id}', 'Admin\MedicalConditionController@deleteMedicalCondition');
    Route::post('/delete_multiple_medical', 'Admin\MedicalConditionController@deleteMultipleMedical');
    Route::post('/update_medical_condition/{id}', 'Admin\MedicalConditionController@updateMedicalCondition');
    Route::post('/approve_disapprove_multiple_medical', 'Admin\MedicalConditionController@approveDisapproveMultipleMedical');
    //negative effects
    Route::get('/negative_effects', 'Admin\NegativeEffectsController@getNegativeEffects');
    Route::get('/negative_effect_approve_status/{status}/{id}', 'Admin\NegativeEffectsController@negativeEffectApproveStatus');
    Route::post('/add_negative_effect', 'Admin\NegativeEffectsController@addNegativeEffect');
    Route::get('/delete_negative_effect/{id}', 'Admin\NegativeEffectsController@deleteNegativeEffect');
    Route::post('/update_negative_effect', 'Admin\NegativeEffectsController@updateNegativeEffect');
    Route::post('/delete_multiple_negitive', 'Admin\NegativeEffectsController@deleteMultipleEffect');
    Route::post('/approve_disapprove_multiple_negitive', 'Admin\NegativeEffectsController@approveDisapproveMultipleNegitive');
    //sensations
    Route::get('/sensations', 'Admin\SensationsController@getSensations');
    Route::get('/sensation_approve_status/{status}/{id}', 'Admin\SensationsController@sensationApproveStatus');
    Route::post('/add_sensation', 'Admin\SensationsController@addSensation');
    Route::get('/delete_sensation/{id}', 'Admin\SensationsController@deleteSensation');
    Route::post('/update_sensation/{id}', 'Admin\SensationsController@updateSensation');
    Route::post('/delete_multiple_sensation', 'Admin\SensationsController@deleteMultipleSensation');
    Route::post('/approve_disapprove_multiple_sensation', 'Admin\SensationsController@approveDisapproveMultipleSensation');
    //disease preventions
    Route::get('/preventions', 'Admin\DiseasePreventionController@getPreventions');
    Route::get('/prevention_approve_status/{status}/{id}', 'Admin\DiseasePreventionController@preventionApproveStatus');
    Route::post('/add_prevention', 'Admin\DiseasePreventionController@addPrevention');
    Route::get('/delete_prevention/{id}', 'Admin\DiseasePreventionController@deletePrevention');
    Route::post('/update_prevention', 'Admin\DiseasePreventionController@updatePrevention');
    Route::post('/delete_multiple_prevention', 'Admin\DiseasePreventionController@deleteMultiplePrevention');
    Route::post('/approve_disapprove_multiple_prevention', 'Admin\DiseasePreventionController@approveDisapproveMultiplePrevention');
    //expertise questions
    Route::get('/expertise_questions', 'Admin\ExpertiseQuestionsController@getExpertiseQuestions');
    Route::get('/delete_expertise_question/{id}', 'Admin\ExpertiseQuestionsController@deleteExpertiseQuestion');
    Route::post('/update_expertise_question/{id}', 'Admin\ExpertiseQuestionsController@updateExpertiseQuestion');
    Route::get('/expertise_answers/{id}', 'Admin\ExpertiseQuestionsController@getExpertiseAnswers');
    Route::post('/update_expertise_answer/{id}', 'Admin\ExpertiseQuestionsController@updateExpertiseAnswer');
    Route::post('/add_expertise_answer', 'Admin\ExpertiseQuestionsController@addExpertiseAnswer');
    Route::get('/delete_expertise_answer/{id}', 'Admin\ExpertiseQuestionsController@deleteExpertiseAnswer');
    Route::get('/exp_answer_approve_status/{status}/{id}', 'Admin\ExpertiseQuestionsController@expAnswerApproveStatus');

    //flagged
    Route::get('/flagged_answers', 'Admin\FlagController@getFlaggedAnswers');
    Route::get('/delete_flagged_answer/{id}', 'Admin\FlagController@deleteFlaggedAnswer');
    Route::get('/flagged_questions', 'Admin\FlagController@getFlaggedQuestions');
    Route::post('/delete_flag_multiple_questions', 'Admin\FlagController@deleteFlagMultipleQuestions');
    Route::post('/delete_flag_multiple_answers', 'Admin\FlagController@deleteFlagMultipleAnswers');
    Route::get('/delete_flagged_question/{id}', 'Admin\FlagController@deleteFlaggedQuestion');
    Route::get('/flagged_business', 'Admin\FlagController@flaggedBusiness');

    Route::get('/flagged_business_reviews', 'Admin\FlagController@flaggedBusinessReviews');
    Route::get('/delete_business_review_flag/{flag_id}', 'Admin\FlagController@deleteBusinessReviewFlag');
    Route::post('delete_multiple_business_review_flags', 'Admin\FlagController@deleteMultipleBusinessReviewFlags');
    Route::get('/delete_business_review/{id}', 'Admin\FlagController@deleteBusinessReview');

    Route::get('/delete_flagged_profile/{id}', 'Admin\FlagController@deleteFlaggedProfile');
    Route::get('/delete_bussiness_profile/{id}', 'Admin\FlagController@deleteBussinessProfile');
    Route::Post('/delete_flag_multiple_subusers', 'Admin\FlagController@deleteFlagMultipleSubusers');
    Route::Post('/delete_multiple_subusers', 'Admin\FlagController@deleteMultipleSubusers');
    Route::Post('/delete_flag_multiple_strains', 'Admin\FlagController@deleteFlagMultipleStrains');
    //keywords
    Route::get('/keywords', 'Admin\KeywordsController@getKeywords');
    Route::get('/delete_keyword/{id}', 'Admin\KeywordsController@deleteKeyword');
    Route::post('/add_keyword', 'Admin\KeywordsController@addKeyword');
    Route::post('/onsale/{id}', 'Admin\KeywordsController@onSale');
    Route::get('/removesale/{id}', 'Admin\KeywordsController@saleRemove');
    Route::post('/update_keyword_price/{id}', 'Admin\KeywordsController@updatePrice');



    //questions and answers
    Route::get('/user_questions', 'Admin\QuestionAnswerController@questions');
    Route::get('/user_question_detail/{question_id}', 'Admin\QuestionAnswerController@getQuestionDetail');
    Route::get('/delete_question/{id}', 'Admin\QuestionAnswerController@deleteQuestion');
    Route::post('/update_question', 'Admin\QuestionAnswerController@updateQuestion');
    Route::post('/delete_multiple_questions', 'Admin\QuestionAnswerController@deleteMultipleQuestions');
    Route::get('/user_answers/{id}', 'Admin\QuestionAnswerController@userAnswers');
    Route::get('/user_answer_detail/{answer_id}', 'Admin\QuestionAnswerController@userAnswerDetail');
    Route::get('/delete_answer/{answer_id}', 'Admin\QuestionAnswerController@deleteAnswer');
    Route::post('/update_answer', 'Admin\QuestionAnswerController@updateAnswer');
    Route::post('/delete_multiple_answers', 'Admin\QuestionAnswerController@deleteMultipleAnswers');
    //user icons
    Route::get('/user_icons', 'Admin\IconsController@getIcons');
    Route::get('/delete_icon/{icon_id}', 'Admin\IconsController@deleteIcon');
    Route::post('/add_icon', 'Admin\IconsController@addIcon');
    Route::post('/delete_multiple_icons', 'Admin\IconsController@deleteMultipleIcon');
    Route::post('/add_special_icon', 'Admin\IconsController@addSpecialIcon');
    Route::post('/change_icon_image', 'Admin\IconsController@changeIcon');
    Route::get('/delete_special_icon/{icon_id}', 'Admin\IconsController@deleteSpecialIcon');
    Route::post('/delete_multiple_special_icons', 'Admin\IconsController@deleteMultipleSpecialIcon');

    //Special icons
    Route::get('/special_icons', 'Admin\IconsController@getSpecialIcons');
    Route::post('/change_special_icon_image', 'Admin\IconsController@changeSpecialIcon');

    //product
    Route::get('/admin_products', 'Admin\ProductController@getProducts');
    Route::post('/add_product', 'Admin\ProductController@addProduct');
    Route::post('/edit_product', 'Admin\ProductController@updateProduct');
    Route::get('/delete_product/{product_id}', 'Admin\ProductController@deleteProduct');
    Route::get('/get_product_orders/{product_id}', 'Admin\ProductController@getProductOrders');
    Route::get('/get_orders', 'Admin\ProductController@getOrders');
    Route::get('/delete_order/{order_id}', 'Admin\ProductController@deleteOrder');
    Route::get('/order_status/{status}/{order_id}', 'Admin\ProductController@changeOrderStatus');
    Route::post('/delete_multiple_products', 'Admin\ProductController@deleteMultipleProducts');
    Route::post('/delete_multiple_orders', 'Admin\ProductController@deleteMultipleOrders');

    Route::get('/admin_menu_categories', 'Admin\ProductController@adminMenuCategories');
    Route::post('/add_menu_category', 'Admin\ProductController@addMenuCategory');
    Route::get('/delete_menu_category/{cat_id}', 'Admin\ProductController@deleteCategory');
    Route::post('/delete_multiple_menu_categories', 'Admin\ProductController@deleteMultipleMenuCategories');
    //Basic Q&A
    Route::get('/basic_qa', 'Admin\BasicQaController@getQa');
    Route::get('/delete_basic_qa/{id}', 'Admin\BasicQaController@deleteQa');
    Route::post('/add_basic_qa', 'Admin\BasicQaController@addQa');
    Route::post('/update_basic_qa/{id}', 'Admin\BasicQaController@updateQa');
    Route::post('/delete/image', 'Admin\BasicQaController@deleteImage');

    //Strains
    Route::get('/strains', 'Admin\StrainsController@getStrains');
    Route::post('/strains_ajax', 'Admin\StrainsController@getStrainsAjax');
    Route::get('/strain_flagged_images', 'Admin\StrainsController@getStrainFlaggedImages');
    Route::get('/delete_strain_flagged_image/{flag_id}', 'Admin\StrainsController@deleteStrainFlaggedImage');
    Route::post('delete_multiple_strain_flagged_images', 'Admin\StrainsController@deleteMultipleStrainFlaggedImage');
    Route::get('/delete_strain_image/{id}', 'Admin\StrainsController@deleteStrainImage');
    Route::get('/delete_strain_image_reason/{id}', 'Admin\StrainsController@deleteStrainImageReason');

    Route::get('/strain_flagged_reviews', 'Admin\StrainsController@getStrainFlaggedReviews');
    Route::get('/delete_strain_review_flag/{flag_id}', 'Admin\StrainsController@deleteStrainReviewFlag');
    Route::post('delete_multiple_strain_review_flags', 'Admin\StrainsController@deleteMultipleStrainReviewFlags');
    Route::get('/delete_strain_review/{id}', 'Admin\StrainsController@deleteStrainReview');

    Route::get('/strain/detail/{id}', 'Admin\StrainsController@strainDetail');
    Route::get('/get_strain_flags/{strain_id}', 'Admin\StrainsController@getStrainFlages');
    Route::get('/get_strain_reviews/{strain_id}', 'Admin\StrainsController@getStrainReviews');
    Route::get('/get_strain_users/{strain_id}', 'Admin\StrainsController@getStrainUsers');
    Route::get('/get_strain_reviews_flags/{strain_id}/{strain_review_id}', 'Admin\StrainsController@getStrainReviewsFlags');
    Route::get('/users_strains', 'Admin\StrainsController@getUsersStrains');
    Route::get('/user_strain_detail/{user_strain_id}', 'Admin\StrainsController@getUserStrainDetail');
    Route::post('/add_strain', 'Admin\StrainsController@addStrain');
    Route::post('/add_strain_image', 'Admin\StrainsController@addStrainImage');
    Route::post('/update_strain', 'Admin\StrainsController@updateStrain');
    Route::get('/delete_strain/{id}', 'Admin\StrainsController@deleteStrain');
    Route::get('/strain/images/{id}', 'Admin\StrainsController@getStrainImages');
    Route::get('/strain_image_approve_status/{status}/{id}', 'Admin\StrainsController@imageApproveStatus');
    Route::get('/main_image/{strain_id}/{id}', 'Admin\StrainsController@mainImage');
    Route::post('/delete_multiple_strains', 'Admin\StrainsController@deleteMultipleStrains');
    Route::get('/upload_stain_images', 'Admin\AdminController@addStrainImage');
    //static pages
    Route::get('/terms', 'Admin\PagesController@getTerm');
    Route::post('/update/term', 'Admin\PagesController@updateTerm');

    Route::get('/policy', 'Admin\PagesController@getPolicy');
    Route::post('/update/policy', 'Admin\PagesController@updatePolicy');

    Route::get('/contact', 'Admin\PagesController@getContact');
    Route::post('/update/contact', 'Admin\PagesController@updateContact');

    Route::get('/about_us', 'Admin\PagesController@getAboutUs');
    Route::post('/update/about_us', 'Admin\PagesController@updateAboutUs');

    Route::get('/business_services', 'Admin\PagesController@getBusinessServices');
    Route::post('/update/business_services', 'Admin\PagesController@updateBusinessServices');

    Route::get('/careers_admin', 'Admin\PagesController@getCareers');
    Route::post('/update/careers', 'Admin\PagesController@updateCareers');

    Route::get('/who_can_join', 'Admin\PagesController@getWhoCanJoin');
    Route::post('/update/who_can_join', 'Admin\PagesController@updateWhoCanJoin');

    Route::get('/daily_buzz', 'Admin\PagesController@getDailyBuzz');
    Route::post('/update/daily_buzz', 'Admin\PagesController@updateDailyBuzz');

    Route::get('/advertise', 'Admin\PagesController@getAdvertise');
    Route::post('/update/advertise', 'Admin\PagesController@updateAdvertise');

    Route::get('/commercial', 'Admin\PagesController@getCommercial');
    Route::post('/update/commercial', 'Admin\PagesController@updateCommercial');

    Route::get('/final_note', 'Admin\PagesController@getFinalNote');
    Route::post('/update/final_note', 'Admin\PagesController@updateFinalNote');

    Route::get('/what_to_expect', 'Admin\PagesController@getWhatToExpect');
    Route::post('/update/what_to_expect', 'Admin\PagesController@updateWhatToExpect');

    Route::get('/legal', 'Admin\PagesController@getLegal');
    Route::post('/update/legal/{id}', 'Admin\PagesController@updateLegal');

    //journals
    Route::get('/admin_journals', 'Admin\JournalsController@getJournals');
    Route::get('/admin_delete_journal/{id}', 'Admin\JournalsController@deleteJournal');
    Route::get('/admin_journal_events/{id}', 'Admin\JournalsController@journalEvents');
    Route::get('/admin_delete_event/{id}', 'Admin\JournalsController@deleteEvent');
    Route::get('/admin_event_description/{id}', 'Admin\JournalsController@eventDescription');
    Route::post('delete_multiple_journals', 'Admin\JournalsController@deleteMultipleJournals');

//    Wall Section 
    Route::get('/admin_wall', 'Admin\WallController@showPost');
    Route::get('/flagged_posts', 'Admin\WallController@flaggedPosts');
    Route::get('/admin_delete_post/{post_id}', 'Admin\WallController@deletePost');
    Route::get('/admin_post_detail/{post_id}', 'Admin\WallController@fetachPost');
    Route::get('/admin_user_wall/{user_id}', 'Admin\WallController@showUserPost');
    Route::get('/admin_post_remove_flag/{flag_id}', 'Admin\WallController@removeFlagPost');
    Route::get('/admin_strain_remove_flag/{flag_id}', 'Admin\WallController@removeStrainFlag');
    Route::post('/admin_delete_multi_posts', 'Admin\WallController@deleteMultiPosts');
    Route::post('/admin_post_remove_multi_flag', 'Admin\WallController@deleteMultiFlagPost');
//     Support
    Route::get('admin_support', 'Admin\PagesController@getSupport');
//    Payment Methods
    Route::get('payment_methods', 'Admin\AdminController@paymentMethods');
    Route::post('add_payment_method', 'Admin\AdminController@addPaymentMethod');
    Route::post('update_payment_method', 'Admin\AdminController@updatePaymentMethod');
    Route::get('delete_method/{method_id}', 'Admin\AdminController@deleteMethod');
    Route::post('delete_multiple_payments', 'Admin\AdminController@deleteMultiMethod');
//    Articles
    Route::get('admin_articles', 'Admin\ArticleController@index');
    Route::get('/add_article', 'Admin\ArticleController@addArticleView');
    Route::post('/add_article', 'Admin\ArticleController@addArticle');
    Route::post('/update_article', 'Admin\ArticleController@updateArticle');
    Route::get('/display_article/{status}/{article_id}', 'Admin\ArticleController@changeArticleStatus');
    Route::get('/delete_article/{article_id}', 'Admin\ArticleController@deleteArticle');
    Route::get('/edit_article_view/{article_id}', 'Admin\ArticleController@editArticle');
    Route::get('/admin_articles_categories', 'Admin\ArticleController@adminArticlesCategories');
    Route::post('/add_article_category', 'Admin\ArticleController@addArticleCategory');
    Route::get('/delete_category/{cat_id}', 'Admin\ArticleController@deleteCategory');
    Route::post('/delete_multiple_artical_categories', 'Admin\ArticleController@deleteMultipleArticalCategories');
//    Notification
    Route::get('/send_to_all', 'Admin\AdminController@showNotification');
    Route::post('/send_to_all', 'Admin\AdminController@sendNotificationToAll');
//    payments
    Route::get('/admin_payment', 'Admin\AdminController@getpaymentRecord');
    Route::get('/transactions', 'Admin\AdminController@getTransactions');
//    Import section 
    Route::get('/import_sction', 'Admin\AdminController@viewImport');
    Route::post('/add_strain_from_csv', 'Admin\AdminController@addStrainFromCsv');
    Route::post('/add_budz_from_csv', 'Admin\AdminController@addProfileFromCsv');
    
//    Home Image
    Route::get('/home_image', 'Admin\AdminController@homeImage');
    Route::post('/home_image', 'Admin\AdminController@homeImageAdd');
});


//Route::get('budz-chat', function () {
//        return view('user.budz-chat');
//    });

Route::get('/insert_db', function () {

    return view('insert_db');
});
Route::get('/intro', 'Web\AuthController@intro');
Route::post('/insert_db', 'AuthController@insert_zip_code');
Route::post('/add_image', 'AuthController@add_image');
Route::get('/special_notification', 'CronController@specialNotifiction');

Route::get('/agenotverified', function () {
    return view('age-not-verified');
});
Route::get('/errorstate', function () {
    return view('errorstate');
});
Route::get('/log_data_two', 'AuthController@closeTab');

// AR Route

