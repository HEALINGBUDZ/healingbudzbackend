 <?php foreach ($questions as $question ){ ?>
                        <!-- Report Question Popup -->
                            <div id="question-flag<?= $question->id?>" class="popup">
                                <div class="popup-holder">
                                    <div class="popup-area">
                                        <form action="<?php echo asset('add-question-flag'); ?>" class="reporting-form" method="post">
                                            <input type="hidden" value="<?php echo $question->id; ?>" name="question_id">
                                            <input type="hidden" value="<?php echo csrf_token(); ?>" name="_token">
                                            <fieldset>
                                                <h2>Reason For Reporting</h2>
                                                
                                                <input type="radio" name="group" id="sexual<?= $question->id ?>"  value="Nudity or sexual content" checked>
                            <label for="sexual<?= $question->id ?>">Nudity or sexual content</label>

                            <input type="radio" name="group" id="harasssment<?= $question->id ?>"  value="Harassment or hate speech">
                            <label for="harasssment<?= $question->id ?>">Harassment or hate speech</label>

                            <input type="radio" name="group" id="threatening<?= $question->id ?>"  value="Threatening, violent, or concerning">
                            <label for="threatening<?= $question->id ?>">Threatening, violent, or concerning</label>
                            
                                                <input type="radio" name="group" id="abused<?= $question->id?>"  value="offensive">
                                                <label for="abused<?= $question->id?>">Question is offensive</label>
                                                <input type="radio" name="group" id="spam<?= $question->id?>" value="Spam">
                                                <label for="spam<?= $question->id?>">Spam</label>
                                                <input type="radio" name="group" id="unrelated<?= $question->id?>" value="Unrelated">
                                                <label for="unrelated<?= $question->id?>">Unrelated</label>
                                                <input type="submit" value="Report Question">
                                                <a href="#" class="btn-close">x</a>
                                            </fieldset>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <!-- Report Question Popup End -->
                        <!-- Share Question Popup -->
                            <div id="share-question-<?= $question->id; ?>" class="popup">
                                <div class="popup-holder">
                                    <div class="popup-area">
                                        <div class="reporting-form">
                                            <h2>Select an option</h2>
                                            <div class="custom-shares">
                                            <?php
                                            echo Share::page(asset('get-question-answers/'.$question->id), $question->question, ['class' => 'questions_class', 'id' => $question->id])
                                                    ->facebook($question->question)
                                                    ->twitter($question->question)
                                                    ->googlePlus($question->question);
                                            ?>
                                                <?php if(Auth::user()){ ?>
                                                 <div class="questions_class" onclick="shareInapp('<?= asset('get-question-answers/' . $question->id) ?>', '<?php echo trim(revertTagSpace($question->question)); ?>', '<?= asset('userassets/images/logo-for-scrap.png') ?>')"> <span class="hb_icon_repost"></span> In App</div>
                                                <?php } ?> </div>
                                            <a href="javascript:void(0)" class="btn-close"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- Share Question Popup End -->
                        <li class="qa-adjs-new">
                            <div class="text">
                                <span class="dot-options">
                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    <div class="sort-drop">
                                        <?php if($current_id == $question->user_id && $question->get_answers_count == 0){ ?>
                                        <div class="sort-item active">
                                            <a href="<?php echo asset('update-question/'.$question->id)?>"><i class="fa fa-pencil" aria-hidden="true"></i> <span>Edit Question</span></a>
                                        </div>
                                        <?php }  if($current_id != $question->user_id){ ?>
                                        <div class="sort-item">
                                            <a href="#question-flag<?= $question->id?>" class="flag-icon report btn-popup" id="addFlag<?php echo $question->id;?>" <?php if($question->is_flaged_count) { ?> style="display: none"<?php } ?>  class="flag-icon"><i class="fa fa-flag" aria-hidden="true"></i> <span class="new_span">Report</span></a>
                                            <a id="removeFlag<?php echo $question->id;?>" <?php if(!$question->is_flaged_count) { ?> style="display: none"<?php } ?> href="#" class="flag-icon active"><i class="fa fa-flag" aria-hidden="true"></i> <span class="new_span"style="color:#1383c6">Reported</span></a>
                                        </div>
                                        <?php } ?>
                                        <div class="sort-item">
                                            <a href="#share-question-<?= $question->id; ?>" class="flag-icon btn-popup"><i class="fa fa-share-alt" aria-hidden="true"></i> <span>Share</span></a>
                                        </div>
                                    </div>
                                </span>
                                <header class="header">
                                    <?php if($question->get_answers_count > 19) { ?>
                                                <span class="trending_badge"></span>          
                                                <?php } ?>
                                    <div class="pre-main-image hb_round_img" style="background-image: url(<?php echo getImage($question->getUser->image_path, $question->getUser->avatar);?>)">
                                        <?php if ($question->getUser->special_icon) { ?>
                                            <span class="fest-pre-img" style="background-image: url(<?php echo asset('public/images' . $question->getUser->special_icon) ?>);"></span>
                                        <?php } ?>
                                    </div>
                                    <div class="txt">
                                        <strong>
                                            <a class="<?= getRatingClass($question->getUser->points)?>" href="<?php echo asset('user-profile-detail/'.$question->getUser->id) ?>"><?= $question->getUser->first_name; ?></a>
                                            <span>asks...</span>
                                            <!-- <span><?php //echo timeago($question->created_at); ?></span> -->
                                        </strong>                                    
                                    </div>                                
                                </header>
                                <div class="txt-holder">
                                    <div class="question">
                                        <div class="icon"><img src="<?php echo asset('userassets/images/question-icon.svg')?>" alt="Q"></div>
                                        <div class="q_desc">
                                            <p class="main_q"><?= $question->question; ?></p>
                                            <p class="q_details"><?= $question->description; ?></p>
                                        </div>
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
                                         <?php if($question->get_answers_count > 0){ ?>
                                        <div class="align-left">
                                            <a href="<?php echo asset('get-question-answers/'.$question->id); ?>" class="btn-primary blank">Discuss</a>
                                            <div class="a_counts">
                                                <?= $question->get_answers_count; ?>
                                                <a href="<?php echo asset('get-question-answers/'.$question->id); ?>">Answers</a>
                                            </div>
                                        </div>
                                        <?php }  ?>
                                        <div class="align-right">
                                             <?php if(Auth::user()){ if($question->is_answered_count){ ?>
                                                        <span class="hb_no_answer yes"></span>
                                                         <?php   }else{ ?>
                                                                <span class="hb_no_answer"></span>
                                                            <?php }
                                                            ?>
                                            <a class="like_heart" <?php if($question->get_user_likes_count) { ?> style="display: none"<?php } if (checkMySaveSetting('save_question')) { ?> href="javascript:void(0)" <?php } else { ?> href="#saved-discuss" <?php } ?> class="btn-popup heart" onclick="addQuestionMySave('<?php echo $question->id;?>','addqfav<?php echo $question->id;?>','remqfav<?php echo $question->id;?>')" id="addqfav<?php echo $question->id;?>"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                                            <a class="like_heart" <?php if(!$question->get_user_likes_count) { ?> style="display: none"<?php } ?> href="javascript:void(0)" class="btn-popup fav-icon active" onclick="removeQuestionMySave('<?php echo $question->id;?>','remqfav<?php echo $question->id;?>','addqfav<?php echo $question->id;?>')" id="remqfav<?php echo $question->id;?>"><i style="color:#ff2525;" class="fa fa-heart" aria-hidden="true"></i></a>
                                             <?php } else{ ?>
                                                        <a href="#loginModal" class="new_popup_opener  be-btn like_heart btn-popup heart"  id=""><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                                                         <?php } ?>
                                            <span id="fav_count_<?= $question->id?>"><?= $question->getUserLikes->count(); ?></span>
                                        </div> 
                                   
                                      <?php if ($question->get_answers_count == 0) { ?>
                                                    <?php if (Auth::user()) { if($question->user_id != $current_id ) { ?>

                                                            <a href="<?php echo asset('give-answer/' . $question->id); ?>" class="btn-primary be-btn">Be the 1<sup>st</sup> Bud to answer</a>

                                                    <?php }} else { ?>
                 <a href="#loginModal" class="ho-blue new_popup_opener btn-primary be-btn">Be the 1<sup>st</sup> Bud to answer</a>                                           
            <?php } ?>
                                                    </footer>
                                    <?php } ?>
                                </div>
                            </div>
                        </li>
                        <?php } ?>