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
                        <?php
                        if (Auth::user()) {
                            if ($answer->user_id != $current_id) {
                                if ($answer->FlagByUser) {
                                    ?>
                                    <a  href="javascript:void(0)" class="report flag-icon active"><i class="fa fa-flag"></i></a>
                                <?php } else { ?>
                                    <a  href="#report-answer<?php echo $answer->id; ?>" class="report btn-popup"><i class="fa fa-flag"></i></a>
                                    <?php
                                    }
                                }
                            }
                            ?></div>
                    <div class="icons">
                    </div>
                </div>
            </div>
            <div class="detail_img_holder">
                <div class="pre-main-image">
                    <img src="<?php echo getImage($answer->getUser->image_path, $answer->getUser->avatar) ?>" alt="Image" class="detail_img_rounded">
                <?php if ($answer->getUser->special_icon) { ?>
                        <span class="fest-pre-img" style="background-image: url(<?php echo asset('public/images' . $answer->getUser->special_icon) ?>);"></span>
                <?php } ?>
                </div>
                    <?php if (Auth::user() && $answer->getUser->is_following_user == NULL && $answer->getUser->id != $current_id) { ?>
                    <a href="<?php echo asset('follow-user/' . $answer->getUser->id); ?>" class="plus-sign">+</a>
    <?php } ?>
                <div class="flagship">
                    <img src="<?= getRatingImage($answer->getUser->points) ?>" alt="Flagship">
    <?php /*    <em><?= $answer->getUser->points ?></em> */ ?>
                </div>
            </div>
            <div class="detail_txt_holder">
                <strong><a class="<?= getRatingClass($answer->getUser->points) ?>" href="<?php echo asset('user-profile-detail/' . $answer->getUser->id) ?>"><?= $answer->getUser->first_name; ?></a></strong>
                <p><?= $answer->answer; ?></p>
                <footer class="footer fo-att">
                        <?php if (count($answer->getAttachments) > 0) { ?>
                        <div class="uploaded-files list-none">

                            <span>Attachments</span>

                                <?php foreach ($answer->getAttachments as $attachment) { ?>

                                <li>
            <?php if ($attachment->media_type == 'image') { ?>
                                        <!--Test Start-->
                                        <?php $ans_slide_image = 'public/images' . $attachment->upload_path ?>
                                        <a href="<?php echo asset($ans_slide_image) ?>" class="" data-fancybox="gallery<?= $attachment->id ?>" >
                                            <div class="ans-slide-image" style="background-image: url(<?php echo asset($ans_slide_image) ?>)"></div>
                                        </a>
                                        <!--Test End-->
            <?php }if ($attachment->media_type == 'video') { ?>
                <?php $ans_slide_post = 'public/images' . $attachment->poster ?>
                                        <a href="#videos-<?= $attachment->id ?>" data-fancybox="gallery<?= $attachment->id ?>" >
                                            <div class="ans-slide-image" style="background-image: url(<?php echo asset($ans_slide_post) ?>)">
                                                <i class="fa fa-play-circle" aria-hidden="true"></i>
                                            </div>
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
                            <i class="fa fa-thumbs-up" aria-hidden="true"></i> Appreciate <em id="answer_like_count_unlike<?= $answer->id ?>" style="font-size:  10px"><?php echo count($answer->AnswerLike); ?></em>
                        </a>

                        <a onclick="removeAnswerLike('<?php echo $answer->id; ?>')" id="remalike<?php echo $answer->id; ?>" <?php if (!$answer->AnswerUserLike) { ?>style="display: none"<?php } ?> href="javascript:void(0)" class="thumb active">
                            <i class="fa fa-thumbs-up" aria-hidden="true"></i> Appreciated <em id="answer_like_count_like<?= $answer->id ?>" style="font-size:  14px; color:#fff;"><?php echo count($answer->AnswerLike); ?></em>
                        </a>
                    <?php } else { ?>
                        <a href="#loginModal" class="thumb new_popup_opener  be-btn">
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
                        
                        <input type="radio" name="group" id="sexual<?= $answer->id ?>" checked value="Nudity or sexual content">
                            <label for="sexual<?= $answer->id ?>">Nudity or sexual content</label>

                            <input type="radio" name="group" id="harasssment<?= $answer->id ?>"  value="Harassment or hate speech">
                            <label for="harasssment<?= $answer->id ?>">Harassment or hate speech</label>

                            <input type="radio" name="group" id="threatening<?= $answer->id ?>"  value="Threatening, violent, or concerning">
                            <label for="threatening<?= $answer->id ?>">Threatening, violent, or concerning</label>
                            
                        <input type="radio" name="group1" id="offensive1<?php echo $answer->id; ?>"  value="offensive">
                        <label for="offensive1<?php echo $answer->id; ?>">Answer is offensive</label>
                        <input type="radio" name="group1" id="spam1<?php echo $answer->id; ?>" value="Spam">
                        <label for="spam1<?php echo $answer->id; ?>">Spam</label>
                        <input type="radio" name="group1" id="unrelated1<?php echo $answer->id; ?>" value="">
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
    <?php $i = 0;
    foreach ($answer->getEdit as $edits) {
        $i++; ?>
                                <li <?php if ($i == 1) { ?> class="recent_edit" <?php } ?>>
                                    <span class="h_time"> <?= timeago($edits->created_at) ?> </span>
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