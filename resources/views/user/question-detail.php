<!DOCTYPE html>
<html lang="en">
    <?php include('includes/top.php'); ?>
    <body>
        <div id="wrapper">
            <?php include('includes/sidebar.php'); ?>
            <article id="content">
                <?php include('includes/header.php'); ?>
                <div class="padding-div">
                    <ul class="bread-crumbs list-none">
                        <li><a href="<?php echo asset('/'); ?>">Home</a></li>
                        <li><a href="<?php echo asset('questions'); ?>">Q&amp;A</a></li>
                        <li>Answered Questions</li>
                    </ul>
                    <div class="new_container">
                        <div class="search-area">
                            <?php if (Auth::user()) { ?>
                                <a href="<?php echo asset('ask-questions'); ?>" class="btn-ask"><img src="<?php echo asset('userassets/images/icon12.png') ?>" alt="Q">Ask Question</a>
                            <?php } else { ?>
                                <a href="#loginModal" class="btn-ask new_popup_opener  be-btn"><img src="<?php echo asset('userassets/images/icon12.png') ?>" alt="Q">Ask Question</a>
                            <?php } ?>
                            <?php // include 'includes/questions_search.php'; ?>
                        </div>
                        <ul class="questions-list list-none answers q-view q_details_view hb_get_q_a_listing">
                            <li>
                                <div class="text">
                                    <div class="txt-holder">
                                        <div class="question text-center no-margin">
                                            <div class="user-img">
                                                <div class="btns add abs">


                                                    <?php if (Auth::user() && $current_id != $question->user_id) { ?>
                                                        <?php if ($question->is_flaged_count) { ?>
                                                            <a id="addFlag<?php echo $question->id; ?>" href="#question-flag" class="report btn-popup">Report</a>
                                                        <?php } else { ?>
                                                            <a id="removeFlag<?php echo $question->id; ?>"  href="#" class="flag-icon active">Reported</a>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                    <a href="#" class="share-icon">Share</a>
                                                    <div class="custom-shares">
                                                        <?php
                                                        echo Share::page(asset('get-question-answers/' . $question->id), $question->question, ['class' => 'questions_class', 'id' => $question->id])
                                                                ->facebook($question->question)
                                                                ->twitter($question->question)
                                                                ->googlePlus($question->question);
                                                        ?>
                                                        <?php if(Auth::user()){ ?>
                                                        <div class="questions_class" onclick="shareInapp('<?= asset('get-question-answers/' . $question->id) ?>', '<?php echo trim(revertTagSpace($question->question)); ?>', '<?= asset('userassets/images/logo-for-scrap.png') ?>')"> <span class="hb_icon_repost"></span> In App</div>
                                                        <?php } ?></div>
                                                </div>                                            
                                            </div>
                                            <div class="q_upper_part">
                                                <div class="details_header">
                                                    <div class="sort">
                                                        <!--<a href="#" class="dot-options operate-all-btn"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>-->
                                                        <span class="dot-options">
                                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                            <div class="sort-drop all-options">
                                                                <?php if ($question->user_id == $current_id && $question->get_answers_count == 0) { ?>
                                                                    <div class="sort-item expend-all active"><a href="<?php echo asset('update-question/' . $question->id); ?>"><i class="fa fa-pencil"></i>Edit Question</a></div>
                                                                <?php } ?>
                                                                <?php /*
                                                                  <div class="sort-item expend-all">
                                                                  <a <?php if ($question->get_user_likes_count) { ?> style="display: none"<?php } if (checkMySaveSetting('save_question')) { ?> href="javascript:void(0)" <?php } else { ?> href="#saved-discuss" <?php } ?>class="btn-popup fav-icon" onclick="addQuestionMySave('<?php echo $question->id; ?>','addqfav_<?php echo $question->id; ?>','remqfav_<?php echo $question->id; ?>')" id="addqfav_<?php echo $question->id; ?>"><i class="fa fa-heart-o" aria-hidden="true"></i> Favorite</a>
                                                                  <a <?php if (!$question->get_user_likes_count) { ?> style="display: none"<?php } ?>href="#unsave-discuss" class="btn-popup fav-icon active" onclick="removeQuestionMySave('<?php echo $question->id; ?>','remqfav_<?php echo $question->id; ?>','addqfav_<?php echo $question->id; ?>')" id="remqfav_<?php echo $question->id; ?>"><i class="fa fa-heart" aria-hidden="true"></i> Favorite</a>
                                                                  </div>
                                                                 */ ?>
                                                                <?php if (Auth::user() && $current_id != $question->user_id) { ?>
                                                                    <div class="sort-item expend-all">
                                                                        <a id="addFlag<?php echo $question->id; ?>" <?php if ($question->is_flaged_count) { ?> style="display: none"<?php } ?> href="#question-flag" class="report btn-popup"><i class="fa fa-flag" aria-hidden="true"></i> Report</a>
                                                                        <a id="removeFlag<?php echo $question->id; ?>" <?php if (!$question->is_flaged_count) { ?> style="display: none"<?php } ?> href="javascript:void(0)" style="color:#1383c6" class="flag-icon active"><i class="fa fa-flag" aria-hidden="true"></i>Reported</a>
                                                                    </div>
                                                                <?php } ?>
                                                                <div class="sort-item expend-all">
                                                                    <a href="#share-post" class="share-icon btn-popup"><i class="fa fa-share-alt" aria-hidden="true"></i> Share</a>
                                                                </div>
                                                            </div>
                                                        </span>
                                                    </div>
                                                    <div class="img-holder pre-main-image in-blk hb_round_img hb_bg_img" style="width:55px; height:55px; background-image: url(<?php echo getImage($question['getUser']->image_path, $question['getUser']->avatar) ?>)">
                                                        <?php if ($question['getUser']->special_icon) { ?>
                                                            <span class="fest-pre-img" style="background-image: url(<?php echo asset('public/images' . $question['getUser']->special_icon) ?>);"></span>
                                                        <?php } ?>
                                                    </div>
                                                    <span class="date absolute right-spc"><?= timeago($question->created_at); ?></span>
                                                    <span class="user-asked">
                                                        <a class="<?= getRatingClass($question['getUser']->points) ?>" href="<?php echo asset('user-profile-detail/' . $question['getUser']->id) ?>"><?php echo $question['getUser']->first_name; ?> </a> asks...
                                                    </span>
                                                </div>
                                                <div class="holder">
                                                    <div class="icon"><img src="<?php echo asset('userassets/images/question-icon.svg') ?>" alt="Q"> <?php echo $question->question; ?></div>
                                                    <span class="sub-q"><?php echo $question->description; ?> </span>
                                                </div>
                                                <?php if($question->Attachments->count() > 0){ ?>
                                                    <footer class="footer fo-att qs_uploaded_images">

                                                        <div class="uploaded-files list-none">
                                                            <?php foreach ($question->Attachments as $attachment){ ?>
                                                             <?php if ($attachment->media_type == 'image') { ?>
                                                                                        <!--Test Start-->
                                                              <?php $q_slide_image = image_fix_orientation('public/images' . $attachment->upload_path) ?>
                                                            <li>
                                                                <!--Test Start-->
                                                                <a href="<?php echo asset($q_slide_image) ?>" class="" data-fancybox="<?= $attachment->question_id ?>">
                                                                    <div class="ans-slide-image" style="background-image: url(<?php echo asset($q_slide_image) ?>)"></div>
                                                                </a>
                                                                <!--Test End-->
                                                            </li>
                                                             <?php }if ($attachment->media_type == 'video') {
                                                                 $q_slide_post = 'public/images' . $attachment->poster;
                                                                         ?>
                                                            <li>
                                                                <a href="#videos-<?= $attachment->id ?>" data-fancybox="<?= $attachment->question_id ?>">
                                                                    <div class="ans-slide-image" style="background-image: url(<?php echo asset($q_slide_post) ?>)"><i class="fa fa-play-circle" aria-hidden="true"></i></div>
                                                                </a>
                                                                <video height="100" width="100" poster="$q_slide_post" id="videos-<?= $attachment->id ?>" controls="" style="display: none;">
                                                                    <source src="<?php echo asset('public/videos' . $attachment->upload_path) ?>" type="video/mp4">
                                                                    Your browser does not support the video tag.
                                                                </video>

                                                            </li>
                                                             <?php }} ?>

                                                        </div>
                                                    </footer>
                                                    <?php } ?>
                                                
                                                <footer class="footer">
                                                    <div class="align-right">
                                                        <?php if (Auth::user()) { ?>
                                                            <a class="like_heart" <?php if ($question->get_user_likes_count) { ?> style="display: none"<?php } if (checkMySaveSetting('save_question')) { ?> href="javascript:void(0)" <?php } else { ?> href="#saved-discuss" <?php } ?> class="btn-popup heart" onclick="addQuestionMySave('<?php echo $question->id; ?>', 'addqfav<?php echo $question->id; ?>', 'remqfav<?php echo $question->id; ?>')" id="addqfav<?php echo $question->id; ?>"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                                                            <a class="like_heart" <?php if (!$question->get_user_likes_count) { ?> style="display: none"<?php } ?> href="javascript:void(0)" class="btn-popup fav-icon active" onclick="removeQuestionMySave('<?php echo $question->id; ?>', 'remqfav<?php echo $question->id; ?>', 'addqfav<?php echo $question->id; ?>')" id="remqfav<?php echo $question->id; ?>"><i style="color:#ff2525;" class="fa fa-heart" aria-hidden="true"></i></a>
                                                        <?php } else { ?>
                                                            <a href="#loginModal" class="new_popup_opener  be-btn like_heart btn-popup heart"  id=""><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                                                        <?php } ?>
                                                        <span id="fav_count_<?= $question->id ?>"><?= $question->getUserLikes->count(); ?></span>
                                                    </div> 
                                                    <?php if ($question->get_answers_count == 0 && $question->user_id == $current_id) { ?>
                                                        <?php
                                                    } else {
                                                        if (Auth::user()) {
                                                            ?>
                                                            <a href="<?php echo asset('give-answer/' . $question->id); ?>" class="btn-primary">Answer your Bud</a>
                                                        <?php } else { ?>
                                                            <a href="#loginModal" class="btn-primary new_popup_opener  be-btn">Answer your Bud</a>  
                                                            <?php
                                                        }
                                                    }
                                                    ?>  
                                                </footer>
                                            </div>
                                        </div>
                                        <div class="scrolled_area q_details_answers">
                                            <div class="answered-q" id="question_answers">
                                                <?php //if ($question->get_answers_count == 0 &&  $question->user_id != $current_id)  {    ?>
                                                    <!--<div class="clear-both"><a href="<?php //echo asset('give-answer/'.$question->id);   ?>" class="btn-primary right">Answer Your Bud</a></div>-->
                                                <?php //}    ?>
                                                <div class="ans_heading"><span><?php echo $question->get_answers_count; ?> <a href="#">Answers</a></span></div>
                                                <?php foreach ($question['getAnswers'] as $answer) { ?>
                                                    <div class="a-holder spac-an" id="answer<?= $answer->id ?>">
                                                        <div class="repeater_div">
                                                            <div class="align-right">

                                                                <?php if ($answer->user_id == $current_id) { ?>
                                                                    <span class="dot-options" style="padding-right: 0px;">
                                                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                                        <div class="sort-drop drop_down_items">
                                                                            <a  href="<?php echo asset('edit-answer/' . $answer->id) ?>" class="report"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Answer</a>
                                                                            <a href="#delete_answer<?php echo $answer->id; ?>" class="btn-popup"><i class="fa fa-trash"></i> Delete</a>
                                                                        </div>
                                                                    </span>
                                                                <?php } if ($answer->getEdit->count() > 0) { ?>
                                                                    <span class="hb_time_edit">
                                                                        <a href="#answer_popup<?= $answer->id ?>" class="btn-popup"> <i class="fa fa-clock-o"></i> Edit </a>
                                                                    </span>
                                                                <?php } ?>



                                                                <span class="date"><?= timeago($answer->created_at); ?></span>
            <!--                                                    <span class="date">1.14.17, 2:34 PM</span>-->
                                                                <div class="report-div">
                                                                    <div class="btns add">
                                                                        <?php if(Auth::user()) {  if($answer->user_id != $current_id){ if ($answer->FlagByUser) {    ?>
                                                                        <a  href="javascript:void(0)" class="report flag-icon active" style="margin:0 20px 0 10px"><i class="fa fa-flag" style="font-size: 20px;"></i></a>
                                                                        <?php } else {    ?>
                                                                        <a  href="#report-answer<?php echo $answer->id; ?>" class="report btn-popup"><i class="fa fa-flag"></i></a>
                                                                        <?php }}}    ?></div>
                                                                    <div class="icons">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="detail_img_holder">
                                                                <div class="pre-main-image hb_round_img hb_bg_img" style="background-image: url(<?php echo getImage($answer->getUser->image_path, $answer->getUser->avatar); ?>)">
                                                                    <?php if ($answer->getUser->special_icon) { ?>
                                                                        <span class="fest-pre-img" style="background-image: url(<?php echo asset('public/images' . $answer->getUser->special_icon) ?>);"></span>
                                                                    <?php } ?>
                                                                </div>
                                                                <?php if (Auth::user() && $answer->getUser->is_following_user == NULL && $answer->getUser->id != $current_id) { ?>
                                                                    <a href="<?php echo asset('follow-user/' . $answer->getUser->id); ?>" class="plus-sign">+</a>
                                                                <?php } ?>
                                                                <div class="flagship flagship-center">
                                                                    <img src="<?= getRatingImage($answer->getUser->points) ?>" alt="Flagship">
                                                                    <em class="<?= getRatingClass($answer->getUser->points) ?>"><?= $answer->getUser->points ?></em> 
                                                                </div>
                                                            </div>
                                                            <div class="detail_txt_holder">
                                                                <strong><a class="<?= getRatingClass($answer->getUser->points) ?>" href="<?php echo asset('user-profile-detail/' . $answer->getUser->id) ?>"><?= $answer->getUser->first_name; ?></a></strong>
                                                                <p style="color: #ffffff"><?= $answer->answer; ?></p>
                                                                <footer class="footer fo-att">
                                                                    <?php if (count($answer->getAttachments) > 0) { ?>
                                                                        <div class="uploaded-files list-none">

                                                                            <?php
                                                                            $count = 0;
                                                                            foreach ($answer->getAttachments as $attachment) {
                                                                                ?>

                                                                                <li>
                                                                                    <?php if ($attachment->media_type == 'image') { ?>
                                                                                        <!--Test Start-->
                                                                                        <?php $ans_slide_image = image_fix_orientation('public/images' . $attachment->upload_path) ?>
                                                                                        <a href="<?php echo asset($ans_slide_image) ?>" class="" data-fancybox="gallery<?= $attachment->answer_id ?>" >
                                                                                            <div class="ans-slide-image" style="background-image: url(<?php echo asset($ans_slide_image) ?>)"></div>
                                                                                        </a>
                                                                                        <!--Test End-->
                                                                                    <?php }if ($attachment->media_type == 'video') { ?>
                                                                                        <?php $ans_slide_post = 'public/images' . $attachment->poster ?>
                                                                                        <a href="#videos-<?= $attachment->id ?>" data-fancybox="gallery<?= $attachment->answer_id ?>" >
                                                                                            <div class="ans-slide-image" style="background-image: url(<?php echo asset($ans_slide_post) ?>)"><i class="fa fa-play-circle" aria-hidden="true"></i></div>
                                                                                        </a>
                                                                                        <video height="100" width="100" poster="<?php echo asset('public/images' . $attachment->poster) ?>" id="videos-<?= $attachment->id ?>" controls="" style="display: none;">
                                                                                            <source src="<?php echo asset('public/videos' . $attachment->upload_path) ?>" type="video/mp4">
                                                                                            Your browser does not support the video tag.
                                                                                        </video>

                                                                                    <?php } ?>
                                                                                </li>
                                                                            <?php } ?>
                                                                        </div><?php } ?>
                                                                </footer>
                                                                <div class="thu-q">
                                                                    <?php if (Auth::user()) { ?>
                                                                        <a onclick="addAnswerLike('<?php echo $answer->id; ?>')" id="addalike<?php echo $answer->id; ?>" <?php if ($answer->AnswerUserLike) { ?>style="display: none"<?php } ?> href="javascript:void(0)" class="thumb">
                                                                            <i class="fa fa-thumbs-up" aria-hidden="true"></i> Appreciate <em id="answer_like_count_unlike<?= $answer->id ?>" style="font-size:  14px"><?php echo count($answer->AnswerLike); ?></em>
                                                                        </a>

                                                                        <a onclick="removeAnswerLike('<?php echo $answer->id; ?>')" id="remalike<?php echo $answer->id; ?>" <?php if (!$answer->AnswerUserLike) { ?>style="display: none"<?php } ?> href="javascript:void(0)" class="thumb active">
                                                                            <i class="fa fa-thumbs-up" aria-hidden="true"></i> Appreciated <em id="answer_like_count_like<?= $answer->id ?>" style="font-size:  14px;"><?php echo count($answer->AnswerLike); ?></em>
                                                                        </a>
                                                                    <?php } else { ?>
                                                                        <a href="#loginModal" class="thumb new_popup_opener be-btn">
                                                                            <i class="fa fa-thumbs-up" aria-hidden="true"></i> Appreciate <em id="answer_like_count_unlike<?= $answer->id ?>" style="font-size:  14px"><?php echo count($answer->AnswerLike); ?></em>
                                                                        </a>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="report-answer<?php echo $answer->id; ?>" class="popup">
                                                        <div class="popup-holder">
                                                            <div class="popup-area">
                                                                <form action="<?php echo asset('add-answer-flag'); ?>" class="reporting-form" method="post">
                                                                    <input type="hidden" value="<?php echo $answer->id; ?>" name="id">
                                                                    <input type="hidden" value="<?php echo csrf_token(); ?>" name="_token">
                                                                    <fieldset>
                                                                        <h2>Reason For Reporting</h2>
                                                                        
                                                                         <input type="radio" name="group1" id="sexual<?= $answer->id ?>" checked value="Nudity or sexual content">
                            <label for="sexual<?= $answer->id ?>">Nudity or sexual content</label>

                            <input type="radio" name="group1" id="harasssment<?= $answer->id ?>"  value="Harassment or hate speech">
                            <label for="harasssment<?= $answer->id ?>">Harassment or hate speech</label>

                            <input type="radio" name="group1" id="threatening<?= $answer->id ?>"  value="Threatening, violent, or concerning">
                            <label for="threatening<?= $answer->id ?>">Threatening, violent, or concerning</label>
                            
                                                                        <input type="radio" name="group1" id="offensive1<?php echo $answer->id; ?>"  value="Answer is offensive">
                                                                        <label for="offensive1<?php echo $answer->id; ?>">Answer is offensive</label>
                                                                        <input type="radio" name="group1" id="spam1<?php echo $answer->id; ?>" value="Spam">
                                                                        <label for="spam1<?php echo $answer->id; ?>">Spam</label>
                                                                        <input type="radio" name="group1" id="unrelated1<?php echo $answer->id; ?>" value="Unrelated">
                                                                        <label for="unrelated1<?php echo $answer->id; ?>">Unrelated</label>
                                                                        <input type="submit" value="Report Answer">
                                                                        <a href="#" class="btn-close">x</a>
                                                                    </fieldset>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div id="answer_popup<?= $answer->id ?>" class="popup inp-pop sho-pop">
                                                        <div class="popup-holder">
                                                            <div class="popup-area">
                                                                <div class=hb_popup_inner_container>
                                                                    <div class="hb_edit_history">
                                                                        <div class="title">Edit History</div>
                                                                        <ul class="hb_edit_history_list">
                                                                            <?php $i=0; foreach ($answer->getEdit as $edits){ $i++; ?>
                                                                            <li <?php if($i==1){ ?> class="recent_edit" <?php } ?>>
                                                                                <span class="h_time"> <?= timeago($edits->created_at)?> </span>
                                                                                <div class="text_content">
                                                                                    <p><?= $edits->answer ?></p>
                                                                                </div>
                                                                            </li>
                                                                            
                                                                            <?php } ?>
                                                                        </ul>
                                                                    </div>
                                                                    <a href="#" class="btn-close">x</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!--Delete Answer Popup -->
                                                    <div id="delete_answer<?php echo $answer->id; ?>" class="popup">
                                                        <div class="popup-holder">
                                                            <div class="popup-area">
                                                                <div class="hb_popup_inner_container">
                                                                    <div class="edit-holder text-center">
                                                                        <div >
                                                                            <div class="step-header">
                                                                                <h4>Delete Answer</h4>
                                                                                <p class="yellow no-margin">Are you sure to delete this answer.</p>
                                                                            </div>
                                                                            <a href="<?php echo asset('delete-answer/' . $answer->id); ?>"  class="btn-heal">yes</a>
                                                                            <a href="#" class="btn-close">No</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Modal End-->

                                                <?php } ?>                                  
                                            </div>
                                            <div style="display: none" class="hb_simple_loader" id="loading"><img src="<?php echo asset('userassets/images/new_loadeer.svg') ?>" alt="Loading . . . ." class="post-loader"><span></span></div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="right_sidebars">
                        <?php
                        if (Auth::user()) {
                            include 'includes/rightsidebar.php';
                            ?>
                            <?php
                            include 'includes/chat-rightsidebar.php';
                        }
                        ?>
                    </div>
                </div>
            </article>
        </div>
        <div id="share-post" class="popup">
            <div class="popup-holder">
                <div class="popup-area">
                    <div class="reporting-form">
                        <h2>Select an option</h2>
                        <div class="custom-shares">
                            <?php
                            echo Share::page(asset('get-question-answers/' . $question->id), $question->description, ['class' => 'questions_class', 'id' => $question->id])
                                    ->facebook($question->description)
                                    ->twitter($question->description)
                                    ->googlePlus($question->description);
                            ?>
                            <?php if(Auth::user()){ ?>
                            <div class="questions_class in_app_button" onclick="shareInapp('<?= asset('get-question-answers/' . $question->id) ?>', '<?php echo trim(revertTagSpace($question->question)); ?>', '<?= asset('userassets/images/logo-for-scrap.png') ?>')"> <span class="hb_icon_repost"></span> In App</div>
                            <?php } ?></div>
                        <a href="javascript:void(0)" class="btn-close"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div id="image_popup" class="popup">
            <div class="popup-holder">
                <div class="popup-area">
                    <div class="text">
                        <div class="padding">
                            <img src="" alt="Image">
                        </div>
                        <a href="#" class="btn-close">Close</a>
                    </div>
                </div>
            </div>
        </div>


        <div id="saved-discuss" class="popup light-brown">
            <div class="popup-holder">
                <div class="popup-area">
                    <div class="text">
                        <header class="header no-padding add">
                            <strong>Saved Discussion</strong>
                        </header>
                        <div class="padding">
                            <p><img src="<?php echo asset('userassets/images/bg-success.svg') ?>" alt="Icon">Q's &amp; A's are saved in the app menu under My Saves</p>
                            <div class="check">
                                <input type="checkbox" id="check" onchange="addSaveSetting('save_question', this)">
                                <label  for="check">Got it! Do not show again for Q's &amp; A's | Save</label>
                            </div>
                        </div>
                        <a href="#" class="btn-close">Close</a>
                    </div>
                </div>
            </div>
        </div>
        <div id="question-flag" class="popup">
            <div class="popup-holder">
                <div class="popup-area">
                    <form action="<?php echo asset('add-question-flag'); ?>" class="reporting-form" method="post">
                        <input type="hidden" value="<?php echo $question->id; ?>" name="question_id">
                        <input type="hidden" value="<?php echo csrf_token(); ?>" name="_token">
                        <fieldset>
                            <h2>Reason For Reporting</h2>
                            <input type="radio" name="group" id="sexual"  value="Nudity or sexual content">
                            <label for="sexual">Nudity or sexual content</label>

                            <input type="radio" name="group" id="harasssment"  value="Harassment or hate speech">
                            <label for="harasssment">Harassment or hate speech</label>

                            <input type="radio" name="group" id="threatening"  value="Threatening, violent, or concerning">
                            <label for="threatening">Threatening, violent, or concerning</label>
                            
                            <input type="radio" name="group" id="abused"  value="offensive">
                            <label for="abused">Question is offensive</label>
                            <input type="radio" name="group" id="spam" value="Spam">
                            <label for="spam">Spam</label>
                            <input type="radio" name="group" id="unrelated" value="Unrelated">
                            <label for="unrelated">Unrelated</label>
                            <input type="submit" value="Report Question">
                            <a href="#" class="btn-close">x</a>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <?php include('includes/footer.php'); ?>
        <?php include 'includes/functions.php'; ?>
    </body>
    <script>
        //        $(document).ready(function() {
        //            $("[data-fancybox]").fancybox({
        //              afterShow: function() {
        // After the show-slide-animation has ended - play the vide in the current slide
        //               var vid = document.getElementById("videos-31"); 
        //               vid.play(); 

        // Attach the ended callback to trigger the fancybox.next() once the video has ended.
        //                this.content.find('video').on('ended', function() {
        //                  $.fancybox.next();
        //                });
        //              }
        //            });
        //        });
        function addAnswerLike(id) {
            var unlikecount = $('#answer_like_count_unlike' + id).html();
            var likecount = $('#answer_like_count_like' + id).html();
            $.ajax({
                type: "GET",
                url: "<?php echo asset('like-answer'); ?>",
                data: {
                    "answer_id": id
                },
                success: function (data) {
                    if (data == 1) {
                        $('#answer_like_count_unlike' + id).html(parseInt(unlikecount) + parseInt(1));
                        $('#answer_like_count_like' + id).html(parseInt(likecount) + parseInt(1));
                        $('#addalike' + id).hide();
                        $('#remalike' + id).show();
                    }
                }
            });
        }
        function removeAnswerLike(id) {
            var unlikecount = $('#answer_like_count_unlike' + id).html();
            var likecount = $('#answer_like_count_like' + id).html();
            $.ajax({
                type: "GET",
                url: "<?php echo asset('remove-like-answer'); ?>",
                data: {
                    "answer_id": id
                },
                success: function (data) {
                    if (data == 1) {
                        $('#answer_like_count_unlike' + id).html(parseInt(unlikecount) - parseInt(1));
                        $('#answer_like_count_like' + id).html(parseInt(likecount) - parseInt(1));
                        $('#remalike' + id).hide();
                        $('#addalike' + id).show();

                    }
                }
            });
        }
    </script>

    <script>

        var win = $(window);
        var count = 1;
        var ajaxcall = 1;
        var question_id = <?= $question->id ?>;
        win.on('scroll', function () {
            var docheight = parseInt($(document).height());
            var winheight = parseInt(win.height());
            var differnce = (docheight - winheight) - win.scrollTop();
            if (differnce < 100) {
                if (ajaxcall === 1) {
                    $('#loading').show();
                    ajaxcall = 0;
                    $.ajax({
                        url: "<?php echo asset('get-question-answers-loader') ?>",
                        type: "GET",
                        data: {
                            "count": count,
                            "question_id": question_id
                        },
                        success: function (data) {
                            if (data) {
                                var a = parseInt(1);
                                var b = parseInt(count);
                                count = b + a;
                                $('#question_answers').append(data);
                                $('#loading').hide();
                                ajaxcall = 1;
                            } else {
                                $('#loading').hide();
                                noposts = ' <div class="loader hb_not_more_posts_lbl" id="nomoreposts">No More Answers To Show</div> ';
                                $('#question_answers').append(noposts);
                            }
                        }
                    });
                }

            }
        });

        $('.questions_class').click(function () {
            $(this).parents('.custom-shares.new-shares').hide();
            id = this.id;
            $('#share-post').fadeOut();
            $.ajax({
                url: "<?php echo asset('add_question_share_points') ?>",
                type: "GET",
                data: {
                    "id": id, "type": "Question"
                },
                success: function (data) {
                }
            });
        });
    </script>
</html>